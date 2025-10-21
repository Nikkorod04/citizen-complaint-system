<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barangay Complaint System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
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
        
        /* Glowing effect */
        .glow {
            box-shadow: 0 0 20px rgba(79, 70, 229, 0.3), 0 0 40px rgba(139, 92, 246, 0.2);
        }
        
        /* Hover glow */
        .hover-glow:hover {
            box-shadow: 0 0 30px rgba(79, 70, 229, 0.5), 0 0 50px rgba(139, 92, 246, 0.3);
            transition: all 0.3s ease;
        }
        
        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .floating {
            animation: float 3s ease-in-out infinite;
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #8b5cf6 50%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Smooth transitions */
        * {
            transition: color 0.3s ease, background-color 0.3s ease;
        }

        .relative {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body class="antialiased">
    <!-- Animated Background -->
    <div class="animated-bg"></div>

    <div class="relative min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="glass-effect fixed w-full z-50 top-0 border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('/logo.png') }}" alt="Logo" class="h-8 w-8 object-contain">
                        <span class="text-xl font-bold gradient-text">Barangay Complaint System</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-white/70 hover:text-white px-4 py-2 rounded-lg text-sm font-medium transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-white/70 hover:text-white px-4 py-2 rounded-lg text-sm font-medium transition">Login</a>
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-700 hover:to-purple-700 px-6 py-2 rounded-lg text-sm font-semibold transition shadow-lg hover-glow">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 flex-1 flex items-center">
            <div class="max-w-6xl mx-auto w-full">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div>
                        <div class="space-y-8">
                            <div>
                               
                                <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                                    IGSUMAT! <span class="gradient-text">Brgy Complaint System</span>
                                </h1>
                                <p class="text-lg text-white/60 mb-8 leading-relaxed">
                                    A transparent, citizen-centric platform for filing and tracking complaints with real-time updates and community impact metrics for Brgy 99 Dulag.
                                </p>
                            </div>

                            <!-- CTA Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4">
                                <a href="{{ route('register') }}" class="group relative px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover-glow shadow-2xl flex items-center justify-center overflow-hidden">
                                    <span class="relative z-10">Get Started</span>
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                                <a href="{{ route('login') }}" class="px-8 py-4 glass-effect text-white font-semibold rounded-xl hover:bg-white/15 transition border border-white/20 flex items-center justify-center">
                                    Sign In
                                </a>
                            </div>

                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-4 pt-8">
                                <div class="glass-effect rounded-lg p-4">
                                    <p class="text-2xl font-bold gradient-text">24/7</p>
                                    <p class="text-white/50 text-sm">Available</p>
                                </div>
                                <div class="glass-effect rounded-lg p-4">
                                    <p class="text-2xl font-bold gradient-text">100%</p>
                                    <p class="text-white/50 text-sm">Secure</p>
                                </div>
                                <div class="glass-effect rounded-lg p-4">
                                    <p class="text-2xl font-bold gradient-text">Live</p>
                                    <p class="text-white/50 text-sm">Tracking</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Visual -->
                    <div class="hidden lg:block">
                        <div class="relative">
                            <!-- Floating Cards -->
                            <div class="glass-effect rounded-2xl p-6 mb-6 glow floating" style="animation-delay: 0s;">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-white font-semibold">Complaint Filed</p>
                                        <p class="text-white/50 text-sm">2 hours ago</p>
                                    </div>
                                </div>
                            </div>
                            <div class="glass-effect rounded-2xl p-6 ml-8 glow floating" style="animation-delay: 0.5s;">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-white font-semibold">In Progress</p>
                                        <p class="text-white/50 text-sm">Captain assigned</p>
                                    </div>
                                </div>
                            </div>
                            <div class="glass-effect rounded-2xl p-6 mt-6 glow floating" style="animation-delay: 1s;">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-white font-semibold">Resolved</p>
                                        <p class="text-white/50 text-sm">Action taken</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-20 px-4 sm:px-6 lg:px-8 relative">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                        Powerful <span class="gradient-text">Features</span>
                    </h2>
                    <p class="text-white/60 text-lg max-w-2xl mx-auto">
                        Everything you need for transparent governance and citizen engagement
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <!-- Feature 1 -->
                    <div class="group glass-effect rounded-2xl p-8 hover:bg-white/15 transition border border-white/10 hover:border-indigo-400/50">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center mb-6 group-hover:scale-110 transition">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Media Evidence</h3>
                        <p class="text-white/60">Upload photos and videos as supporting evidence for your complaints</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="group glass-effect rounded-2xl p-8 hover:bg-white/15 transition border border-white/10 hover:border-purple-400/50">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center mb-6 group-hover:scale-110 transition">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Verified Citizens</h3>
                        <p class="text-white/60">Secure registration with National ID verification for authenticity</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="group glass-effect rounded-2xl p-8 hover:bg-white/15 transition border border-white/10 hover:border-emerald-400/50">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center mb-6 group-hover:scale-110 transition">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Real-time Tracking</h3>
                        <p class="text-white/60">Monitor complaint status with live updates from your barangay captain</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="group glass-effect rounded-2xl p-8 hover:bg-white/15 transition border border-white/10 hover:border-orange-400/50">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center mb-6 group-hover:scale-110 transition">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">QR Code Access</h3>
                        <p class="text-white/60">Unique QR code for easy identification and community engagement</p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="group glass-effect rounded-2xl p-8 hover:bg-white/15 transition border border-white/10 hover:border-indigo-400/50">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-500 flex items-center justify-center mb-6 group-hover:scale-110 transition">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Fast Resolution</h3>
                        <p class="text-white/60">Streamlined process for quick complaint validation and resolution</p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="group glass-effect rounded-2xl p-8 hover:bg-white/15 transition border border-white/10 hover:border-cyan-400/50">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-500 flex items-center justify-center mb-6 group-hover:scale-110 transition">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Analytics & Reports</h3>
                        <p class="text-white/60">View comprehensive insights and community impact metrics</p>
                    </div>
                </div>
            </div>
        </div>

        
        <!-- Footer -->
        <footer class="mt-auto py-8 px-4 border-t border-white/10">
            <div class="max-w-7xl mx-auto text-center">
                <p class="text-white/50">© {{ date('Y') }} Barangay Complaint System. All rights reserved.</p>
            </div>
        </footer>
    </div>
</body>
</html>
