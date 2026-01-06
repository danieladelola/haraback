@extends($activeTemplate . 'layouts.master2')
@php
    $kyc = getContent('kyc.content', true);
    $userWallets = \App\Models\UserWallet::where('user_id', auth()->id())->get();
@endphp

<style>
    /* Your existing styles */
    .tabs-container {
      width: 100%;
      max-width: 400px;
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .tabs-header {
      display: flex;
      border-bottom: 2px solid #e0e0e0;
    }

    .tab-button {
      flex: 1;
      padding: 10px 15px;
      text-align: center;
      cursor: pointer;
      font-weight: bold;
      color: #555;
      border: none;
      outline: none;
      background: none;
      transition: color 0.3s, background-color 0.3s;
    }

    .tab-button.active {
      color: #ffffff;
      background: #26292c;
    }

    .tabs-content {
      padding: 20px;
    }

    .tab-content {
      display: none;
    }

    .tab-content.active {
      display: block;
    }

    .balance-info {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }
    
    .asset-item {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        cursor: pointer;
    }
    
    .asset-item:hover {
        background-color: #2d3748;
    }
    
    .asset-item img {
        width: 20px;
        height: 20px;
        margin-right: 8px;
    }
    
    .asset-balance {
        margin-left: auto;
        font-size: 12px;
        color: #6b7280;
    }
</style>
@section('content')
<main class="p-2 sm:px-2 flex-1 overflow-auto">

    <div class="p-1 space-y-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-1">
            <!-- Chart and Trades Section -->
            <div class="lg:col-span-2 space-y-2">
                <!-- Trading Chart -->
                <div class="rounded-lg border border-gray-800 bg-black p-4 w-100">
                    <div>
                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container" style="height:10px;width: 6640px">
                            <div class="tradingview-widget-container__widget"
                                style="height:calc(100% - 32px);width:2345px"></div>
                            <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/"
                                    rel="noopener nofollow" target="_blank"><span class="blue-text">Track all
                                        markets on TradingView</span></a></div>
                            <script type="text/javascript"
                                src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js"
                                async>
                                    {
                                        "height": "610",
                                        "symbol": "BINANCE:BTCUSDT",
                                        "interval": "D",
                                        "timezone": "Etc/UTC",
                                        "theme": "dark",
                                        "style": "1",
                                        "locale": "en",
                                        "hide_top_toolbar": true,
                                        "allow_symbol_change": true,
                                        "calendar": false,
                                        "support_host": "https://www.tradingview.com"
                                    }
                                </script>
                        </div>
                        <!-- TradingView Widget END -->
                    </div>
                </div>
            </div>

            <!-- Trading Panel -->
            <div class="rounded-lg border border-gray-800 bg-black p-6">
                <form action="{{ route('user.trade.store') }}" method="post">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Type:</label>
                            <select class="w-full bg-gray-900 border border-gray-700 rounded-md p-2" name="trade_type" id="assetType">
                                <option value="Crypto">Crypto</option>
                            </select>
                        </div>

                        <div class="relative">
                            <label class="block text-sm text-gray-400 mb-1 mt-2">Select Asset:</label>
                            <div class="flex items-center border border-gray-700 rounded-lg bg-gray-800 text-white px-3 py-2">
                                <div class="relative w-full">
                                    <button id="dropdownButton" type="button" class="flex items-center justify-between w-full text-sm bg-gray-700 px-2 py-1 rounded-lg">
                                        <span class="flex items-center">
                                            <img id="selectedIcon" src="https://cryptologos.cc/logos/bitcoin-btc-logo.png" alt="" class="w-4 h-4 mr-2" />
                                            <span id="selectedSymbol">BTC</span>
                                        </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div id="dropdownMenu" class="absolute z-10 hidden mt-2 w-full bg-gray-900 border border-gray-700 rounded-lg shadow-lg left-0 overflow-auto max-h-60">
                                        <div class="p-2 sticky top-0 bg-gray-900">
                                            <input type="text" id="assetSearch" placeholder="Search for assets" class="w-full px-2 py-1 text-sm bg-gray-800 text-white rounded-lg border border-gray-700 placeholder-gray-500 focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                                        </div>
                                        <ul class="max-h-52 overflow-y-auto text-sm" id="assetList">
                                            <!-- Assets will be loaded here by JavaScript -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div id="balanceInfo" class="balance-info">Balance: 0 BTC</div>
                            <input type="hidden" name="assets" id="selectedAssetSymbol" value="BTC" />
                        </div>

                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Amount (USD):</label>
                            <input id="amount" type="text" name="amount" placeholder="100" class="w-full bg-gray-900 border border-gray-700 rounded-md p-2 text-white placeholder-gray-400" />
                        </div>

                        <div>
                            <label class="text-sm text-gray-400 mb-2 block">Current USD Balance: {{ showAmount(auth()->user()->balance) }}</label>
                        </div>
                        <div>
                            <label class="text-sm text-gray-400 mb-2 block">Current Asset Price:</label>
                            <span id="currentAssetPrice" class="text-white">Loading...</span>
                        </div>

                        <div class="flex gap-4 mb-6">
                            <div class="w-1/2">
                                <label class="text-sm text-gray-400 mb-2 block">Stop Loss:</label>
                                <input type="number" name="loss" value="6800" class="w-full bg-gray-900 border border-gray-700 rounded-md p-2">
                            </div>
                            <div class="w-1/2">
                                <label class="text-sm text-gray-400 mb-2 block">Take Profit:</label>
                                <input type="number" name="profit" value="32100" class="w-full bg-gray-900 border border-gray-700 rounded-md p-2">
                            </div>
                        </div>

                        <div>
                            <label class="text-sm text-gray-400 mb-2 block">Duration:</label>
                            <select class="w-full bg-gray-900 border border-gray-700 rounded-md p-2" name="duration">
                                <option>2 minutes</option>
                                <option>5 minutes</option>
                                <option>10 minutes</option>
                            </select>
                        </div>

                        <button class="w-full bg-emerald-500 hover:bg-emerald-600 py-3 rounded-md text-white font-medium" type="submit">
                            Place Trade
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Rest of your existing code for trades section -->
        <!-- ... -->
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownButton = document.getElementById("dropdownButton");
    const dropdownMenu = document.getElementById("dropdownMenu");
    const selectedIcon = document.getElementById("selectedIcon");
    const selectedSymbol = document.getElementById("selectedSymbol");
    const selectedAssetSymbol = document.getElementById("selectedAssetSymbol");
    const assetSearch = document.getElementById("assetSearch");
    const assetList = document.getElementById("assetList");
    const balanceInfo = document.getElementById("balanceInfo");
    const currentAssetPrice = document.getElementById("currentAssetPrice");
    
    // Convert user wallets to a more accessible format
    const userWallets = {};
    @foreach($userWallets as $wallet)
        userWallets["{{ strtolower($wallet->symbol) }}"] = {
            balance: parseFloat("{{ $wallet->balance }}"),
            symbol: "{{ $wallet->symbol }}"
        };
    @endforeach
    
    // Fetch popular cryptocurrencies from CoinGecko
    async function fetchPopularCryptos() {
        try {
            const response = await fetch('https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=100&page=1&sparkline=false', {
                headers: {
                    'x-cg-api-key': 'CG-h8CmYn6uwtiUapYwZSVMSsJX'
                }
            });
            
            if (!response.ok) {
                throw new Error('Failed to fetch cryptocurrencies');
            }
            
            const data = await response.json();
            return data.map(coin => ({
                id: coin.id,
                symbol: coin.symbol.toUpperCase(),
                name: coin.name,
                image: coin.image,
                current_price: coin.current_price
            }));
        } catch (error) {
            console.error('Error fetching cryptocurrencies:', error);
            // Return some default coins if API fails
            return [
                {
                    id: 'bitcoin',
                    symbol: 'BTC',
                    name: 'Bitcoin',
                    image: 'https://cryptologos.cc/logos/bitcoin-btc-logo.png',
                    current_price: 50000
                },
                {
                    id: 'ethereum',
                    symbol: 'ETH',
                    name: 'Ethereum',
                    image: 'https://cryptologos.cc/logos/ethereum-eth-logo.png',
                    current_price: 3000
                },
                {
                    id: 'binancecoin',
                    symbol: 'BNB',
                    name: 'Binance Coin',
                    image: 'https://cryptologos.cc/logos/bnb-bnb-logo.png',
                    current_price: 400
                }
            ];
        }
    }
    
    // Initialize the asset dropdown
    async function initializeAssetDropdown() {
        const cryptos = await fetchPopularCryptos();
        
        // Populate the asset list
        assetList.innerHTML = '';
        cryptos.forEach(crypto => {
            const walletBalance = userWallets[crypto.symbol.toLowerCase()] ? 
                userWallets[crypto.symbol.toLowerCase()].balance : 0;
            
            const listItem = document.createElement('li');
            listItem.className = 'asset-item';
            listItem.innerHTML = `
                <img src="${crypto.image}" alt="${crypto.symbol}" class="w-5 h-5" onerror="this.onerror=null; this.src='https://cryptologos.cc/logos/default-fallback-logo.png'">
                <span>${crypto.symbol} - ${crypto.name}</span>
                <span class="asset-balance">${walletBalance.toFixed(6)} ${crypto.symbol}</span>
            `;
            
            listItem.addEventListener('click', () => {
                selectedIcon.src = crypto.image;
                selectedSymbol.textContent = crypto.symbol;
                selectedAssetSymbol.value = crypto.symbol;
                balanceInfo.textContent = `Balance: ${walletBalance.toFixed(6)} ${crypto.symbol}`;
                currentAssetPrice.textContent = `$${crypto.current_price}`;
                dropdownMenu.classList.add('hidden');
            });
            
            assetList.appendChild(listItem);
        });
        
        // Set initial price for BTC
        const btc = cryptos.find(c => c.symbol === 'BTC');
        if (btc) {
            currentAssetPrice.textContent = `$${btc.current_price}`;
        }
    }
    
    // Search functionality
    assetSearch.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const items = assetList.querySelectorAll('.asset-item');
        
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(searchTerm) ? 'flex' : 'none';
        });
    });
    
    // Toggle dropdown
    dropdownButton.addEventListener('click', function() {
        dropdownMenu.classList.toggle('hidden');
        if (!dropdownMenu.classList.contains('hidden')) {
            assetSearch.focus();
        }
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
    
    // Initialize the dropdown
    initializeAssetDropdown();
    
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const amount = parseFloat(document.getElementById('amount').value);
        const selectedAsset = selectedAssetSymbol.value;
        
        if (!selectedAsset) {
            e.preventDefault();
            alert('Please select a cryptocurrency to trade.');
            return;
        }
        
        if (!amount || amount <= 0) {
            e.preventDefault();
            alert('Please enter a valid amount.');
            return;
        }
        
        // You can add additional validation here if needed
    });
});
</script>
@endsection