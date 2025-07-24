<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\User;
use App\Enums\OrderStatus;
use App\Enums\OrderDealerAssignmentStatus;
use App\Enums\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HandleTimedOutOrders extends Command
{
    protected $signature = 'app:handle-timed-out-orders';

    protected $description = 'Find orders that passed the acceptance deadline and try to re-assign them to a new dealer.';

    public function handle()
    {
        $this->info('Mencari pesanan yang melewati batas waktu...');

        $timedOutOrders = Order::where('status', OrderStatus::PENDING_DEALER_ACCEPTANCE)
            ->where('acceptance_deadline', '<', Carbon::now())
            ->get();

        if ($timedOutOrders->isEmpty()) {
            $this->info('Tidak ada pesanan yang perlu diproses.');
            return;
        }

        foreach ($timedOutOrders as $order) {
            $this->processOrder($order);
        }

        $this->info('Selesai memproses ' . $timedOutOrders->count() . ' pesanan.');
    }

    protected function processOrder(Order $order)
    {
        DB::beginTransaction();
        try {
            $lastAssignment = $order->assignments()->latest('assigned_at')->first();
            if ($lastAssignment && $lastAssignment->status === OrderDealerAssignmentStatus::OFFERED) {
                $lastAssignment->update([
                    'status' => OrderDealerAssignmentStatus::TIMED_OUT,
                    'handled_at' => Carbon::now(),
                ]);
            }

            $newDealer = $this->findNewDealerFor($order);

            if ($newDealer) {
                $order->update([
                    'dealer_id' => $newDealer->id,
                    'status' => OrderStatus::PENDING_DEALER_ACCEPTANCE,
                    'acceptance_deadline' => Carbon::now()->addHours(3),
                ]);

                $order->assignments()->create([
                    'dealer_id' => $newDealer->id,
                    'status' => OrderDealerAssignmentStatus::OFFERED,
                    'assigned_at' => Carbon::now(),
                ]);

                Log::info("Pesanan #{$order->id} berhasil dialihkan ke dealer #{$newDealer->id}");
            } else {
                $order->update(['status' => OrderStatus::CANCELLED]);
                Log::warning("Pesanan #{$order->id} dibatalkan, tidak ada dealer lain yang ditemukan.");
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal memproses pesanan #{$order->id}: " . $e->getMessage());
        }
    }

    protected function findNewDealerFor(Order $order)
    {
        $productIds = $order->items->pluck('produk_id')->toArray();
        $itemQuantities = $order->items->pluck('quantity', 'produk_id');
        $excludedDealerIds = $order->assignments->pluck('dealer_id')->toArray();
        $customer = $order->customer;

        $potentialDealerIds = DB::table('inventories')
            ->select('user_id')
            ->whereIn('produk_id', $productIds)
            ->whereNotIn('user_id', $excludedDealerIds)
            ->where(function ($query) use ($itemQuantities) {
                foreach ($itemQuantities as $productId => $quantity) {
                    $query->orWhere(function ($q) use ($productId, $quantity) {
                        $q->where('produk_id', $productId)
                            ->where('quantity', '>=', $quantity);
                    });
                }
            })
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('users')
                    ->whereColumn('users.id', 'inventories.user_id')
                    ->where('users.role', Role::DEALER);
            })
            ->groupBy('user_id')
            ->having(DB::raw('count(*)'), '=', count($productIds))
            ->pluck('user_id');

        if ($potentialDealerIds->isEmpty()) {
            return null;
        }

        $dealers = User::whereIn('id', $potentialDealerIds)->get();

        return $dealers->firstWhere('city', $customer->city)
            ?? $dealers->firstWhere('province', $customer->province)
            ?? $dealers->first();
    }
}
