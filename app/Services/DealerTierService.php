<?php
namespace App\Services;

use App\Models\User;
use App\Models\DealerTier;
use Illuminate\Support\Facades\DB;

class DealerTierService
{
    public function getTierForDealer(User $dealer)
    {
        $average = $this->calculateAverageMonthlyPurchase($dealer);
        
        $tier = DealerTier::where('min_monthly_purchase', '<=', $average)
                          ->orderBy('min_monthly_purchase', 'desc')
                          ->first();

        return $tier ?? DealerTier::where('name', 'Bronze')->first();
    }

    private function calculateAverageMonthlyPurchase(User $dealer, int $months = 6)
    {
        $purchases = $dealer->stockOrders()
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths($months))
            ->select(
                DB::raw('SUM(total_amount) as total'),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
            )
            ->groupBy('month')
            ->get();
        
        if ($purchases->isEmpty()) {
            return 0;
        }

        $totalPurchase = $purchases->sum('total');
        $numberOfMonths = $purchases->count();
        
        return $totalPurchase / $numberOfMonths;
    }
}