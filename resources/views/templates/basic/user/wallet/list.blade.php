@extends($activeTemplate . 'layouts.master2')

@section('content')
<main class="p-4 flex-1 overflow-auto bg-gray-900 text-gray-100">
    <div class="max-w-7xl mx-auto w-full"> <!-- keeps it centered but wide -->
        <div class="p-6 rounded-lg shadow-lg bg-gray-800 border border-gray-700 w-full">
            <h2 class="text-2xl font-semibold mb-6">{{ $pageTitle }}</h2>

            <!-- Responsive Wrapper -->
            <div class="overflow-x-auto rounded-lg border border-gray-700">
                <table class="w-full bg-gray-800 text-gray-100">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="py-3 px-4 text-left">ID</th>
                            <th class="py-3 px-4 text-left">Currency</th>
                            <th class="py-3 px-4 text-left">Balance</th>
                            <th class="py-3 px-4 text-left">USD Value</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse($wallets as $wallet)
                            <tr class="hover:bg-gray-700 transition-colors duration-200">
                                <td class="py-3 px-4">{{ $wallet->id }}</td>
                                <td class="py-3 px-4 flex items-center">
                                    @php $sym = strtolower($wallet->currency); @endphp
                                    <img src="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/master/svg/color/{{ $sym }}.svg"
                                         alt="{{ $wallet->currency }}"
                                         class="h-6 w-6 mr-2">
                                    <span class="font-medium">{{ strtoupper($wallet->currency) }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    {{ number_format($wallet->balance, 4) }} {{ strtoupper($wallet->currency) }}
                                </td>
                                <td class="py-3 px-4">
                                    @if(!is_null($wallet->usd_value))
                                        <span class="text-blue-400">${{ number_format($wallet->usd_value, 2) }}</span>
                                    @else
                                        <span class="text-red-400 text-sm">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 px-4 text-center text-gray-400">
                                    No wallets found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- End Responsive Wrapper -->
        </div>
    </div>
</main>
@endsection
