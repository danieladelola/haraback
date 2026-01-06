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

        .d-none {
            display: none !important;
        }

        /* Verification code styling - keeping the 6-box layout exactly as it was */
        .verification-code {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .verification-code input {
            height: 50px;
            width: 50px;
            text-align: center;
            font-size: 18px;
            font-weight: 600;
            border: 2px solid #d1d5db;
            border-radius: 8px;
            background: white;
            color: #374151;
            transition: all 0.3s ease;
        }

        .verification-code input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .verification-code input:not(:placeholder-shown) {
            border-color: #3b82f6;
            background: #f8fafc;
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

    <div class="w-full max-w-md z-10 fade-in">
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

        <!-- Verification Form -->
        <div class="bg-white bg-opacity-80 backdrop-blur-lg rounded-xl shadow-xl overflow-hidden border border-gray-200 glow-box transform hover:scale-[1.005] transition duration-500">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 py-6 px-8 border-b border-blue-500">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-envelope-circle-check mr-3 text-blue-200"></i>
                    @lang('Verify Email Address')
                </h2>
                <p class="text-blue-200 mt-1">@lang('A 6 digit verification code sent to your email address')</p>
            </div>

            <!-- Body -->
            <div class="p-8">
                <form action="{{ route('user.verify.email') }}" method="POST" class="space-y-6 submit-form">
                    @csrf

                    <p class="text-gray-600 text-sm">
                        @lang('Code sent to'):
                        <span class="font-semibold text-blue-600">{{ showEmailAddress(auth()->user()->email) }}</span>
                    </p>

                    <!-- 6-Box Verification Code - Keeping exact same structure and functionality -->
                    <div class="verification-code">
                        <input type="text" name="code[]" class="overflow-hidden" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        <input type="text" name="code[]" class="overflow-hidden" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        <input type="text" name="code[]" class="overflow-hidden" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        <input type="text" name="code[]" class="overflow-hidden" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        <input type="text" name="code[]" class="overflow-hidden" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        <input type="text" name="code[]" class="overflow-hidden" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>

                    <!-- Submit -->
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full btn-gradient text-white font-medium py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            @lang('Submit')
                        </button>
                    </div>

                    <!-- Countdown + Try Again -->
                    <div class="text-sm text-gray-600">
                        <p class="countdown-wrapper-text">
                            @lang('If you don\'t get any code'),
                            <span class="countdown-wrapper">
                                @lang('try again after')
                                <span id="countdown" class="text-blue-600 font-bold">--</span>
                                @lang('seconds')
                            </span>
                            <a href="{{ route('user.send.verify.code', 'email') }}"
                               class="try-again-link d-none text-blue-600 hover:underline">
                                @lang('Try again')
                            </a>
                        </p>
                        <a href="{{ route('user.logout') }}" class="mt-2 inline-block text-red-500 hover:underline">
                            @lang('Logout')
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-6 text-center text-gray-500 text-sm">
            <p>© 2020 {{ gs()->siteName(__($pageTitle)) }}. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Countdown timer - keeping exact same functionality
        var distance = Number("{{ @$user->ver_code_send_at->addMinutes(2)->timestamp - time() }}");
        var x = setInterval(function() {
            distance--;
            document.getElementById("countdown").innerHTML = distance;
            if (distance <= 0) {
                clearInterval(x);
                document.querySelector('.countdown-wrapper').classList.add('d-none');
                document.querySelector('.try-again-link').classList.remove('d-none');
            }
        }, 1000);

        // Verification code input auto-focus - keeping exact same functionality
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.verification-code input');
            
            inputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    if (this.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });
                
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value.length === 0 && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });
        });
    </script>
</body>
</html>