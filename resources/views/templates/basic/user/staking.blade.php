@extends($activeTemplate . 'layouts.master2')
@php
    $kyc = getContent('kyc.content', true);

    // Get all user wallets once
    $userWallets = DB::table('user_wallets')
        ->where('user_id', auth()->id())
        ->pluck('balance', 'currency')
        ->toArray();
@endphp

<style>
    .right-modal {
        transform: translateX(100%);
        transition: transform 0.3s ease-in-out;
    }
    .right-modal.open {
        transform: translateX(0);
    }
</style>

@section('content')
<main class="p-2 sm:px-2 flex-1 overflow-auto">

    <h1 class="text-white text-xl mb-4">Pools</h1>
    <div class="mb-6">
        <button onclick="openRightModal()" class="w-full bg-gray-700 text-white py-2 rounded-lg hover:bg-gray-600 transition-colors">
            Your Stakings
        </button>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        @foreach ($stakes as $stake)
        @php
            $balance = $userWallets[$stake->crypto_type] ?? 0;
        @endphp
        <div class="bg-gray-900 rounded-lg p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center">
                    <img src="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/refs/heads/master/svg/color/{{ strtolower($stake->crypto_type) }}.svg" alt="{{ $stake->crypto_type }}" class="w-10 h-10" />
                </div>
                <div>
                    <h2 class="text-white">{{ $stake->name }}</h2>
                    <p class="text-gray-500">{{ $stake->crypto_type }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-500">Minimum</span>
                    <span class="text-white">{{ $stake->minimum }} {{ $stake->crypto_type }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Maximum</span>
                    <span class="text-white">{{ $stake->maximum }} {{ $stake->crypto_type }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Cycle</span>
                    <span class="text-white">1 Year</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Your Balance</span>
                    <span class="text-white">{{ $balance }} {{ $stake->crypto_type }}</span>
                </div>
                <button
                    onclick="openModal('{{ $stake->crypto_type }}', '{{ $stake->roi }}', '12', '{{ $balance }}')"
                    class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition-colors">
                    Stake
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Staking Modal -->
    <div id="stakeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-gray-900 p-6 rounded-lg w-full max-w-md">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg text-white">Stake <span id="selectedCrypto"></span></h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-white text-xl">&times;</button>
            </div>

            <form action="{{ route('user.staking.store') }}" method="POST">
                @csrf
                <input type="hidden" name="crypto_type" id="cryptoTypeInput">

                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-500 mb-2">Amount:</label>
                        <div class="flex gap-2">
                            <input type="number" step="any" name="amount" id="stakeAmount" class="flex-1 bg-gray-800 rounded px-3 py-2 text-white" />
                            <span class="text-white flex items-center" id="cryptoSymbol"></span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-500 mb-2">Current <span id="currentCrypto"></span> balance:</label>
                        <p class="text-white"><span id="userBalance">0</span> <span id="balanceCrypto"></span></p>
                    </div>

                    <div>
                        <label class="block text-gray-500 mb-2">Duration:</label>
                        <select name="duration" class="w-full bg-gray-800 rounded px-3 py-2 text-white">
                            <option value="90">3 Months</option>
                            <option value="180">6 Months</option>
                            <option value="270">9 Months</option>
                            <option value="365">12 Months</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-500 mb-2">APY:</label>
                        <p class="flex gap-2 text-white">
                            <span id="roiDisplay">0</span>%
                        </p>
                    </div>

                    <button type="submit" class="w-full bg-gray-700 text-white py-2 rounded-lg hover:bg-gray-600 transition-colors">
                        Stake
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Side Modal -->
    <div id="rightModal" class="right-modal fixed inset-y-0 right-0 bg-gray-900 w-80 p-6 overflow-auto">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg text-white">Your Stakings</h3>
            <button onclick="closeRightModal()" class="text-gray-500 hover:text-white text-xl">&times;</button>
        </div>

        <div class="space-y-4">
            @if($getUserStakes->isEmpty())
                <p class="text-gray-500">No records found.</p>
            @else
                @foreach ($getUserStakes as $getUserStake)
                <div class="bg-gray-800 rounded-lg p-4">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center">
                            <img src="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/refs/heads/master/svg/color/{{ strtolower($getUserStake->crypto_type) }}.svg" alt="{{ $getUserStake->crypto_type }}" class="w-10 h-10" />
                        </div>
                        <div>
                            <h2 class="text-white">{{ $getUserStake->name ?? $getUserStake->crypto_type }}</h2>
                            <p class="text-gray-500">{{ $getUserStake->crypto_type }}</p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Amount</span>
                            <span class="text-white">{{ $getUserStake->amount }} {{ $getUserStake->crypto_type }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Duration</span>
                            <span class="text-white">{{ $getUserStake->duration }} days</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">APY</span>
                            <span class="text-white">{{ $getUserStake->roi }}%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Daily Profit</span>
                            <span class="text-white">{{ number_format((floatval($getUserStake->amount) * floatval($getUserStake->roi) / 100) / floatval($getUserStake->duration), 2) }} {{ $getUserStake->crypto_type }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Total Profit</span>
                            <span class="text-white">{{ number_format(floatval($getUserStake->amount) * floatval($getUserStake->roi) / 100, 2) }} {{ $getUserStake->crypto_type }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

</main>

<script>
    function openModal(crypto, roi, duration, balance) {
        document.getElementById('stakeModal').classList.remove('hidden');
        document.getElementById('selectedCrypto').textContent = crypto;
        document.getElementById('cryptoTypeInput').value = crypto;
        document.getElementById('roiDisplay').textContent = roi;
        document.getElementById('cryptoSymbol').textContent = crypto;
        document.getElementById('currentCrypto').textContent = crypto;
        document.getElementById('balanceCrypto').textContent = crypto;
        document.getElementById('userBalance').textContent = balance;
    }

    function closeModal() {
        document.getElementById('stakeModal').classList.add('hidden');
    }

    function openRightModal() {
        document.getElementById('rightModal').classList.add('open');
    }

    function closeRightModal() {
        document.getElementById('rightModal').classList.remove('open');
    }
</script>
@endsection
