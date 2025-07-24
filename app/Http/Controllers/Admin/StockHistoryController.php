<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockHistory;
use Illuminate\Http\Request;

class StockHistoryController extends Controller
{
    public function index()
    {
        $histories = StockHistory::with(['produk', 'user'])->latest()->paginate(20);
        return view('admin.inventory.history', compact('histories'));
    }
}
