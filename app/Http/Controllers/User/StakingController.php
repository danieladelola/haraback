<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StakingController extends Controller
{
    public function index()
    {
        $pageTitle = 'Staking';
        $stakes = DB::table('stakes')->get();

        $getUserStakes = DB::table('users_stakes')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Template::user.staking', compact('pageTitle', 'getUserStakes', 'stakes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'crypto_type' => 'required|string',
            'amount'      => 'required|numeric',
            'duration'    => 'required|integer|min:1',
        ]);

        $userId   = auth()->id();
        $crypto   = strtoupper(trim($request->crypto_type));
        $amount   = (float) $request->amount;
        $duration = (int) $request->duration;

        // Find stake settings from admin table
        $stake = DB::table('stakes')
            ->whereRaw('LOWER(crypto_type) = ?', [strtolower($crypto)])
            ->first();

        if (!$stake) {
            return back()->withNotify([['error', 'Invalid crypto type']]);
        }

        // ✅ Use your actual DB columns here (check with SHOW COLUMNS)
        $minStake = (float) ($stake->minimum ?? 0);  // <-- adjust this name
        $maxStake = (float) ($stake->maximum ?? 0);  // <-- adjust this name
        $roi      = $stake->roi ?? 0;

        // Check minimum
        if ($amount < $minStake) {
            return back()->withNotify([
                ['error', "Minimum stake for {$crypto} is {$minStake} {$crypto}"]
            ]);
        }

        // Check maximum
        if ($maxStake > 0 && $amount > $maxStake) {
            return back()->withNotify([
                ['error', "Maximum stake for {$crypto} is {$maxStake} {$crypto}"]
            ]);
        }

        // Check balance
        $wallet = DB::table('user_wallets')
            ->where('user_id', $userId)
            ->where('currency', $crypto)
            ->first();

        $balance = (float) ($wallet->balance ?? 0);

        if ($balance < $amount) {
            return back()->withNotify([['error', 'Insufficient balance']]);
        }

        // Deduct and insert
        DB::transaction(function () use ($userId, $crypto, $amount, $duration, $roi) {
            DB::table('user_wallets')
                ->where('user_id', $userId)
                ->where('currency', $crypto)
                ->decrement('balance', $amount);

            DB::table('users_stakes')->insert([
                'user_id'     => $userId,
                'crypto_type' => $crypto,
                'amount'      => $amount,
                'duration'    => $duration,
                'roi'         => $roi,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        });

        return back()->withNotify([['success', 'Staking successful']]);
    }
}
