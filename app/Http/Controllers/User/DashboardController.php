<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Crypto;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get all supported cryptos
        $cryptos = Crypto::all();

        // Attach user balance to each crypto
        foreach ($cryptos as $crypto) {
            $crypto->user_balance = $user->wallets()
                ->where('currency', $crypto->symbol)
                ->value('balance') ?? 0;
        }

        // Pass to view
        return view('templates.basic.user.dashboard', compact('cryptos'));
    }
}
