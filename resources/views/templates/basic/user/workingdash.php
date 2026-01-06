@extends($activeTemplate . 'layouts.master2')
@php
    $kyc = getContent('kyc.content', true);
@endphp

<style>
    :root {
        --primary: #6c5ce7;
        --primary-dark: #5649c0;
        --secondary: #3f37c9;
        --success: #00b894;
        --danger: #d63031;
        --warning: #fdcb6e;
        --info: #0984e3;
        --light: #2d3436;
        --dark: #1e272e;
        --gray: #636e72;
        --gray-light: #2d3436;
        --white: #ffffff;
        --card-bg: #1e272e;
        --card-border: #2d3436;
        --text-primary: #f5f6fa;
        --text-secondary: #dfe6e9;
    }

    /* Base Styles */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background-color: #12181b;
        color: var(--text-primary);
        line-height: 1.6;
    }

    /* Card Styles */
    .dashboard-card {
        background: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--card-border);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--card-border);
    }

    .card-body {
        padding: 1.5rem;
        color: var(--text-secondary);
    }

    /* Typography */
    .text-heading {
        font-weight: 600;
        color: var(--text-primary);
    }

    .text-subheading {
        font-weight: 500;
        color: var(--gray);
        font-size: 0.875rem;
    }

    /* Tab Styles */
    .tab-nav {
        display: flex;
        border-bottom: 1px solid var(--card-border);
    }

    .tab-nav-item {
        padding: 0.75rem 1rem;
        font-weight: 500;
        color: var(--gray);
        cursor: pointer;
        position: relative;
        transition: all 0.2s ease;
    }

    .tab-nav-item:hover {
        color: var(--primary);
    }

    .tab-nav-item.active {
        color: var(--primary);
    }

    .tab-nav-item.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: var(--primary);
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Button Styles */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background-color: var(--primary);
        color: var(--white);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-1px);
    }

    .btn-success {
        background-color: var(--success);
        color: var(--white);
    }

    .btn-success:hover {
        background-color: #00a383;
    }

    .btn-danger {
        background-color: var(--danger);
        color: var(--white);
    }

    .btn-danger:hover {
        background-color: #c0392b;
    }

    .btn-outline {
        background-color: transparent;
        border: 1px solid var(--gray-light);
        color: var(--gray);
    }

    .btn-outline:hover {
        background-color: var(--gray-light);
    }

    /* Form Styles */
    .form-control {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1px solid var(--card-border);
        border-radius: 8px;
        transition: all 0.2s ease;
        background-color: var(--white);
        color: #000000;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.15);
        outline: none;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    /* Table Styles */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 8px;
        overflow: hidden;
    }

    .data-table th {
        background-color: var(--dark);
        color: var(--gray);
        font-weight: 600;
        text-align: left;
        padding: 0.75rem 1rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--card-border);
        vertical-align: middle;
        color: var(--text-secondary);
    }

    .data-table tr:last-child td {
        border-bottom: none;
    }

    .data-table tr:hover {
        background-color: var(--dark);
    }

    /* Badge Styles */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .badge-success {
        background-color: rgba(0, 184, 148, 0.2);
        color: var(--success);
    }

    .badge-danger {
        background-color: rgba(214, 48, 49, 0.2);
        color: var(--danger);
    }

    .badge-warning {
        background-color: rgba(253, 203, 110, 0.2);
        color: var(--warning);
    }

    .badge-info {
        background-color: rgba(9, 132, 227, 0.2);
        color: var(--info);
    }

    /* Progress Bars */
    .progress-container {
        height: 8px;
        border-radius: 4px;
        background-color: var(--dark);
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        border-radius: 4px;
        transition: width 0.6s ease;
    }

    /* Crypto Icons */
    .crypto-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        background-color: var(--dark);
        overflow: hidden;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .modal-content {
        background-color: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 500px;
        transform: translateY(20px);
        transition: all 0.3s ease;
        border: 1px solid var(--card-border);
    }

    .modal-overlay.active .modal-content {
        transform: translateY(0);
    }

    .modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--card-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-close {
        color: var(--gray);
        font-size: 1.5rem;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .modal-close:hover {
        color: var(--text-primary);
    }

    /* Signal Bars */
    .signal-bars {
        display: flex;
        gap: 4px;
        height: 8px;
    }

    .signal-bar {
        flex: 1;
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2rem;
    }

    .empty-state-icon {
        font-size: 3rem;
        color: var(--gray-light);
        margin-bottom: 1rem;
    }

    .empty-state-text {
        color: var(--gray);
        margin-bottom: 1.5rem;
    }

    /* Responsive Grid */
    .grid-container {
        display: grid;
        gap: 1.5rem;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .animate-fade {
        animation: fadeIn 0.3s ease-out;
    }

    /* Utility Classes */
    .text-success {
        color: var(--success);
    }

    .text-danger {
        color: var(--danger);
    }

    .text-warning {
        color: var(--warning);
    }

    .bg-success-light {
        background-color: rgba(0, 184, 148, 0.1);
    }

    .bg-danger-light {
        background-color: rgba(214, 48, 49, 0.1);
    }

    .bg-warning-light {
        background-color: rgba(253, 203, 110, 0.1);
    }

    .bg-info-light {
        background-color: rgba(9, 132, 227, 0.1);
    }

    /* Trading View Widget */
    .tradingview-widget-container {
        height: 100%;
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: var(--dark);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--gray);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--gray-light);
    }

    /* Hover effects for crypto items */
    .crypto-item:hover {
        background-color: var(--dark);
    }

    /* KYC status boxes */
    .kyc-status {
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    /* Gradient text for headings */
    .gradient-text {
        background: linear-gradient(90deg, var(--primary), var(--info));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    /* Divider style */
    .divider {
        height: 1px;
        background-color: var(--card-border);
        margin: 1rem 0;
    }

    /* Input group style */
    .input-group {
        display: flex;
        border: 1px solid var(--card-border);
        border-radius: 8px;
        overflow: hidden;
    }

    .input-group input {
        flex: 1;
        border: none;
        background: var(--dark);
        color: var(--text-primary);
        padding: 0.625rem 0.875rem;
    }

    .input-group .input-addon {
        background: var(--dark);
        color: var(--gray);
        padding: 0.625rem 0.875rem;
        display: flex;
        align-items: center;
    }

    /* Dropdown menu style */
    .dropdown-menu {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Active tab button style */
    .active-tab-btn {
        background-color: var(--primary) !important;
        color: white !important;
    }

    /* Inactive tab button style */
    .inactive-tab-btn {
        background-color: var(--dark) !important;
        color: var(--gray) !important;
    }

    /* Notification badge */
    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: var(--danger);
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
    }

    /* Balance Display */
    .balance-display {
        background: linear-gradient(135deg, var(--primary), var(--info));
        border-radius: 12px;
        padding: 1rem;
        color: var(--white);
        margin-bottom: 1rem;
    }

    /* Chart Type Button Styles */
    .chart-type-btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border: 1px solid var(--card-border);
        background-color: var(--dark);
        color: var(--gray);
        cursor: pointer;
    }

    .chart-type-btn.active {
        background-color: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }

    .chart-type-btn:hover:not(.active) {
        background-color: var(--gray-light);
        color: var(--text-primary);
    }

    /* Chart Container Styles */
    .chart-container {
        display: none;
        height: 100%;
        width: 100%;
    }

    .chart-container.active {
        display: block;
    }
</style>

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Dashboard Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold gradient-text">Dashboard Overview</h1>
        <p class="text-gray-500">Welcome back, {{ auth()->user()->username }}</p>
    </div>

  <!-- Balance Card - Full Width -->
<div class="dashboard-card mb-6">
    <div class="card-header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
    <div class="flex flex-col gap-3">
        <div>
            <h3 class="text-subheading">Total Balance</h3>
            <p class="text-heading text-2xl md:text-3xl">{{ showAmount(auth()->user()->balance) }}</p>
        </div>

        <!-- Buy and Sell Buttons -->
        <!-- Buy, Sell, Fiat, and Coin Buttons -->
<div class="flex flex-col sm:flex-row gap-2">
    <!-- Buy Button -->
    <button type="button" onclick="openModal('buyCryptoModal')"
        class="btn btn-success flex items-center justify-center px-4 py-2 sm:w-auto w-full">
        <i class="ri-arrow-down-line mr-1"></i> Buy
    </button>

    <!-- Sell Button -->
    <button type="button" onclick="openModal('sellCryptoModal')"
        class="btn btn-danger flex items-center justify-center px-4 py-2 sm:w-auto w-full">
        <i class="ri-arrow-up-line mr-1"></i> Sell
    </button>


</div>

    </div>

    <!-- Tabs -->
    <div class="flex space-x-2">
    <button class="p-2 rounded-lg tab-nav-item" data-tab="tab1">
        <i class="ri-file-list-line"></i>
        <span class="ml-1 md:inline hidden">Recent Deposits</span>
    </button>

    <button class="p-2 rounded-lg tab-nav-item active" data-tab="tab2">
        <i class="ri-smartphone-line"></i>
        <span class="ml-1 md:inline hidden">Account Summary</span>
    </button>
</div>

</div>

    </div>

    <div class="card-body">
<div id="tab1" class="tab-content animate-fade">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($Topcurrencies as $currency)
                    @php
                        $symbollowcase = strtolower($currency->currency);
                        $apiUrl = "https://min-api.cryptocompare.com/data/price?fsym={$currency->currency}&tsyms=USD";
                        $response = file_get_contents($apiUrl);
                        $data = json_decode($response, true);
                        $rate = $data['USD'] ?? 0;
                        $amount_usd = $currency->amount * $rate;
                    @endphp

                    <div class="flex items-center justify-between p-4 hover:bg-gray-800 rounded-lg transition-colors crypto-item border border-gray-700">
                        <div class="flex items-center">
                            <div class="crypto-icon">
                                <img src="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/refs/heads/master/svg/color/{{ $symbollowcase }}.svg"
                                     class="w-6 h-6"
                                     onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/0/381.png'">
                            </div>
                            <div class="ml-3">
                                <div class="text-heading">{{ $currency->currency }}</div>
                                <div class="text-subheading text-sm">{{ $currency->amount }} {{ $currency->currency }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-heading">${{ number_format($amount_usd, 2) }}</div>
                            <div class="text-subheading text-sm">{{ $rate > 0 ? '$'.number_format($rate, 4) : 'N/A' }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if(count($Topcurrencies) == 0)
                <div class="empty-state py-8">
                    <div class="empty-state-icon">
                        <i class="ri-wallet-3-line"></i>
                    </div>
                    <p class="empty-state-text">No deposit history yet</p>
                    <a href="{{ route('crypto.deposit.index') }}" class="btn btn-primary mt-4">
                        <i class="ri-bank-card-line mr-1"></i> Make a Deposit
                    </a>
                </div>
            @endif
        </div>

<div id="tab2" class="tab-content active animate-fade">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Deposit Summary -->
                <div class="p-4 rounded-lg border border-gray-700 bg-gray-800">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <i class="ri-arrow-down-circle-line text-primary mr-2"></i>
                            <span class="text-subheading">Total Deposits</span>
                        </div>
                        <p class="text-heading">{{ showAmount(auth()->user()->balance) }}</p>
                    </div>
                    <a href="{{ route('crypto.deposit.index') }}" class="btn btn-primary btn-sm w-full mt-2">
                        <i class="ri-add-line mr-1"></i> Deposit Funds
                    </a>
                </div>

                <!-- Withdrawal Summary -->
                <div class="p-4 rounded-lg border border-gray-700 bg-gray-800">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <i class="ri-arrow-up-circle-line text-danger mr-2"></i>
                            <span class="text-subheading">Total Withdrawals</span>
                        </div>
                        <p class="text-heading">{{ showAmount($totalWithdraw) }}</p>
                    </div>
                    <a href="{{ route('user.withdraw') }}" class="btn btn-danger btn-sm w-full mt-2">
                        <i class="ri-bank-line mr-1"></i> Withdraw Funds
                    </a>
                </div>

                <!-- Profit Summary -->
                <div class="p-4 rounded-lg border border-gray-700 bg-gray-800">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <i class="ri-line-chart-line text-success mr-2"></i>
                            <span class="text-subheading">Total Profits</span>
                        </div>
                        <p class="text-heading text-success">$0.00</p>
                    </div>
                    <div class="text-xs text-gray-500 mt-1">Total Profits</div>
                </div>

                <!-- Verification Status -->
                <div class="p-4 rounded-lg border border-gray-700 bg-gray-800">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <i class="ri-shield-check-line text-info mr-2"></i>
                            <span class="text-subheading">Verification Status</span>
                        </div>
                        @if(auth()->user()->kv == Status::KYC_VERIFIED)
                            <span class="badge badge-success">Verified</span>
                        @else
                            <span class="badge badge-danger">Unverified</span>
                        @endif
                    </div>

                    @if(auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
                        <div class="kyc-status bg-danger-light text-danger text-xs p-2 rounded mt-2">
                            <p>{{ __(@$kyc->data_values->reject) }}</p>
                            <a href="javascript::void(0)" class="underline" data-bs-toggle="modal" data-bs-target="#kycRejectionReason">
                                @lang('View reason')
                            </a>
                        </div>
                    @elseif(auth()->user()->kv == Status::KYC_UNVERIFIED)
                        <a href="{{ route('user.kyc.form') }}" class="btn btn-warning btn-sm w-full mt-2">
                            <i class="ri-shield-keyhole-line mr-1"></i> Verify Account
                        </a>
                    @elseif(auth()->user()->kv == Status::KYC_PENDING)
                        <div class="kyc-status bg-info-light text-info text-xs p-2 rounded mt-2">
                            <p>{{ __(@$kyc->data_values->pending) }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Market Chart Section - Full Width with Enhanced TradingView -->
<div class="dashboard-card mb-6">
    <div class="card-header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h3 class="text-heading">Advanced Market Analysis</h3>
            <div class="flex flex-wrap gap-2">
                <!-- Chart Type Selector -->
                <div class="flex items-center space-x-2">
                    <button class="chart-type-btn active" data-type="crypto" id="cryptoChartBtn">
                        <i class="ri-currency-line mr-1"></i> Crypto
                    </button>
                    <button class="chart-type-btn" data-type="stock" id="stockChartBtn">
                        <i class="ri-line-chart-line mr-1"></i> Stocks
                    </button>
                    <button class="chart-type-btn" data-type="forex" id="forexChartBtn">
                        <i class="ri-exchange-line mr-1"></i> Forex
                    </button>
                </div>

                <!-- Timeframe Selector -->
                <div class="flex items-center space-x-2">
                    <select id="timeframeSelect" class="form-control text-xs py-1 px-2">
                        <option value="1">1m</option>
                        <option value="5">5m</option>
                        <option value="15">15m</option>
                        <option value="60">1h</option>
                        <option value="240">4h</option>
                        <option value="1D" selected>1D</option>
                        <option value="1W">1W</option>
                        <option value="1M">1M</option>
                    </select>
                </div>

                <!-- Indicator Button -->
                <button id="indicatorBtn" class="btn btn-outline text-xs py-1 px-2 flex items-center">
                    <i class="ri-function-line mr-1"></i> Indicators
                </button>
            </div>
        </div>
    </div>

    <div class="card-body p-0 h-[550px]">
        <!-- TradingView Widget Container -->
        <div id="tradingview-chart" class="tradingview-widget-container">
            <div id="tradingview-widget" style="height:100%;width:100%"></div>
            <div class="tradingview-widget-copyright">
                <a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank">
                    <span class="blue-text">Track all markets on TradingView</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Indicator Modal -->
<div class="modal-overlay hidden" id="indicatorModal">
    <div class="modal-content w-full max-w-2xl">
        <div class="modal-header">
            <h3 class="text-heading">Technical Indicators</h3>
            <button class="modal-close" id="closeIndicatorModal">
                ✖
            </button>
        </div>
        <div class="modal-body">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Popular Indicators -->
                <button class="btn btn-outline flex items-center justify-start indicator-btn" data-indicator="MACD">
                    <i class="ri-pulse-line mr-2"></i> MACD
                </button>
                <button class="btn btn-outline flex items-center justify-start indicator-btn" data-indicator="RSI">
                    <i class="ri-dashboard-2-line mr-2"></i> RSI
                </button>
                <button class="btn btn-outline flex items-center justify-start indicator-btn" data-indicator="Bollinger Bands">
                    <i class="ri-arrow-up-down-line mr-2"></i> Bollinger
                </button>
                <button class="btn btn-outline flex items-center justify-start indicator-btn" data-indicator="Volume">
                    <i class="ri-bar-chart-2-line mr-2"></i> Volume
                </button>
                <button class="btn btn-outline flex items-center justify-start indicator-btn" data-indicator="Moving Average">
                    <i class="ri-line-chart-line mr-2"></i> MA
                </button>
                <button class="btn btn-outline flex items-center justify-start indicator-btn" data-indicator="Stochastic">
                    <i class="ri-speed-line mr-2"></i> Stochastic
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Trading Section - Side by Side Layout -->


    <!-- Trade History - Takes 2/3 on large screens -->
    <div class="dashboard-card lg:col-span-2">
        <div class="card-header">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div class="flex space-x-2">
                    <button class="px-4 py-2 text-sm bg-primary text-white rounded-md font-medium active-tab-btn" id="openTradesBtn">
                    </button>
                    <button class="px-4 py-2 text-sm text-gray-400 hover:text-gray-100 bg-gray-800 rounded-md font-medium inactive-tab-btn" id="closedTradesBtn">
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <!-- Open Trades Table -->
            <div id="openTradesSection">
                @if($userAssets->where('status', 'open')->isEmpty())
                    <div class="empty-state py-8">
                        <div class="empty-state-icon">
                            <i class="ri-briefcase-2-line"></i>
                        </div>

                        <button class="btn btn-primary inline-flex items-center mt-4" onclick="document.getElementById('tradeForm').scrollIntoView()">
                        </button>

                        <!-- Fiat to Coin Button -->
                        <button type="button" onclick="openModal('fiatToCryptoModal')"
                                class="btn btn-primary w-full mt-4 flex items-center justify-center text-center">
                            <i class="ri-exchange-dollar-line mr-1"></i> Convert Fiat to Coin
                        </button>

                        <!-- Coin to Fiat Button -->
                        <button type="button" onclick="openModal('cryptoToFiatModal')"
                                class="btn btn-info w-full mt-2 flex items-center justify-center text-center">
                            <i class="ri-exchange-line mr-1"></i> Convert Coin to Fiat
                        </button>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Asset</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Loss/Profit</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userAssets->where('status', 'open') as $trade)
                                <tr>
                                    <td>
                                        @php
                                            $symbollowcase = strtolower($trade->assets);
                                            $icon = $trade->assets;
                                            $icon2 = strtolower(substr($trade->assets, 0, 2));
                                            $iconSrc = '';

                                            if ($trade->trade_type == 'Crypto') {
                                                $iconSrc = "https://raw.githubusercontent.com/spothq/cryptocurrency-icons/refs/heads/master/svg/color/{$symbollowcase}.svg";
                                            } elseif ($trade->trade_type == 'Stocks') {
                                                $iconSrc = "https://cdn.jsdelivr.net/gh/ahmeterenodaci/Nasdaq-Stock-Exchange-including-Symbols-and-Logos/logos/_{$icon}.png";
                                            } elseif ($trade->trade_type == 'Forex') {
                                                $iconSrc = "https://flagcdn.com/36x27/{$icon2}.png";
                                            }
                                        @endphp
                                        <div class="flex items-center">
                                            <img class="w-6 h-6 rounded-full mr-2" src="{{ $iconSrc }}" alt="{{ $trade->assets }}" onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/0/381.png'">
                                            <span>{{ $trade->assets }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $trade->trade_type }}</td>
                                    <td>${{ number_format($trade->amount, 2) }}</td>
                                    <td>
                                        <div class="flex flex-col">
                                            <span class="text-success">${{ $trade->profit }}</span>
                                            <span class="text-danger">${{ $trade->loss }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($trade->action == 'buy')
                                            <span class="badge badge-success">Buy</span>
                                        @else
                                            <span class="badge badge-danger">Sell</span>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Closed Trades Table -->
            <div id="closedTradesSection" class="hidden">
                @if($userAssets->where('status', 'complete')->isEmpty())
 <!-- Fiat to Crypto Button -->
    <button type="button" onclick="openModal('fiatToCryptoModal')"
        class="btn btn-primary flex items-center justify-center px-4 py-2 sm:w-auto w-full">
        <i class="ri-exchange-dollar-line mr-1"></i> Fiat
    </button>

    <!-- Crypto to Fiat Button -->
    <button type="button" onclick="openModal('cryptoToFiatModal')"
        class="btn btn-info flex items-center justify-center px-4 py-2 sm:w-auto w-full">
        <i class="ri-exchange-line mr-1"></i> Coin
    </button>
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Asset</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Loss/Profit</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userAssets->where('status', 'complete') as $trade)
                                <tr>
                                    <td>
                                        @php
                                            $symbollowcase = strtolower($trade->assets);
                                            $icon = $trade->assets;
                                            $icon2 = strtolower(substr($trade->assets, 0, 2));
                                            $iconSrc = '';

                                            if ($trade->trade_type == 'Crypto') {
                                                $iconSrc = "https://raw.githubusercontent.com/spothq/cryptocurrency-icons/refs/heads/master/svg/color/{$symbollowcase}.svg";
                                            } elseif ($trade->trade_type == 'Stocks') {
                                                $iconSrc = "https://cdn.jsdelivr.net/gh/ahmeterenodaci/Nasdaq-Stock-Exchange-including-Symbols-and-Logos/logos/_{$icon}.png";
                                            } elseif ($trade->trade_type == 'Forex') {
                                                $iconSrc = "https://flagcdn.com/36x27/{$icon2}.png";
                                            }
                                        @endphp
                                        <div class="flex items-center">
                                            <img class="w-6 h-6 rounded-full mr-2" src="{{ $iconSrc }}" alt="{{ $trade->assets }}" onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/0/381.png'">
                                            <span>{{ $trade->assets }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $trade->trade_type }}</td>
                                    <td>${{ number_format($trade->amount, 2) }}</td>
                                    <td>
                                        <div class="flex flex-col">
                                            <span class="text-success">${{ $trade->profit }}</span>
                                            <span class="text-danger">${{ $trade->loss }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($trade->action == 'buy')
                                            <span class="badge badge-success">Buy</span>
                                        @else
                                            <span class="badge badge-danger">Sell</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-success">Completed</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>



<!-- TradingView Script -->
<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
<!-- Custom Chart Script -->
<script src="market-chart.js"></script>














<!-- Buy Crypto Modal -->
<div class="modal-overlay" id="buyCryptoModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="text-heading">Buy Cryptocurrency</h3>
            <button onclick="closeModal('buyCryptoModal')" class="modal-close">
                ✖
            </button>
        </div>

        <div class="modal-body">
            <form action="{{ route('user.crypto.buy.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="type" value="buy_crypto">

                <div>
                    <label for="buy_fiatAmount" class="form-label">Amount to Spend (USD)</label>
                    <input type="number" id="buy_fiatAmount" name="fiat_amount" step="0.01" min="0"
                        class="form-control"
                        placeholder="Enter amount in USD" required>
                </div>

                <div>
                    <label for="buy_cryptoAmount" class="form-label">You will receive</label>
                    <div class="flex items-center gap-2">
                        <input type="text" id="buy_cryptoAmount" name="crypto_amount" readonly
                            class="form-control bg-gray-50">
                        <span id="buy_cryptoSymbol" class="text-heading"></span>
                    </div>
                </div>

                <div>
                    <label for="buy_cryptoSelect" class="form-label">Select Cryptocurrency</label>
                    <div class="relative flex items-center bg-gray-50 rounded-lg border border-gray-300">
                        <img id="buy_cryptoIcon" src="" class="w-6 h-6 ml-3" alt="Crypto Icon">
                        <select id="buy_cryptoSelect" name="currency" class="w-full py-2 px-3 pl-12 bg-transparent text-gray-900 rounded-lg focus:ring-1 focus:ring-blue-500 focus:outline-none" required>
                            <option value="">Loading...</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full btn btn-success py-3 rounded-lg mt-4">
                    Buy Crypto
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Sell Crypto Modal -->
<div class="modal-overlay" id="sellCryptoModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="text-heading">Sell Cryptocurrency</h3>
            <button onclick="closeModal('sellCryptoModal')" class="modal-close">
                ✖
            </button>
        </div>

        <div class="modal-body">
            <form action="{{ route('user.crypto.sell.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="type" value="sell_crypto">

                <div>
                    <label for="sell_cryptoAmount" class="form-label">Amount to Sell</label>
                    <div class="flex items-center gap-2">
                        <input type="number" id="sell_cryptoAmount" name="crypto_amount" step="0.00000001" min="0"
                            class="form-control"
                            placeholder="Enter crypto amount" required>
                        <span id="sell_cryptoSymbol" class="text-heading"></span>
                    </div>
                </div>

                <div>
                    <label for="sell_fiatAmount" class="form-label">You will receive (USD)</label>
                    <input type="text" id="sell_fiatAmount" name="fiat_amount" readonly
                        class="form-control bg-gray-50">
                </div>

                <div>
                    <label for="sell_cryptoSelect" class="form-label">Select Cryptocurrency</label>
                    <div class="relative flex items-center bg-gray-50 rounded-lg border border-gray-300">
                        <img id="sell_cryptoIcon" src="" class="w-6 h-6 ml-3" alt="Crypto Icon">
                        <select id="sell_cryptoSelect" name="currency" class="w-full py-2 px-3 pl-12 bg-transparent text-gray-900 rounded-lg focus:ring-1 focus:ring-blue-500 focus:outline-none" required>
                            <option value="">Loading...</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full btn btn-danger py-3 rounded-lg mt-4">
                    Sell Crypto
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Fiat to Crypto Modal -->
<div class="modal-overlay" id="fiatToCryptoModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="text-heading">Convert Fiat to Crypto</h3>
            <button onclick="closeModal('fiatToCryptoModal')" class="modal-close">
                ✖
            </button>
        </div>

        <div class="modal-body">
            <form action="{{ route('user.crypto.deposit.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="type" value="fiat_to_crypto">

                <div>
                    <label for="f2c_fiatAmount" class="form-label">Fiat Amount (USD)</label>
                    <input type="number" id="f2c_fiatAmount" name="fiat_amount" step="0.01" min="0"
                        class="form-control"
                        placeholder="Enter amount in USD" required>
                </div>

                <div>
                    <label for="f2c_cryptoAmount" class="form-label">You will receive</label>
                    <div class="flex items-center gap-2">
                        <input type="text" id="f2c_cryptoAmount" name="crypto_amount" readonly
                            class="form-control bg-gray-50">
                        <span id="f2c_cryptoSymbol" class="text-heading"></span>
                    </div>
                </div>

                <div>
                    <label for="f2c_cryptoSelect" class="form-label">Select Cryptocurrency</label>
                    <div class="relative flex items-center bg-gray-50 rounded-lg border border-gray-300">
                        <img id="f2c_cryptoIcon" src="" class="w-6 h-6 ml-3" alt="Crypto Icon">
                        <select id="f2c_cryptoSelect" name="currency" class="w-full py-2 px-3 pl-12 bg-transparent text-gray-900 rounded-lg focus:ring-1 focus:ring-blue-500 focus:outline-none" required>
                            <option value="">Loading...</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full btn btn-primary py-3 rounded-lg mt-4">
                    Convert to Crypto
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Crypto to Fiat Modal -->
<div class="modal-overlay" id="cryptoToFiatModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="text-heading">Convert Crypto to Fiat</h3>
            <button onclick="closeModal('cryptoToFiatModal')" class="modal-close">
                ✖
            </button>
        </div>

        <div class="modal-body">
            <form action="{{ route('user.crypto.deposit.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="type" value="crypto_to_fiat">

                <div>
                    <label for="c2f_cryptoSelect" class="form-label">Select Cryptocurrency</label>
                    <div class="relative flex items-center bg-gray-50 rounded-lg border border-gray-300">
                        <img id="c2f_cryptoIcon" src="" class="w-6 h-6 ml-3" alt="Crypto Icon">
                        <select id="c2f_cryptoSelect" name="currency" class="w-full py-2 px-3 pl-12 bg-transparent text-gray-900 rounded-lg focus:ring-1 focus:ring-blue-500 focus:outline-none" required>
                            <option value="">Loading...</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="c2f_cryptoAmount" class="form-label">Crypto Amount</label>
                    <input type="number" id="c2f_cryptoAmount" name="crypto_amount" step="0.00000001" min="0"
                        class="form-control"
                        placeholder="Enter crypto amount" required>
                </div>

                <div>
                    <label for="c2f_fiatAmount" class="form-label">You will receive (USD)</label>
                    <input type="text" id="c2f_fiatAmount" name="fiat_amount"
                        class="form-control bg-gray-50" readonly>
                </div>

                <button type="submit" class="w-full btn btn-info py-3 rounded-lg mt-4">
                    Convert to USD
                </button>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">
        {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger mb-4">
        {{ $errors->first() }}
    </div>
@endif

<script>
// ================= TradingView Integration ==================

// Global chart widget reference
let tvWidget = null;
let currentSymbol = 'BTCUSDT';
let currentChartType = 'crypto';

// DOM Elements for TradingView
const cryptoChartBtn = document.getElementById('cryptoChartBtn');
const stockChartBtn = document.getElementById('stockChartBtn');
const forexChartBtn = document.getElementById('forexChartBtn');
const timeframeSelect = document.getElementById('timeframeSelect');
const indicatorBtn = document.getElementById('indicatorBtn');
const indicatorModal = document.getElementById('indicatorModal');
const indicatorButtons = document.querySelectorAll('.indicator-btn');

// Initialize TradingView Widget
function initTradingView() {
    if(tvWidget !== null) {
        tvWidget.remove();
        tvWidget = null;
    }

    const widgetOptions = {
        autosize: true,
        symbol: `BINANCE:${currentSymbol}`,
        interval: timeframeSelect.value,
        timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
        theme: "dark",
        style: "1",
        locale: "en",
        toolbar_bg: "#1e272e",
        enable_publishing: false,
        allow_symbol_change: true,
        details: true,
        hotlist: true,
        calendar: true,
        show_popup_button: true,
        popup_width: "1000",
        popup_height: "650",
        studies: [
            "MACD@tv-basicstudies",
            "RSI@tv-basicstudies",
            "Volume@tv-basicstudies"
        ],
        container_id: "tradingview-widget"
    };

    tvWidget = new TradingView.widget(widgetOptions);

    // Handle symbol change events
    tvWidget.onChartReady(() => {
        tvWidget.chart().onSymbolChanged().subscribe(null, (symbol) => {
            currentSymbol = symbol.split(':')[1].replace('USDT', '');
        });
    });
}

// Switch between chart types
function switchChartType(type) {
    currentChartType = type;
    document.querySelectorAll('.chart-type-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    let symbolPrefix = '';
    switch(type) {
        case 'crypto':
            document.querySelector(`.chart-type-btn[data-type="crypto"]`).classList.add('active');
            symbolPrefix = 'BINANCE:';
            currentSymbol = 'BTCUSDT';
            break;
        case 'stock':
            document.querySelector(`.chart-type-btn[data-type="stock"]`).classList.add('active');
            symbolPrefix = 'NASDAQ:';
            currentSymbol = 'AAPL';
            break;
        case 'forex':
            document.querySelector(`.chart-type-btn[data-type="forex"]`).classList.add('active');
            symbolPrefix = 'FX:';
            currentSymbol = 'EURUSD';
            break;
    }

    if(tvWidget) {
        tvWidget.chart().setSymbol(`${symbolPrefix}${currentSymbol}`);
    }
}

// Update chart timeframe
function updateChartTimeframe() {
    const timeframe = timeframeSelect.value;
    if(tvWidget) {
        tvWidget.chart().setResolution(timeframe);
    }
}

// Add indicator to chart
function addIndicator(indicator) {
    if(!tvWidget) return;

    switch(indicator) {
        case 'MACD':
            tvWidget.chart().createStudy('Moving Average Convergence Divergence', false, false);
            break;
        case 'RSI':
            tvWidget.chart().createStudy('Relative Strength Index', false, false, [14]);
            break;
        case 'Bollinger Bands':
            tvWidget.chart().createStudy('Bollinger Bands', false, false, [20, 2]);
            break;
        case 'Volume':
            tvWidget.chart().createStudy('Volume', false, false);
            break;
        case 'Moving Average':
            tvWidget.chart().createStudy('Moving Average', false, false, [50]);
            break;
        case 'Stochastic':
            tvWidget.chart().createStudy('Stochastic', false, false);
            break;
    }
    closeModal('indicatorModal');
}

// Update chart when asset changes from trade panel
function updateTradingViewChart(symbol, type) {
    if(!tvWidget) return;

    let tvSymbol;
    switch(type) {
        case 'crypto':
            tvSymbol = `BINANCE:${symbol}USDT`;
            break;
        case 'stock':
            tvSymbol = `NASDAQ:${symbol}`;
            break;
        case 'forex':
            tvSymbol = `FX:${symbol}`;
            break;
    }

    tvWidget.chart().setSymbol(tvSymbol);
    currentSymbol = symbol;
    currentChartType = type;
}

// Event Listeners for TradingView
cryptoChartBtn.addEventListener('click', () => switchChartType('crypto'));
stockChartBtn.addEventListener('click', () => switchChartType('stock'));
forexChartBtn.addEventListener('click', () => switchChartType('forex'));
timeframeSelect.addEventListener('change', updateChartTimeframe);
indicatorBtn.addEventListener('click', () => openModal('indicatorModal'));

indicatorButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        addIndicator(btn.dataset.indicator);
    });
});

// ================= Shared Modal + UI Handling =================

// General modal functions
function openModal(id) {
    document.getElementById(id).classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('active');
    document.body.style.overflow = '';
}

// Close modals when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal-overlay')) {
        closeModal(event.target.id);
    }
}

// ================= Other UI and Trade Logic =================

// Tab switching
const tabButtons = document.querySelectorAll('.tab-nav-item');
const tabContents = document.querySelectorAll('.tab-content');

tabButtons.forEach((button) => {
    button.addEventListener('click', () => {
        tabButtons.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));

        button.classList.add('active');
        const tabId = button.getAttribute('data-tab');
        document.getElementById(tabId).classList.add('active');
    });
});

// Trade table switching
document.getElementById('openTradesBtn').addEventListener('click', function() {
    this.classList.add('bg-primary', 'text-white');
    this.classList.remove('text-gray-600', 'bg-gray-100');
    document.getElementById('closedTradesBtn').classList.remove('bg-primary', 'text-white');
    document.getElementById('closedTradesBtn').classList.add('text-gray-600', 'bg-gray-100');
    document.getElementById('openTradesSection').classList.remove('hidden');
    document.getElementById('closedTradesSection').classList.add('hidden');
});

document.getElementById('closedTradesBtn').addEventListener('click', function() {
    this.classList.add('bg-primary', 'text-white');
    this.classList.remove('text-gray-600', 'bg-gray-100');
    document.getElementById('openTradesBtn').classList.remove('bg-primary', 'text-white');
    document.getElementById('openTradesBtn').classList.add('text-gray-600', 'bg-gray-100');
    document.getElementById('closedTradesSection').classList.remove('hidden');
    document.getElementById('openTradesSection').classList.add('hidden');
});

// ================= Init on Page Load =================
document.addEventListener('DOMContentLoaded', () => {
    initTradingView();
    populateCryptoSelects();
    // keep your Fiat2Crypto, Crypto2Fiat, asset dropdown, signal strength, form validation init here
});

// Populate cryptocurrency selects in modals
async function populateCryptoSelects() {
    const buySelect = document.getElementById('buy_cryptoSelect');
    const sellSelect = document.getElementById('sell_cryptoSelect');

    // Show loading
    buySelect.innerHTML = '<option value="">Loading...</option>';
    sellSelect.innerHTML = '<option value="">Loading...</option>';

    // Fetch top 100 coins by market cap
    const res = await fetch('https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=100&page=1&sparkline=false');
    const coins = await res.json();

    buySelect.innerHTML = '';
    sellSelect.innerHTML = '';

    coins.forEach(coin => {
        const option = document.createElement('option');
        option.value = coin.symbol.toUpperCase();
        option.textContent = `${coin.name} (${coin.symbol.toUpperCase()})`;
        option.setAttribute('data-icon', coin.image);

        buySelect.appendChild(option.cloneNode(true));
        sellSelect.appendChild(option);
    });

    // Set initial icon and symbol
    updateBuyCryptoFields();
    updateSellCryptoFields();
}

document.addEventListener('DOMContentLoaded', populateCryptoSelects);

// Helper to fetch price from CryptoCompare
async function fetchCryptoPrice(symbol) {
    try {
        const res = await fetch(`https://min-api.cryptocompare.com/data/price?fsym=${symbol}&tsyms=USD`);
        const data = await res.json();
        return data.USD || 0;
    } catch {
        return 0;
    }
}

// Update logo and conversion on select or input
async function updateBuyCryptoFields() {
    const select = document.getElementById('buy_cryptoSelect');
    const icon = document.getElementById('buy_cryptoIcon');
    const symbolSpan = document.getElementById('buy_cryptoSymbol');
    const amountInput = document.getElementById('buy_fiatAmount');
    const receiveInput = document.getElementById('buy_cryptoAmount');

    const selectedOption = select.options[select.selectedIndex];
    const symbol = select.value;
    const iconUrl = selectedOption.getAttribute('data-icon');
    icon.src = iconUrl;
    symbolSpan.textContent = symbol;

    const usd = parseFloat(amountInput.value) || 0;
    if (symbol && usd > 0) {
        const price = await fetchCryptoPrice(symbol);
        if (price > 0) {
            receiveInput.value = (usd / price).toFixed(8);
        } else {
            receiveInput.value = '';
        }
    } else {
        receiveInput.value = '';
    }
}

// Helper to fetch price for sell
async function fetchSellCryptoPrice(symbol) {
    try {
        const res = await fetch(`https://min-api.cryptocompare.com/data/price?fsym=${symbol}&tsyms=USD`);
        const data = await res.json();
        return data.USD || 0;
    } catch {
        return 0;
    }
}

// Update logo and conversion on select or input for sell
async function updateSellCryptoFields() {
    const select = document.getElementById('sell_cryptoSelect');
    const icon = document.getElementById('sell_cryptoIcon');
    const symbolSpan = document.getElementById('sell_cryptoSymbol');
    const amountInput = document.getElementById('sell_cryptoAmount');
    const receiveInput = document.getElementById('sell_fiatAmount');

    const selectedOption = select.options[select.selectedIndex];
    const symbol = select.value;
    const iconUrl = selectedOption.getAttribute('data-icon');
    icon.src = iconUrl;
    symbolSpan.textContent = symbol;

    const cryptoAmount = parseFloat(amountInput.value) || 0;
    if (symbol && cryptoAmount > 0) {
        const price = await fetchSellCryptoPrice(symbol);
        if (price > 0) {
            receiveInput.value = (cryptoAmount * price).toFixed(2);
        } else {
            receiveInput.value = '';
        }
    } else {
        receiveInput.value = '';
    }
}

// Event listeners
document.getElementById('buy_cryptoSelect').addEventListener('change', updateBuyCryptoFields);
document.getElementById('buy_fiatAmount').addEventListener('input', updateBuyCryptoFields);

// Event listeners for sell modal
document.getElementById('sell_cryptoSelect').addEventListener('change', updateSellCryptoFields);
document.getElementById('sell_cryptoAmount').addEventListener('input', updateSellCryptoFields);

// Set initial icon and symbol on modal open
document.getElementById('buyCryptoModal').addEventListener('click', function() {
    updateBuyCryptoFields();
});
document.getElementById('sellCryptoModal').addEventListener('click', function() {
    updateSellCryptoFields();
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('success') }}',
        timer: 2500,
        showConfirmButton: false
    });
@endif

@if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ $errors->first() }}',
        timer: 2500,
        showConfirmButton: false
    });
@endif
</script>
@endsection
