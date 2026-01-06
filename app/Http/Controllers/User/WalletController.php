<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserWallet;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Show all user wallets
     */
    public function list()
    {
        $pageTitle = 'My Wallets';

        // Fetch all wallets for the logged in user
        $wallets = UserWallet::where('user_id', Auth::id())->get();

        // Add USD value for each wallet
        foreach ($wallets as $wallet) {
            try {
                $price = @file_get_contents(
                    'https://min-api.cryptocompare.com/data/price?fsym=' . strtoupper($wallet->currency) . '&tsyms=USD'
                );
                $priceData = json_decode($price, true);
                $usdPrice = $priceData['USD'] ?? 0;
                $wallet->usd_value = $wallet->balance * $usdPrice;
            } catch (\Exception $e) {
                $wallet->usd_value = null;
            }
        }

        return view('Template::user.wallet.list', compact('pageTitle', 'wallets'));
    }
}
