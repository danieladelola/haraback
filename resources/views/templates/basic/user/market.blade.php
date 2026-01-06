@extends($activeTemplate . 'layouts.master2')

@section('content')
<main class="p-2 sm:px-2 flex-1 overflow-auto bg-black text-white">

    <div class="container mx-auto p-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-white">Market Assets</h1>
            <div class="text-sm text-gray-400">Last updated: <span id="lastUpdated"></span></div>
        </div>

        <!-- Filter Section -->
        <div class="mb-8 bg-gray-900 p-4 rounded-lg border border-gray-800">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="w-full md:w-auto">
                    <label for="assetType" class="block text-sm font-medium text-gray-300 mb-1">Asset Type</label>
                    <select id="assetType" class="bg-gray-800 text-white rounded-lg p-2 w-full border border-gray-700 focus:border-blue-500 focus:ring-blue-500">
                        <option value="all">All Assets</option>
                        <option value="fiat">Fiat Currencies</option>
                        <option value="crypto">Cryptocurrencies</option>
                        <option value="stock">Stocks</option>
                    </select>
                </div>
                <div class="w-full md:w-auto">
                    <label for="searchAsset" class="block text-sm font-medium text-gray-300 mb-1">Search</label>
                    <input type="text" id="searchAsset" placeholder="Search assets..." class="bg-gray-800 text-white rounded-lg p-2 w-full border border-gray-700 focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="w-full md:w-auto">
                    <label for="sortBy" class="block text-sm font-medium text-gray-300 mb-1">Sort By</label>
                    <select id="sortBy" class="bg-gray-800 text-white rounded-lg p-2 w-full border border-gray-700 focus:border-blue-500 focus:ring-blue-500">
                        <option value="name">Name (A-Z)</option>
                        <option value="name_desc">Name (Z-A)</option>
                        <option value="price">Price (Low-High)</option>
                        <option value="price_desc">Price (High-Low)</option>
                        <option value="change">24h Change (Low-High)</option>
                        <option value="change_desc">24h Change (High-Low)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Assets Table -->
        <div class="bg-gray-900 rounded-lg overflow-hidden border border-gray-800">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-800">
                    <thead class="bg-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Asset</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Price (USD)</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">24h Change</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Market Cap</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Volume (24h)</th>
                            {{-- <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody id="assetsTableBody" class="bg-gray-900 divide-y divide-gray-800">
                        <!-- Loading state -->
                        <tr id="loadingRow">
                            <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                                <div class="flex justify-center items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Loading market data...
                                </div>
                            </td>
                        </tr>
                        <!-- Error state (hidden by default) -->
                        <tr id="errorRow" class="hidden">
                            <td colspan="6" class="px-6 py-4 text-center text-red-500">
                                Failed to load market data. Please try again later.
                            </td>
                        </tr>
                        <!-- Empty state (hidden by default) -->
                        <tr id="emptyRow" class="hidden">
                            <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                                No assets found matching your criteria.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-800 px-4 py-3 flex items-center justify-between border-t border-gray-700 sm:px-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="#" id="prevPageMobile" class="relative inline-flex items-center px-4 py-2 border border-gray-600 text-sm font-medium rounded-md text-white bg-gray-700 hover:bg-gray-600"> Previous </a>
                    <a href="#" id="nextPageMobile" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-600 text-sm font-medium rounded-md text-white bg-gray-700 hover:bg-gray-600"> Next </a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-300">
                            Showing <span id="paginationFrom" class="font-medium">1</span> to <span id="paginationTo" class="font-medium">10</span> of <span id="paginationTotal" class="font-medium">100</span> results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="#" id="prevPage" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-700 bg-gray-700 text-sm font-medium text-gray-300 hover:bg-gray-600">
                                <span class="sr-only">Previous</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <div id="paginationNumbers" class="flex">
                                <!-- Page numbers will be inserted here -->
                            </div>
                            <a href="#" id="nextPage" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-700 bg-gray-700 text-sm font-medium text-gray-300 hover:bg-gray-600">
                                <span class="sr-only">Next</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // DOM elements
        const assetTypeSelect = document.getElementById('assetType');
        const searchInput = document.getElementById('searchAsset');
        const sortBySelect = document.getElementById('sortBy');
        const assetsTableBody = document.getElementById('assetsTableBody');
        const loadingRow = document.getElementById('loadingRow');
        const errorRow = document.getElementById('errorRow');
        const emptyRow = document.getElementById('emptyRow');
        const lastUpdatedEl = document.getElementById('lastUpdated');

        // Pagination elements
        const prevPageMobile = document.getElementById('prevPageMobile');
        const nextPageMobile = document.getElementById('nextPageMobile');
        const prevPage = document.getElementById('prevPage');
        const nextPage = document.getElementById('nextPage');
        const paginationNumbers = document.getElementById('paginationNumbers');
        const paginationFrom = document.getElementById('paginationFrom');
        const paginationTo = document.getElementById('paginationTo');
        const paginationTotal = document.getElementById('paginationTotal');

        // Pagination variables
        let currentPage = 1;
        const itemsPerPage = 20;
        let totalItems = 0;
        let filteredAssets = [];

        // Format numbers
        function formatNumber(num, decimals = 2) {
            if (isNaN(num)) return '0.00';
            return num.toLocaleString(undefined, {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals
            });
        }

        // Format large numbers (millions, billions)
        function formatLargeNumber(num) {
            if (isNaN(num)) return '$0.00';

            if (num >= 1000000000000) {
                return '$' + formatNumber(num / 1000000000000) + 'T';
            }
            if (num >= 1000000000) {
                return '$' + formatNumber(num / 1000000000) + 'B';
            }
            if (num >= 1000000) {
                return '$' + formatNumber(num / 1000000) + 'M';
            }
            return '$' + formatNumber(num);
        }

        // Get crypto icon URL
        function getCryptoIcon(symbol) {
            const symbolLower = symbol.toLowerCase();
            // Use CoinGecko's API for crypto icons
            return `https://cryptologos.cc/logos/${symbolLower}-${symbolLower}-logo.png?v=025`;
        }

        // Get fiat icon URL - using flag images
        function getFiatIcon(symbol) {
            const currencyFlags = {
                'USD': 'us', 'EUR': 'eu', 'GBP': 'gb', 'JPY': 'jp', 'AUD': 'au',
                'CAD': 'ca', 'CHF': 'ch', 'CNY': 'cn', 'NZD': 'nz', 'SGD': 'sg',
                'HKD': 'hk', 'SEK': 'se', 'NOK': 'no', 'DKK': 'dk', 'KRW': 'kr',
                'INR': 'in', 'BRL': 'br', 'RUB': 'ru', 'ZAR': 'za', 'MXN': 'mx',
                'IDR': 'id', 'MYR': 'my', 'THB': 'th', 'TRY': 'tr', 'SAR': 'sa',
                'AED': 'ae', 'ILS': 'il', 'PLN': 'pl', 'PHP': 'ph', 'CZK': 'cz',
                'HUF': 'hu', 'RON': 'ro', 'ISK': 'is', 'HRK': 'hr', 'BGN': 'bg'
            };
            const countryCode = currencyFlags[symbol] || 'un';
            return `https://flagcdn.com/48x36/${countryCode}.png`;
        }

        // Get stock icon URL
        function getStockIcon(symbol) {
            // Use IEX Cloud API for stock logos (free tier available)
            return `https://storage.googleapis.com/iex/api/logos/${symbol}.png`;
        }

        // Get asset icon with multiple fallbacks
        function getAssetIcon(asset) {
            try {
                if (asset.type === 'crypto') {
                    return asset.image || getCryptoIcon(asset.symbol);
                } else if (asset.type === 'fiat') {
                    return getFiatIcon(asset.symbol);
                } else if (asset.type === 'stock') {
                    return getStockIcon(asset.symbol);
                }
            } catch (e) {
                console.error('Error getting icon:', e);
            }
            // Final fallback - first letter of symbol on gray background
            return `https://via.placeholder.com/48/1f2937/FFFFFF?text=${asset.symbol.substring(0,1)}`;
        }

        // Fetch crypto data from CoinGecko API
        async function fetchCryptoData() {
            try {
                const response = await fetch('https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=250&page=1&sparkline=false&price_change_percentage=24h');
                if (!response.ok) throw new Error('API response not OK');
                const data = await response.json();

                return data.map(crypto => ({
                    symbol: crypto.symbol.toUpperCase(),
                    name: crypto.name,
                    type: 'crypto',
                    price: crypto.current_price,
                    change24h: crypto.price_change_percentage_24h,
                    marketCap: crypto.market_cap,
                    volume: crypto.total_volume,
                    image: crypto.image
                }));
            } catch (error) {
                console.error('Error fetching crypto data:', error);
                return [];
            }
        }

        // Fetch fiat data (mock - in production use a Forex API)
        async function fetchFiatData() {
            const fiats = [
                { symbol: 'USD', name: 'US Dollar', rate: 1.0, change24h: 0 },
                { symbol: 'EUR', name: 'Euro', rate: 0.93, change24h: -0.12 },
                { symbol: 'GBP', name: 'British Pound', rate: 0.79, change24h: 0.25 },
                { symbol: 'JPY', name: 'Japanese Yen', rate: 151.23, change24h: -0.45 },
                { symbol: 'AUD', name: 'Australian Dollar', rate: 1.52, change24h: 0.18 },
                { symbol: 'CAD', name: 'Canadian Dollar', rate: 1.36, change24h: 0.07 },
                { symbol: 'CHF', name: 'Swiss Franc', rate: 0.91, change24h: -0.03 },
                { symbol: 'CNY', name: 'Chinese Yuan', rate: 7.23, change24h: 0.02 },
                { symbol: 'HKD', name: 'Hong Kong Dollar', rate: 7.83, change24h: 0.01 },
                { symbol: 'NZD', name: 'New Zealand Dollar', rate: 1.66, change24h: 0.22 },
                { symbol: 'SEK', name: 'Swedish Krona', rate: 10.68, change24h: -0.15 },
                { symbol: 'KRW', name: 'South Korean Won', rate: 1345.67, change24h: 0.33 },
                { symbol: 'SGD', name: 'Singapore Dollar', rate: 1.35, change24h: 0.08 },
                { symbol: 'NOK', name: 'Norwegian Krone', rate: 10.72, change24h: -0.21 },
                { symbol: 'MXN', name: 'Mexican Peso', rate: 16.83, change24h: 0.42 },
                { symbol: 'INR', name: 'Indian Rupee', rate: 83.42, change24h: -0.07 },
                { symbol: 'BRL', name: 'Brazilian Real', rate: 5.06, change24h: 0.15 },
                { symbol: 'ZAR', name: 'South African Rand', rate: 18.92, change24h: -0.28 },
                { symbol: 'RUB', name: 'Russian Ruble', rate: 92.45, change24h: 0.65 },
                { symbol: 'TRY', name: 'Turkish Lira', rate: 32.12, change24h: -0.52 }
            ];

            return fiats.map(fiat => ({
                ...fiat,
                rate: fiat.rate * (1 + (Math.random() * 0.002 - 0.001)),
                change24h: fiat.change24h + (Math.random() * 0.1 - 0.05),
                marketCap: 1000000000000 * (0.5 + Math.random() * 2),
                volume: 10000000000 * (0.5 + Math.random() * 2),
                type: 'fiat'
            }));
        }

        // Fetch stock data (mock - in production use a stock API)
        async function fetchStockData() {
            const stocks = [
                { symbol: 'AAPL', name: 'Apple Inc.', price: 175.23, change24h: 1.25 },
                { symbol: 'MSFT', name: 'Microsoft Corp.', price: 420.45, change24h: 0.78 },
                { symbol: 'GOOGL', name: 'Alphabet Inc.', price: 155.67, change24h: -0.32 },
                { symbol: 'AMZN', name: 'Amazon.com Inc.', price: 185.34, change24h: 2.15 },
                { symbol: 'TSLA', name: 'Tesla Inc.', price: 175.89, change24h: -1.45 },
                { symbol: 'META', name: 'Meta Platforms', price: 485.32, change24h: 0.92 },
                { symbol: 'NVDA', name: 'NVIDIA Corp.', price: 890.12, change24h: 3.45 },
                { symbol: 'JPM', name: 'JPMorgan Chase', price: 195.67, change24h: -0.56 },
                { symbol: 'V', name: 'Visa Inc.', price: 275.43, change24h: 0.23 },
                { symbol: 'WMT', name: 'Walmart Inc.', price: 59.87, change24h: 0.12 },
                { symbol: 'MA', name: 'Mastercard Inc.', price: 465.32, change24h: 0.45 },
                { symbol: 'PG', name: 'Procter & Gamble', price: 165.78, change24h: -0.23 },
                { symbol: 'JNJ', name: 'Johnson & Johnson', price: 152.34, change24h: 0.15 },
                { symbol: 'HD', name: 'Home Depot Inc.', price: 345.67, change24h: 0.67 },
                { symbol: 'BAC', name: 'Bank of America', price: 37.89, change24h: -0.89 },
                { symbol: 'XOM', name: 'Exxon Mobil Corp.', price: 118.76, change24h: 1.23 },
                { symbol: 'PFE', name: 'Pfizer Inc.', price: 27.65, change24h: -0.45 },
                { symbol: 'DIS', name: 'Walt Disney Co.', price: 102.34, change24h: 0.56 },
                { symbol: 'CSCO', name: 'Cisco Systems', price: 49.87, change24h: -0.12 },
                { symbol: 'KO', name: 'Coca-Cola Co.', price: 59.43, change24h: 0.23 }
            ];

            return stocks.map(stock => ({
                ...stock,
                price: stock.price * (1 + (Math.random() * 0.01 - 0.005)),
                change24h: stock.change24h + (Math.random() * 0.2 - 0.1),
                marketCap: stock.price * (1000000000 + Math.random() * 9000000000),
                volume: stock.price * (10000000 + Math.random() * 90000000),
                type: 'stock'
            }));
        }

        // Fetch all market data
        async function fetchMarketData() {
            loadingRow.classList.remove('hidden');
            errorRow.classList.add('hidden');
            emptyRow.classList.add('hidden');

            try {
                const [cryptoData, fiatData, stockData] = await Promise.all([
                    fetchCryptoData(),
                    fetchFiatData(),
                    fetchStockData()
                ]);

                // Combine all data
                const allAssets = [...cryptoData, ...fiatData, ...stockData];

                // Update last updated time
                lastUpdatedEl.textContent = new Date().toLocaleString();

                return allAssets;
            } catch (error) {
                console.error('Error fetching market data:', error);
                errorRow.classList.remove('hidden');
                return [];
            } finally {
                loadingRow.classList.add('hidden');
            }
        }

        // Sort assets
        function sortAssets(assets, sortBy) {
            return [...assets].sort((a, b) => {
                switch (sortBy) {
                    case 'name':
                        return a.name.localeCompare(b.name);
                    case 'name_desc':
                        return b.name.localeCompare(a.name);
                    case 'price':
                        return a.price - b.price;
                    case 'price_desc':
                        return b.price - a.price;
                    case 'change':
                        return (a.change24h || 0) - (b.change24h || 0);
                    case 'change_desc':
                        return (b.change24h || 0) - (a.change24h || 0);
                    default:
                        return 0;
                }
            });
        }

        // Filter assets
        function filterAssets(assets, typeFilter, searchQuery) {
            return assets.filter(asset => {
                const matchesType = typeFilter === 'all' || asset.type === typeFilter;
                const matchesSearch = searchQuery === '' ||
                    asset.symbol.toLowerCase().includes(searchQuery) ||
                    asset.name.toLowerCase().includes(searchQuery);
                return matchesType && matchesSearch;
            });
        }

        // Render pagination
        function renderPagination(totalItems, currentPage, itemsPerPage) {
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            paginationTotal.textContent = totalItems;
            paginationFrom.textContent = ((currentPage - 1) * itemsPerPage) + 1;
            paginationTo.textContent = Math.min(currentPage * itemsPerPage, totalItems);

            // Clear existing pagination numbers
            paginationNumbers.innerHTML = '';

            // Always show first page
            addPageNumber(1, currentPage);

            // Show ellipsis if needed after first page
            if (currentPage > 3) {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-700 bg-gray-800 text-sm font-medium text-gray-300';
                ellipsis.textContent = '...';
                paginationNumbers.appendChild(ellipsis);
            }

            // Show current page and neighbors
            const startPage = Math.max(2, currentPage - 1);
            const endPage = Math.min(totalPages - 1, currentPage + 1);

            for (let i = startPage; i <= endPage; i++) {
                addPageNumber(i, currentPage);
            }

            // Show ellipsis if needed before last page
            if (currentPage < totalPages - 2) {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-700 bg-gray-800 text-sm font-medium text-gray-300';
                ellipsis.textContent = '...';
                paginationNumbers.appendChild(ellipsis);
            }

            // Always show last page if there are multiple pages
            if (totalPages > 1) {
                addPageNumber(totalPages, currentPage);
            }

            // Enable/disable prev/next buttons
            prevPageMobile.disabled = prevPage.disabled = currentPage === 1;
            nextPageMobile.disabled = nextPage.disabled = currentPage === totalPages;

            if (currentPage === 1) {
                prevPage.classList.add('opacity-50', 'cursor-not-allowed');
                prevPageMobile.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                prevPage.classList.remove('opacity-50', 'cursor-not-allowed');
                prevPageMobile.classList.remove('opacity-50', 'cursor-not-allowed');
            }

            if (currentPage === totalPages) {
                nextPage.classList.add('opacity-50', 'cursor-not-allowed');
                nextPageMobile.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                nextPage.classList.remove('opacity-50', 'cursor-not-allowed');
                nextPageMobile.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        function addPageNumber(page, currentPage) {
            const pageElement = document.createElement('a');
            pageElement.href = '#';
            pageElement.className = `relative inline-flex items-center px-4 py-2 border text-sm font-medium ${
                page === currentPage
                    ? 'z-10 bg-blue-600 border-blue-600 text-white'
                    : 'bg-gray-800 border-gray-700 text-gray-300 hover:bg-gray-700'
            }`;
            pageElement.textContent = page;
            pageElement.addEventListener('click', (e) => {
                e.preventDefault();
                currentPage = page;
                renderAssets();
            });
            paginationNumbers.appendChild(pageElement);
        }

        // Render assets
        async function renderAssets() {
            const typeFilter = assetTypeSelect.value;
            const searchQuery = searchInput.value.toLowerCase();
            const sortBy = sortBySelect.value;

            // Get all assets
            let allAssets = await fetchMarketData();
            if (allAssets.length === 0) return;

            // Filter assets
            filteredAssets = filterAssets(allAssets, typeFilter, searchQuery);

            // Sort assets
            filteredAssets = sortAssets(filteredAssets, sortBy);

            // Update pagination
            totalItems = filteredAssets.length;
            renderPagination(totalItems, currentPage, itemsPerPage);

            // Clear table
            assetsTableBody.innerHTML = '';

            // Show empty state if no assets
            if (filteredAssets.length === 0) {
                emptyRow.classList.remove('hidden');
                assetsTableBody.appendChild(emptyRow);
                return;
            } else {
                emptyRow.classList.add('hidden');
            }

            // Get current page items
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredAssets.length);
            const currentItems = filteredAssets.slice(startIndex, endIndex);

            // Add assets to table
            currentItems.forEach(asset => {
                const change24h = asset.change24h || 0;
                const changeClass = change24h >= 0 ? 'text-green-500' : 'text-red-500';
                const changeIcon = change24h >= 0 ? '▲' : '▼';

                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-800';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full overflow-hidden bg-gray-800 flex items-center justify-center">
                                <img src="${getAssetIcon(asset)}" alt="${asset.symbol}" class="h-8 w-8 object-contain"
                                     onerror="this.onerror=null;this.src='https://via.placeholder.com/48/1f2937/FFFFFF?text=${asset.symbol.substring(0,1)}'">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-white">${asset.symbol}</div>
                                <div class="text-sm text-gray-400">${asset.name}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                        $${formatNumber(asset.price, asset.type === 'fiat' ? 4 : 2)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm ${changeClass}">
                        ${changeIcon} ${Math.abs(change24h).toFixed(2)}%
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                        ${asset.marketCap ? formatLargeNumber(asset.marketCap) : 'N/A'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                        ${asset.volume ? formatLargeNumber(asset.volume) : 'N/A'}
                    </td>

                `;
                assetsTableBody.appendChild(row);
            });
        }

        // Event listeners
        assetTypeSelect.addEventListener('change', () => {
            currentPage = 1;
            renderAssets();
        });

        searchInput.addEventListener('input', () => {
            currentPage = 1;
            renderAssets();
        });

        sortBySelect.addEventListener('change', renderAssets);

        prevPage.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                renderAssets();
            }
        });

        nextPage.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage < Math.ceil(totalItems / itemsPerPage)) {
                currentPage++;
                renderAssets();
            }
        });

        prevPageMobile.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                renderAssets();
            }
        });

        nextPageMobile.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage < Math.ceil(totalItems / itemsPerPage)) {
                currentPage++;
                renderAssets();
            }
        });

        // Initial load
        renderAssets();

        // Refresh data every 5 minutes
        setInterval(renderAssets, 5 * 60 * 1000);
    });
</script>
@endpush
