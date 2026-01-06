@extends($activeTemplate . 'layouts.master2')

@section('content')
<main class="p-4 sm:px-6 flex-1 overflow-auto">

    <!-- Profile Section -->
    <div class="flex justify-center">
        <div class="w-full md:w-2/3 lg:w-1/2">
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-2xl border border-gray-700">
                <div class="bg-gradient-to-r from-purple-900 via-indigo-900 to-blue-900 p-4 rounded-t-2xl">
                    <h5 class="text-white text-lg font-bold">@lang('Profile')</h5>
                </div>
                <div class="p-6">
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">@lang('First Name')</label>
                                <input type="text" name="firstname" value="{{ $user->firstname }}"
                                       class="bg-gray-800 text-white rounded-lg px-4 py-3 w-full border border-gray-700
                                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition duration-200"
                                       required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">@lang('Last Name')</label>
                                <input type="text" name="lastname" value="{{ $user->lastname }}"
                                       class="bg-gray-800 text-white rounded-lg px-4 py-3 w-full border border-gray-700
                                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition duration-200"
                                       required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">@lang('E-mail Address')</label>
                                <input value="{{ $user->email }}" readonly
                                       class="bg-gray-700 text-gray-400 rounded-lg px-4 py-3 w-full border border-gray-600">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">@lang('Mobile Number')</label>
                                <input value="{{ $user->mobile }}" readonly
                                       class="bg-gray-700 text-gray-400 rounded-lg px-4 py-3 w-full border border-gray-600">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">@lang('Address')</label>
                                <input type="text" name="address" value="{{ $user->address }}"
                                       class="bg-gray-800 text-white rounded-lg px-4 py-3 w-full border border-gray-700
                                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">@lang('State')</label>
                                <input type="text" name="state" value="{{ $user->state }}"
                                       class="bg-gray-800 text-white rounded-lg px-4 py-3 w-full border border-gray-700
                                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">@lang('Zip Code')</label>
                                <input type="text" name="zip" value="{{ $user->zip }}"
                                       class="bg-gray-800 text-white rounded-lg px-4 py-3 w-full border border-gray-700
                                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">@lang('City')</label>
                                <input type="text" name="city" value="{{ $user->city }}"
                                       class="bg-gray-800 text-white rounded-lg px-4 py-3 w-full border border-gray-700
                                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">@lang('Country')</label>
                                <input value="{{ $user->country_name }}" disabled
                                       class="bg-gray-700 text-gray-400 rounded-lg px-4 py-3 w-full border border-gray-600">
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700
                                           text-white font-medium py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                                @lang('Submit')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password -->
    <div class="flex justify-center mt-8">
        <div class="w-full md:w-2/3 lg:w-1/2">
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-2xl border border-gray-700">
                <div class="bg-gradient-to-r from-purple-900 via-indigo-900 to-blue-900 p-4 rounded-t-2xl">
                    <h5 class="text-white text-lg font-bold">@lang('Change Password')</h5>
                </div>
                <div class="p-6">
                    <form action="{{ route('user.password.update') }}" method="post">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">@lang('Current Password')</label>
                                <input type="password" name="current_password"
                                       class="bg-gray-800 text-white rounded-lg px-4 py-3 w-full border border-gray-700
                                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">@lang('New Password')</label>
                                <input type="password" name="new_password"
                                       class="bg-gray-800 text-white rounded-lg px-4 py-3 w-full border border-gray-700
                                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-300 mb-2">@lang('Confirm New Password')</label>
                            <input type="password" name="new_password_confirmation"
                                   class="bg-gray-800 text-white rounded-lg px-4 py-3 w-full border border-gray-700
                                          focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div class="pt-6">
                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700
                                           text-white font-medium py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                                @lang('Change Password')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Email -->
    <div class="flex justify-center mt-8">
        <div class="w-full md:w-2/3 lg:w-1/2">
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-2xl border border-gray-700">
                <div class="bg-gradient-to-r from-purple-900 via-indigo-900 to-blue-900 p-4 rounded-t-2xl">
                    <h5 class="text-white text-lg font-bold">@lang('Change Email Address')</h5>
                </div>
                <div class="p-6">
                    <form action="{{ route('user.email.update') }}" method="post">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-300 mb-2">@lang('Current Email')</label>
                            <input type="email" value="{{ $user->email }}" readonly
                                   class="bg-gray-700 text-gray-400 rounded-lg px-4 py-3 w-full border border-gray-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">@lang('New Email Address')</label>
                            <input type="email" name="new_email"
                                   class="bg-gray-800 text-white rounded-lg px-4 py-3 w-full border border-gray-700
                                          focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div class="pt-6">
                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700
                                           text-white font-medium py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                                @lang('Change Email')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    </script>
@endif
@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            timer: 2500,
            showConfirmButton: false
        });
    </script>
@endif
@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ $errors->first() }}',
            timer: 2500,
            showConfirmButton: false
        });
    </script>
@endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
