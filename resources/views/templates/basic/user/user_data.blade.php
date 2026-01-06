<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ gs()->siteName(__($pageTitle)) }}</title>

    <!-- Tailwind CSS with custom animations -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'gradient-x': 'gradient-x 15s ease infinite',
                        'gradient-y': 'gradient-y 15s ease infinite',
                        'gradient-xy': 'gradient-xy 15s ease infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in': 'fade-in 1.2s ease-out',
                    },
                    keyframes: {
                        'gradient-y': {
                            '0%, 100%': {
                                'background-size': '400% 400%',
                                'background-position': 'center top'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'center center'
                            }
                        },
                        'gradient-x': {
                            '0%, 100%': {
                                'background-size': '200% 200%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            }
                        },
                        'gradient-xy': {
                            '0%, 100%': {
                                'background-position': '0% 50%'
                            },
                            '50%': {
                                'background-position': '100% 50%'
                            }
                        },
                        'float': {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' }
                        },
                        'fade-in': {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(-45deg, #f8fafc, #e2e8f0, #f1f5f9, #ffffff);
            background-size: 400% 400%;
            animation: gradient-xy 15s ease infinite;
            min-height: 100vh;
        }

        .glow-box {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.1);
        }

        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-gradient {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6, #ec4899);
            background-size: 200% 200%;
            transition: all 0.5s ease;
        }

        .btn-gradient:hover {
            background-position: right center;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.4);
        }

        .logo-container {
            filter: drop-shadow(0 0 10px rgba(59, 130, 246, 0.2));
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        .fade-in {
            animation: fade-in 1.2s ease-out;
        }

        .gradient-text {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6, #ec4899);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            background-size: 200% 200%;
            animation: gradient-x 8s ease infinite;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <!-- Animated background elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden z-0">
        <div class="absolute top-10% left-10% w-20 h-20 rounded-full bg-blue-100 opacity-50 blur-xl floating"></div>
        <div class="absolute top-70% left-80% w-32 h-32 rounded-full bg-purple-100 opacity-50 blur-xl floating" style="animation-delay: 2s;"></div>
        <div class="absolute top-30% left-60% w-16 h-16 rounded-full bg-pink-100 opacity-50 blur-xl floating" style="animation-delay: 4s;"></div>
    </div>

    <div class="w-full max-w-2xl z-10 fade-in">
        <!-- Logo with animation -->
        <div class="flex justify-between items-center mb-8">
            <div class="logo-container flex items-center space-x-2">
                <a href="/" class="flex items-center transform hover:scale-105 transition duration-300">
                    <span class="text-xl font-semibold text-gray-800">HaraTrading</span>
                </a>
            </div>

            <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900 transition duration-300 group">
                <div class="flex items-center space-x-2">
                    <span class="text-sm font-medium opacity-0 group-hover:opacity-100 transition duration-300">Home</span>
                    <div class="w-10 h-10 rounded-full bg-white bg-opacity-70 flex items-center justify-center border border-gray-300 group-hover:border-blue-500 transition duration-300">
                        <i class="fas fa-home text-xl"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Profile Completion Form -->
        <div class="bg-white bg-opacity-80 backdrop-blur-lg rounded-xl shadow-xl overflow-hidden border border-gray-200 glow-box transform hover:scale-[1.005] transition duration-500">
            <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 py-6 px-8 border-b border-blue-500">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-user-circle mr-3 text-blue-200"></i>
                    {{ __($pageTitle) }}
                </h2>
                <p class="text-blue-200 mt-1">@lang('Please complete your profile information to continue')</p>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('user.data.submit') }}" class="space-y-6">
                    @csrf

                    <!-- Username Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">@lang('Username')</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" class="checkUser bg-white bg-opacity-70 text-gray-800 rounded-lg pl-10 pr-4 py-3 w-full border border-gray-300 focus:outline-none input-glow transition duration-200"
                                   placeholder="@lang('Choose a username')" name="username" value="{{ old('username') }}" required>
                        </div>
                        <small class="text-red-500 usernameExist"></small>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Country Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">@lang('Country')</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-globe text-gray-400"></i>
                                </div>
                                <select name="country" class="form-select bg-white bg-opacity-70 text-gray-800 rounded-lg pl-10 pr-4 py-3 w-full border border-gray-300 focus:outline-none input-glow appearance-none transition duration-200">
                                    @foreach ($countries as $key => $country)
                                        <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">
                                            {{ __($country->country) }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">@lang('Mobile')</label>
                            <div class="flex rounded-md shadow-sm">
                                <span class="mobile-code inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-700 text-sm">
                                    +1
                                </span>
                                <input type="hidden" name="mobile_code">
                                <input type="hidden" name="country_code">
                                <input type="number" name="mobile" value="{{ old('mobile') }}" class="checkUser flex-1 min-w-0 block w-full px-3 py-3 rounded-none rounded-r-md bg-white bg-opacity-70 text-gray-800 border border-gray-300 focus:outline-none input-glow transition duration-200" required>
                            </div>
                            <small class="text-red-500 mobileExist"></small>
                        </div>
                    </div>

                    <!-- Additional Fields (Hidden by default) -->
                    <div class="bg-gray-50 bg-opacity-70 p-4 rounded-lg border border-gray-300">
                        <button type="button" id="toggleAdditionalFields" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-200">
                            <i class="fas fa-chevron-down mr-2"></i>
                            @lang('Additional Information')
                        </button>

                        <div id="additionalFields" class="hidden mt-4 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">@lang('Address')</label>
                                    <input type="text" class="bg-white bg-opacity-70 text-gray-800 rounded-lg px-4 py-3 w-full border border-gray-300 focus:outline-none input-glow transition duration-200" name="address" value="{{ old('address') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">@lang('State')</label>
                                    <input type="text" class="bg-white bg-opacity-70 text-gray-800 rounded-lg px-4 py-3 w-full border border-gray-300 focus:outline-none input-glow transition duration-200" name="state" value="{{ old('state') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">@lang('Zip Code')</label>
                                    <input type="text" class="bg-white bg-opacity-70 text-gray-800 rounded-lg px-4 py-3 w-full border border-gray-300 focus:outline-none input-glow transition duration-200" name="zip" value="{{ old('zip') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">@lang('City')</label>
                                    <input type="text" class="bg-white bg-opacity-70 text-gray-800 rounded-lg px-4 py-3 w-full border border-gray-300 focus:outline-none input-glow transition duration-200" name="city" value="{{ old('city') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full btn-gradient text-white font-medium py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            @lang('Complete Profile')
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-6 text-center text-gray-500 text-sm">
            <p>© 2020 {{ gs()->siteName(__($pageTitle)) }}. All rights reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        "use strict";
        (function($) {
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            // Initialize mobile code based on selected country
            function initMobileCode() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            }

            // Initialize on page load
            initMobileCode();

            $('select[name=country]').on('change', function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
                var value = $('[name=mobile]').val();
                var name = 'mobile';
                checkUser(value, name);
            });

            $('.checkUser').on('focusout', function(e) {
                var value = $(this).val();
                var name = $(this).attr('name')
                checkUser(value, name);
            });

            function checkUser(value, name) {
                var url = '{{ route('user.checkUser') }}';
                var token = '{{ csrf_token() }}';

                if (name == 'mobile') {
                    var mobile = `${value}`;
                    var data = {
                        mobile: mobile,
                        mobile_code: $('.mobile-code').text().substr(1),
                        _token: token
                    }
                }
                if (name == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.field} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            }

            // Toggle additional fields
            $('#toggleAdditionalFields').on('click', function() {
                const additionalFields = $('#additionalFields');
                additionalFields.toggleClass('hidden');

                const icon = $(this).find('i');
                if (additionalFields.hasClass('hidden')) {
                    icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
                } else {
                    icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
                }
            });
        })(jQuery);
    </script>
</body>
</html>