@extends($activeTemplate . 'layouts.master2')

@section('content')
<main class="p-2 sm:px-2 flex-1 overflow-auto">
    <div class="grid grid-cols-1 ld:grid-cols-2 gap-12">
        <div class="p-4 bg-black rounded-lg shadow">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-xl font-semibold text-white">Withdraw</h1>
                <button  id="openModal"  class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-lg text-white">
                 Withdraw
                </button>
            </div>

            <!-- Deposits Table -->
            <div class="w-full overflow-x-auto">
             @include($activeTemplate.'user.withdraw.log')
            </div>
            <div
            id="withdrawModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden"
          >
            <div class="bg-gray-800 text-white rounded-lg p-6 w-full max-w-md relative">
              <!-- Close Button -->
              <button
                id="closeModal"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-200"
              >
                &times;
              </button>

              <!-- Modal Content -->
              <h3 class="text-lg font-bold mb-4">Withdraw</h3>
              <p class="text-gray-400 mb-4">
                To make a withdrawal, select your balance, amount and verify the address you wish for payment to be made into.
              </p>
              <form action="{{ route('user.withdraw.money') }}" method="post" class="withdraw-form" id="withdrawForm">
                @csrf
                <input type="hidden" name="method_code" id="methodCode" value="CRYPTO">

                <!-- Crypto Selection -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1 text-gray-300">Cryptocurrency:</label>
                    <select id="cryptoCurrency" name="crypto_currency" class="bg-gray-700 border border-gray-600 text-white rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="" selected disabled>Select cryptocurrency</option>
                        <option value="BTC">Bitcoin (BTC)</option>
                        <option value="ETH">Ethereum (ETH)</option>
                        <option value="USDT">Tether (USDT)</option>
                        <option value="USDC">USD Coin (USDC)</option>
                        <option value="SOL">Solana (SOL)</option>
                        <option value="TRX">Tron (TRX)</option>
                    </select>
                </div>

                <!-- Network Selection -->
                <div id="networkSelectionContainer" class="mb-4 hidden">
                    <label class="block text-sm font-medium mb-1 text-gray-300">Network:</label>
                    <select id="cryptoNetwork" name="network" class="bg-gray-700 border border-gray-600 text-white rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="" selected disabled>Select network</option>
                    </select>
                </div>

                <!-- Wallet Address Input -->
                <div id="walletAddressContainer" class="mb-4 hidden">
                    <label class="block text-sm font-medium mb-1 text-gray-300">Your Wallet Address:</label>
                    <input
                        type="text"
                        name="wallet_address"
                        class="bg-gray-700 border border-gray-600 text-white rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter your wallet address"
                        required
                    >
                    <p class="text-xs text-red-400 mt-1">Make sure this address supports the selected network</p>
                </div>

                <!-- Amount Input -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1 text-gray-300" for="amount">Amount:</label>
                    <div class="flex gap-2 items-center">
                        <input
                            type="number"
                            id="amount"
                            name="amount"
                            placeholder="10.00"
                            class="bg-gray-700 border border-gray-600 text-white rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('amount') }}"
                            step="0.01"
                            min="10"
                            required
                        />
                        <span class="text-gray-300">USD</span>
                    </div>
                    <div class="text-xs text-gray-400 mt-1">
                        Available: <span class="text-white">{{ showAmount(auth()->user()->balance) }} {{ gs('cur_text') }}</span>
                    </div>
                </div>

                <!-- Withdraw Button -->
                <button
                    class="bg-blue-600 text-white w-full py-2 rounded-md hover:bg-blue-700 transition-colors duration-200"
                    type="submit"
                    id="submitButton"
                >
                    Confirm Withdrawal
                </button>
              </form>
            </div>
            </div>
          </div>

        </div>
    </div>
</main>

@push('style')
<style>
    .tooltip {
        position: relative;
    }

    .tooltip:before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        padding: 4px 8px;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s, visibility 0.2s;
    }

    .tooltip:hover:before {
        opacity: 1;
        visibility: visible;
    }
</style>
@endpush


<script>
    const openModalButton = document.getElementById("openModal");
    const closeModalButton = document.getElementById("closeModal");
    const modal = document.getElementById("withdrawModal");

    // Open modal
    openModalButton.addEventListener("click", () => {
      modal.classList.remove("hidden");
    });

    // Close modal
    closeModalButton.addEventListener("click", () => {
      modal.classList.add("hidden");
    });

    // Close modal when clicking outside of it
    window.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.classList.add("hidden");
      }
    });
  </script>

<script>
const cryptoNetworks = {
    BTC: [{ name: 'Bitcoin Network', value: 'BTC' }],
    ETH: [{ name: 'Ethereum Network (ERC20)', value: 'ETH' }],
    USDT: [
        { name: 'Ethereum Network (ERC20)', value: 'USDT_ERC20' },
        { name: 'Tron Network (TRC20)', value: 'USDT_TRC20' },
        { name: 'Solana Network', value: 'USDT_SOL' }
    ],
    USDC: [
        { name: 'Ethereum Network (ERC20)', value: 'USDC_ERC20' },
        { name: 'Tron Network (TRC20)', value: 'USDC_TRC20' },
        { name: 'Solana Network', value: 'USDC_SOL' }
    ],
    SOL: [{ name: 'Solana Network', value: 'SOL' }],
    TRX: [{ name: 'Tron Network', value: 'TRX' }]
};

const cryptoCurrencySelect = document.getElementById("cryptoCurrency");
const networkSelectionContainer = document.getElementById("networkSelectionContainer");
const cryptoNetworkSelect = document.getElementById("cryptoNetwork");
const walletAddressContainer = document.getElementById("walletAddressContainer");

cryptoCurrencySelect.addEventListener('change', function() {
    const selectedCrypto = this.value;
    cryptoNetworkSelect.innerHTML = '<option value="" selected disabled>Select network</option>';
    walletAddressContainer.classList.add('hidden');

    if (selectedCrypto && cryptoNetworks[selectedCrypto]) {
        cryptoNetworks[selectedCrypto].forEach(network => {
            const option = document.createElement('option');
            option.value = network.value;
            option.textContent = network.name;
            cryptoNetworkSelect.appendChild(option);
        });
        networkSelectionContainer.classList.remove('hidden');
    } else {
        networkSelectionContainer.classList.add('hidden');
    }
});

cryptoNetworkSelect.addEventListener('change', function() {
    if (this.value) {
        walletAddressContainer.classList.remove('hidden');
    } else {
        walletAddressContainer.classList.add('hidden');
    }
});
</script>

@endsection
