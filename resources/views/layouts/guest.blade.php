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
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #0f1419 50%, #1a1f35 75%, #0f172a 100%);
                min-height: 100vh;
                position: relative;
                overflow-x: hidden;
            }
            
            /* Animated gradient background */
            .animated-bg {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, 
                    rgba(79, 70, 229, 0.1) 0%,
                    rgba(139, 92, 246, 0.05) 25%,
                    rgba(59, 130, 246, 0.1) 50%,
                    rgba(30, 144, 255, 0.05) 75%,
                    rgba(79, 70, 229, 0.1) 100%);
                pointer-events: none;
                z-index: 0;
            }
            
            /* Glassmorphism effect */
            .glass-effect {
                background: rgba(255, 255, 255, 0.08);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
            
            /* Gradient text */
            .gradient-text {
                background: linear-gradient(135deg, #4f46e5 0%, #8b5cf6 50%, #3b82f6 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            
            /* Glow effect */
            .glow {
                box-shadow: 0 0 20px rgba(79, 70, 229, 0.3), 0 0 40px rgba(139, 92, 246, 0.2);
            }
            
            .hover-glow:hover {
                box-shadow: 0 0 30px rgba(79, 70, 229, 0.5), 0 0 50px rgba(139, 92, 246, 0.3);
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
                        <div class="text-sm font-semibold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">Complaint System</div>
                    </div>
                </a>
            </div>

            <!-- Auth Card -->
            <div class="w-full max-w-2xl">
                <div class="glass-effect rounded-2xl p-6 sm:p-10 glow border border-white/10">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer Text -->
            <div class="mt-8 text-center text-white/50 text-sm">
                <p>© {{ date('Y') }} Barangay Complaint System</p>
            </div>
        </div>
    </body>
</html>
