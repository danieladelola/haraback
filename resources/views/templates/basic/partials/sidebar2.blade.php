<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Desktop Sidebar -->
<div x-data="{ showSettings: false }" class="hidden lg:block">
    <aside class="flex flex-col w-64 border-r border-gray-800 p-4 bg-black shadow-none">
        <!-- Logo / Title -->
        <div class="mb-8">
            <a href="#" class="text-2xl font-bold text-white flex items-center gap-2">
                <i class="ri-flashlight-fill text-purple-400"></i>
                HaraTrading
            </a>
        </div>
        <nav class="space-y-2 flex-1">
            <a href="{{ route('user.home') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2 {{ request()->routeIs('user.home') ? 'bg-gradient-to-r from-[#9333ea] to-[#2563eb] text-white shadow-md' : 'text-gray-300 hover:bg-gradient-to-r from-[#9333ea] to-[#2563eb] hover:text-white transition-all' }}">
                <i class="ri-dashboard-line"></i> Dashboard
            </a>
            {{-- <a href="{{ route('trade.index') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2 {{ request()->routeIs('trade.index') ? 'bg-gradient-to-r from-[#9333ea] to-[#2563eb] text-white shadow-md' : 'text-gray-300 hover:bg-gradient-to-r from-[#9333ea] to-[#2563eb] hover:text-white transition-all' }}">
                <i class="ri-exchange-box-line"></i> Trade
            </a> --}}
            <a href="{{ route('crypto.deposit.index') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2 {{ request()->routeIs('crypto.deposit.index') ? 'bg-gradient-to-r from-[#9333ea] to-[#2563eb] text-white shadow-md' : 'text-gray-300 hover:bg-gradient-to-r from-[#9333ea] to-[#2563eb] hover:text-white transition-all' }}">
                <i class="ri-arrow-right-circle-line"></i> Deposit
            </a>
            <a href="{{ route('user.withdraw') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2 {{ request()->routeIs('user.withdraw') ? 'bg-gradient-to-r from-[#9333ea] to-[#2563eb] text-white shadow-md' : 'text-gray-300 hover:bg-gradient-to-r from-[#9333ea] to-[#2563eb] hover:text-white transition-all' }}">
                <i class="ri-arrow-left-circle-line"></i> Withdraw
            </a>
            <a href="{{ route('user.wallet.list') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2 {{ request()->routeIs('user.wallet.list') ? 'bg-gradient-to-r from-[#9333ea] to-[#2563eb] text-white shadow-md' : 'text-gray-300 hover:bg-gradient-to-r from-[#9333ea] to-[#2563eb] hover:text-white transition-all' }}">
                <i class="ri-wallet-3-line"></i> Wallet
            </a>

            <a href="{{ route('market.index') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2 {{ request()->routeIs('market.index') ? 'bg-gradient-to-r from-[#9333ea] to-[#2563eb] text-white shadow-md' : 'text-gray-300 hover:bg-gradient-to-r from-[#9333ea] to-[#2563eb] hover:text-white transition-all' }}">
                <i class="ri-line-chart-line"></i> Markets
            </a>
            <a href="{{ route('staking.index') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2 {{ request()->routeIs('staking.index') ? 'bg-gradient-to-r from-[#9333ea] to-[#2563eb] text-white shadow-md' : 'text-gray-300 hover:bg-gradient-to-r from-[#9333ea] to-[#2563eb] hover:text-white transition-all' }}">
                <i class="ri-money-dollar-circle-line"></i> Stake
            </a>
            <a href="#" @click.prevent="showSettings = true"
               class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-300 hover:bg-gradient-to-r from-[#9333ea] to-[#2563eb] hover:text-white transition-all">
                <i class="ri-settings-3-line"></i> Settings
            </a>

        </nav>
    </aside>

    <!-- Settings Card Slide-out (shared for desktop and mobile) -->
    <div x-show="showSettings" x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full opacity-0"
         x-transition:enter-end="translate-x-0 opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0 opacity-100"
         x-transition:leave-end="translate-x-full opacity-0"
         class="fixed top-0 right-0 h-full w-full max-w-sm bg-gradient-to-br from-gray-900 via-[#2563eb] to-[#9333ea] z-50 shadow-2xl overflow-y-auto rounded-l-2xl"
         style="display: none;">
        <button @click="showSettings = false" class="absolute top-4 right-4 text-gray-300 hover:text-purple-400 transition">
            <i class="ri-close-line text-3xl"></i>
        </button>
        <div class="container mx-auto p-4">
            <!-- User Info -->
            <header class="flex items-center gap-4 mb-4">
                <div class="avatar w-12 h-12 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center text-white text-2xl shadow-lg border-2 border-white">
                    <i class="ri-user-line"></i>
                </div>
                <div class="user-info">
                    <h1 class="text-lg font-bold text-white">{{ auth()->user()->fullname ?? auth()->user()->username }}</h1>
                    <p class="text-gray-200 text-xs">{{ auth()->user()->email }}</p>
                </div>
            </header>
            <div>
                <!-- Payments Section -->
                <div class="section-title flex items-center gap-2 text-blue-200 font-bold mb-1 text-base">
                    <i class="ri-credit-card-line"></i> Payments
                </div>
                <a href="{{ route('crypto.deposit.index') }}" class="flex items-center gap-3 py-1 text-white hover:text-blue-300 transition">
                    <i class="ri-money-dollar-circle-line text-xl text-blue-400"></i>
                    <div class="flex-1">
                        <h3 class="font-bold text-sm">Deposit</h3>
                        <p class="text-gray-400 text-xs">Add funds to your account</p>
                    </div>
                    <i class="ri-arrow-right-s-line text-gray-400 text-lg"></i>
                </a>
                <hr class="my-1 border-gray-700">
                <a href="{{ route('user.withdraw') }}" class="flex items-center gap-3 py-1 text-white hover:text-blue-300 transition">
                    <i class="ri-hand-coin-line text-xl text-blue-400"></i>
                    <div class="flex-1">
                        <h3 class="font-bold text-sm">Withdraw</h3>
                        <p class="text-gray-400 text-xs">Transfer out your funds</p>
                    </div>
                    <i class="ri-arrow-right-s-line text-gray-400 text-lg"></i>
                </a>
                <hr class="my-1 border-gray-700">

                <!-- Profile Section -->
                <div class="section-title flex items-center gap-2 text-blue-200 font-bold mb-1 mt-3 text-base">
                    <i class="ri-id-card-line"></i> Profile
                </div>
                <a href="{{ route('user.profile.setting') }}#personal" class="flex items-center gap-3 py-1 text-white hover:text-blue-300 transition">
                    <i class="ri-user-line text-xl text-blue-400"></i>
                    <div class="flex-1">
                        <h3 class="font-bold text-sm">Personal</h3>
                        <p class="text-gray-400 text-xs">Your personal information</p>
                    </div>
                    <i class="ri-arrow-right-s-line text-gray-400 text-lg"></i>
                </a>
                <hr class="my-1 border-gray-700">
                <a href="{{ route('user.profile.setting') }}#security" class="flex items-center gap-3 py-1 text-white hover:text-blue-300 transition">
                    <i class="ri-lock-line text-xl text-blue-400"></i>
                    <div class="flex-1">
                        <h3 class="font-bold text-sm">Security</h3>
                        <p class="text-gray-400 text-xs">Email and password</p>
                    </div>
                    <i class="ri-arrow-right-s-line text-gray-400 text-lg"></i>
                </a>
                <hr class="my-1 border-gray-700">

                <!-- Setup Section (Logout last, Account removed) -->
                <div class="section-title flex items-center gap-2 text-blue-200 font-bold mb-1 mt-3 text-base">
                    <i class="ri-user-settings-line"></i> Setup
                </div>
                <a href="{{ route('user.logout') }}" class="flex items-center gap-3 py-1 text-white hover:text-red-400 transition">
                    <i class="ri-logout-circle-line text-xl text-red-400"></i>
                    <div class="flex-1">
                        <h3 class="font-bold text-sm">Logout</h3>
                        <p class="text-gray-400 text-xs">Sign out of your account</p>
                    </div>
                    <i class="ri-arrow-right-s-line text-gray-400 text-lg"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Menu -->
<div x-data="{ open: false, showSettings: false }" class="lg:hidden inset-0 overflow-hidden z-50" role="dialog">
    <!-- Menu Button -->
    <button @click="open = true" class="p-2 text-white bg-gradient-to-r from-[#9333ea] to-[#2563eb] rounded-md shadow-md">
        <i class="ri-menu-line"></i>
    </button>

    <!-- Menu Content -->
    <div x-show="open" @click.away="open = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90">
        <div class="bg-gray-900 rounded-lg p-4 w-11/12 max-w-md relative shadow-xl">
            <button @click="open = false" class="absolute top-4 right-4 text-gray-300 hover:text-purple-400">
                <i class="ri-close-line"></i>
            </button>
            <nav class="grid grid-cols-4 gap-4">
                <a href="{{ route('user.home') }}" class="flex flex-col items-center gap-1 rounded-lg p-3 bg-gradient-to-r from-[#9333ea] to-[#2563eb] text-white shadow-md">
                    <i class="ri-dashboard-line text-2xl"></i> Home
                </a>
                {{-- <a href="{{ route('trade.index') }}" class="flex flex-col items-center gap-1 rounded-lg p-3 text-gray-300 hover:bg-gradient-to-r from-[#9333ea] to-[#2563eb] hover:text-white transition-all">
                    <i class="ri-exchange-box-line text-2xl"></i> Trade
                </a> --}}
                <a href="{{ route('crypto.deposit.index') }}" class="flex flex-col items-center gap-1 rounded-lg p-3 text-gray-300 hover:bg-gradient-to-r from-[#9333ea] to-[#2563eb] hover:text-white transition-all">
                    <i class="ri-arrow-right-circle-line text-2xl"></i> Deposit
                </a>
                <a href="{{ route('user.withdraw') }}" class="flex flex-col items-center gap-1 rounded-lg p-3 text-gray-300 hover:bg-gradient-to-r from-[#9333ea] to-[#2563eb] hover:text-white transition-all">
                    <i class="ri-arrow-left-circle-line text-2xl"></i> Withdraw
                </a>
                <a href="{{ route('user.wallet.list') }}" class="flex flex-col items-center gap-1 rounded-lg p-3 text-gray-300 hover:bg-gradient-to-r from-[#9333ea] to-[#2563eb] hover:text-white transition-all">
                    <i class="ri-wallet-3-line text-2xl"></i> Wallet
                </a>

                <a href="{{ route('market.index') }}" class="flex flex-col items-center gap-1 rounded-lg p-3 text-gray-300 hover:bg-gradient-to-r from-[#9333ea] to-[#2563eb] hover:text-white transition-all">
                    <i class="ri-line-chart-line text-2xl"></i> Markets
                </a>
                <a href="{{ route('staking.index') }}" class="flex flex-col items-center gap-1 rounded-lg p-3 text-gray-300 hover:bg-gradient-to-r from-[#9333ea] to-[#2563eb] hover:text-white transition-all">
                    <i class="ri-money-dollar-circle-line text-2xl"></i> Stake
                </a>
              <a href="#" @click.prevent="showSettings = true" class="flex flex-col items-center gap-1 rounded-lg p-3 text-gray-300 hover:bg-gradient-to-r from-[#9333ea] to-[#2563eb] hover:text-white transition-all">
    <i class="ri-settings-3-line text-2xl"></i> Settings
</a>
                <a href="{{ route('user.logout') }}" class="flex flex-col items-center gap-1 rounded-lg p-3 text-gray-300 hover:bg-gradient-to-r from-[#9333ea] to-[#2563eb] hover:text-white transition-all">
                    <i class="ri-logout-circle-line text-2xl"></i> Logout
                </a>
            </nav>
        </div>
    </div>

    <!-- Settings Card Slide-out -->
    <div x-show="showSettings" x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full opacity-0"
         x-transition:enter-end="translate-x-0 opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0 opacity-100"
         x-transition:leave-end="translate-x-full opacity-0"
         class="fixed top-0 right-0 h-full w-full max-w-sm bg-gradient-to-br from-gray-900 via-[#2563eb] to-[#9333ea] z-50 shadow-2xl overflow-y-auto rounded-l-2xl"
         style="display: none;">
        <button @click="showSettings = false" class="absolute top-4 right-4 text-gray-300 hover:text-purple-400 transition">
            <i class="ri-close-line text-3xl"></i>
        </button>
        <div class="container mx-auto p-4">
            <!-- User Info -->
            <header class="flex items-center gap-4 mb-4">
                <div class="avatar w-12 h-12 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center text-white text-2xl shadow-lg border-2 border-white">
                    <i class="ri-user-line"></i>
                </div>
                <div class="user-info">
                    <h1 class="text-lg font-bold text-white">{{ auth()->user()->fullname ?? auth()->user()->username }}</h1>
                    <p class="text-gray-200 text-xs">{{ auth()->user()->email }}</p>
                </div>
            </header>
            <div>
                <!-- Payments Section -->
                <div class="section-title flex items-center gap-2 text-blue-200 font-bold mb-1 text-base">
                    <i class="ri-credit-card-line"></i> Payments
                </div>
                <a href="{{ route('crypto.deposit.index') }}" class="flex items-center gap-3 py-1 text-white hover:text-blue-300 transition">
                    <i class="ri-money-dollar-circle-line text-xl text-blue-400"></i>
                    <div class="flex-1">
                        <h3 class="font-bold text-sm">Deposit</h3>
                        <p class="text-gray-400 text-xs">Add funds to your account</p>
                    </div>
                    <i class="ri-arrow-right-s-line text-gray-400 text-lg"></i>
                </a>
                <hr class="my-1 border-gray-700">
                <a href="{{ route('user.withdraw') }}" class="flex items-center gap-3 py-1 text-white hover:text-blue-300 transition">
                    <i class="ri-hand-coin-line text-xl text-blue-400"></i>
                    <div class="flex-1">
                        <h3 class="font-bold text-sm">Withdraw</h3>
                        <p class="text-gray-400 text-xs">Transfer out your funds</p>
                    </div>
                    <i class="ri-arrow-right-s-line text-gray-400 text-lg"></i>
                </a>
                <hr class="my-1 border-gray-700">

                <!-- Profile Section -->
                <div class="section-title flex items-center gap-2 text-blue-200 font-bold mb-1 mt-3 text-base">
                    <i class="ri-id-card-line"></i> Profile
                </div>
                <a href="{{ route('user.profile.setting') }}#personal" class="flex items-center gap-3 py-1 text-white hover:text-blue-300 transition">
                    <i class="ri-user-line text-xl text-blue-400"></i>
                    <div class="flex-1">
                        <h3 class="font-bold text-sm">Personal</h3>
                        <p class="text-gray-400 text-xs">Your personal information</p>
                    </div>
                    <i class="ri-arrow-right-s-line text-gray-400 text-lg"></i>
                </a>
                <hr class="my-1 border-gray-700">
                <a href="{{ route('user.profile.setting') }}#security" class="flex items-center gap-3 py-1 text-white hover:text-blue-300 transition">
                    <i class="ri-lock-line text-xl text-blue-400"></i>
                    <div class="flex-1">
                        <h3 class="font-bold text-sm">Security</h3>
                        <p class="text-gray-400 text-xs">Email and password</p>
                    </div>
                    <i class="ri-arrow-right-s-line text-gray-400 text-lg"></i>
                </a>
                <hr class="my-1 border-gray-700">

                <!-- Setup Section (Logout last, Account removed) -->
                <div class="section-title flex items-center gap-2 text-blue-200 font-bold mb-1 mt-3 text-base">
                    <i class="ri-user-settings-line"></i> Setup
                </div>
                <a href="{{ route('user.logout') }}" class="flex items-center gap-3 py-1 text-white hover:text-red-400 transition">
                    <i class="ri-logout-circle-line text-xl text-red-400"></i>
                    <div class="flex-1">
                        <h3 class="font-bold text-sm">Logout</h3>
                        <p class="text-gray-400 text-xs">Sign out of your account</p>
                    </div>
                    <i class="ri-arrow-right-s-line text-gray-400 text-lg"></i>
                </a>
            </div>
        </div>
    </div>
</div>
