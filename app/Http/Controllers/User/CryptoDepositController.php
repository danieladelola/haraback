<?php
namespace App\Http\Controllers\User;
use App\Constants\Status;
use App\Models\Gateway;
use App\Models\CryptoDeposit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CryptoDepositController extends Controller
{
    // Show deposit page + history
    public function cryptoDeposit()
    {
        $pageTitle = 'Crypto Deposit';
        $user = auth()->user();
        $gateways = Gateway::where('status', Status::ENABLE)->get();
        $cryptoDeposits = CryptoDeposit::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Template::user.crypto_deposit', compact('pageTitle', 'gateways', 'cryptoDeposits'));
    }

    // Get live price for crypto
    public function getLivePrice($currency)
    {
        $currency = strtoupper($currency);
        $price = $this->getUsdPrice($currency);
        
        if ($price > 0) {
            return response()->json([
                'success' => true,
                'price' => $price,
                'currency' => $currency
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unable to fetch price'
        ], 400);
    }

    // Store new crypto deposit
    public function store(Request $request)
    {
        $request->validate([
            'amount'   => 'required|numeric|min:0.0001',
            'currency' => 'required|string',
            'network'  => 'nullable|string',
            'proof'    => 'nullable|string',
        ]);

        $user = auth()->user();
        $amount = (float) $request->amount;
        $currency = strtoupper($request->currency);

        // Fetch USD value
        $usd_equivalent = $this->calculateUsdEquivalent($currency, $amount);

        $deposit = new CryptoDeposit();
        $deposit->user_id = $user->id;
        $deposit->currency = $currency;
        $deposit->network = $request->network;
        $deposit->amount = $amount;
        $deposit->usd_equivalent = $usd_equivalent;
        $deposit->reference = strtoupper(Str::random(10));
        $deposit->proof = $request->proof;
        $deposit->status = 2; // pending admin approval
        $deposit->type = 'crypto';
        $deposit->save();

        $notify[] = ['success', 'Crypto deposit submitted! USD equivalent: $' . number_format($usd_equivalent, 2)];
        return back()->withNotify($notify);
    }

    // Calculate USD equivalent for all cryptos
    private function calculateUsdEquivalent($currency, $amount)
    {
        $price = $this->getUsdPrice($currency);
        return $amount * $price;
    }

    // Get USD price for a cryptocurrency
    private function getUsdPrice($currency)
    {
        $currency = strtoupper($currency);
        
        $ids = [
            'BTC'  => 'bitcoin',
            'ETH'  => 'ethereum',
            'USDT' => 'tether',
            'USDC' => 'usd-coin',
            'SOL'  => 'solana',
            'TRX'  => 'tron',
            'XRP'  => 'ripple'
        ];

        $id = $ids[$currency] ?? strtolower($currency);

        try {
            $response = Http::retry(3, 100)->timeout(10)->get("https://api.coingecko.com/api/v3/simple/price", [
                'ids'           => $id,
                'vs_currencies' => 'usd'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data[$id]['usd'] ?? 0;
            }

            return 0;
        } catch (\Exception $e) {
            Log::error('CoinGecko API Error', [
                'error'    => $e->getMessage(),
                'currency' => $currency
            ]);
            return 0;
        }
    }
}