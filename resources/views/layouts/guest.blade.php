<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                background: linear-gradient(135deg, #f8fafc 0%, #e8f4f8 50%, #f0f9ff 100%);
                min-height: 100vh;
                position: relative;
                overflow-x: hidden;
            }
            
            /* Subtle animated background */
            .animated-bg {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, 
                    rgba(15, 118, 165, 0.03) 0%,
                    rgba(30, 144, 255, 0.02) 50%,
                    rgba(15, 118, 165, 0.03) 100%);
                pointer-events: none;
                z-index: 0;
            }
            
            /* Professional glassmorphism */
            .glass-effect {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(30, 58, 138, 0.15);
            }
            
            /* Gradient text - Government blue palette */
            .gradient-text {
                background: linear-gradient(135deg, #1e3a8a 0%, #1565c0 50%, #0d47a1 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            
            /* Subtle glow */
            .glow {
                box-shadow: 0 0 15px rgba(30, 58, 138, 0.1);
            }
            
            .hover-glow:hover {
                box-shadow: 0 0 25px rgba(30, 58, 138, 0.15);
                transition: all 0.3s ease;
            }

            .content-wrapper {
                position: relative;
                z-index: 1;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="animated-bg"></div>
        
        <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 px-4 content-wrapper">
            <!-- Logo -->
            <div class="mb-8 self-start sm:self-center">
                <a href="/" class="flex flex-col sm:flex-row items-center sm:space-x-3 text-center sm:text-left">
                    <img src="{{ asset('/logo.png') }}" alt="Logo" class="h-12 w-12 object-contain mb-2 sm:mb-0">
                    <div>
                        <div class="text-2xl font-bold gradient-text">Barangay</div>
                        <div class="text-sm font-semibold text-gray-700">Complaint System</div>
                    </div>
                </a>
            </div>

            <!-- Auth Card -->
            <div class="w-full max-w-2xl">
                <div class="glass-effect rounded-2xl p-6 sm:p-10 glow border border-blue-200/50">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer Text -->
            <div class="mt-8 text-center text-gray-600 text-sm">
                <p>© {{ date('Y') }} Barangay Complaint System.</p>
            </div>
        </div>
    </body>
</html>
