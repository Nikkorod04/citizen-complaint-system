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
        
        /* Subtle glow */
        .glow {
            box-shadow: 0 0 15px rgba(30, 58, 138, 0.1);
        }
        
        .hover-glow:hover {
            box-shadow: 0 0 25px rgba(30, 58, 138, 0.15);
            transition: all 0.3s ease;
        }
        
        /* Gradient text - Government blue palette */
        .gradient-text {
            background: linear-gradient(135deg, #1e3a8a 0%, #1565c0 50%, #0d47a1 100%);
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
        <nav class="glass-effect fixed w-full z-50 top-0 border-b border-blue-200/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('/logo.png') }}" alt="Logo" class="h-8 w-8 object-contain">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-gray-800">Barangay Complaint System</span>
                            <span class="text-xs text-gray-600">Official Government Platform</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg text-sm font-medium transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg text-sm font-medium transition">Login</a>
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-700 to-blue-900 text-white hover:from-blue-800 hover:to-blue-950 px-6 py-2 rounded-lg text-sm font-semibold transition shadow-lg hover-glow">Register</a>
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
                                <p class="text-sm font-semibold text-blue-700 mb-2 uppercase tracking-wider">TRANSPARENT GOVERNANCE</p>
                                <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                                    Strengthen Our <span class="gradient-text">Barangay Community</span>
                                </h1>
                                <p class="text-lg text-gray-700 mb-8 leading-relaxed">
                                    A secure, transparent, and efficient government platform for filing and tracking community complaints. Your voice matters in making our barangay better.
                                </p>
                            </div>

                            <!-- CTA Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4">
                                <a href="{{ route('register') }}" class="group relative px-8 py-4 bg-gradient-to-r from-blue-700 to-blue-900 text-white font-semibold rounded-lg hover-glow shadow-xl flex items-center justify-center overflow-hidden">
                                    <span class="relative z-10">File a Complaint</span>
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                                <a href="{{ route('login') }}" class="px-8 py-4 glass-effect text-gray-900 font-semibold rounded-lg hover:bg-white/10 transition border border-white/20 flex items-center justify-center">
                                    Track Status
                                </a>
                            </div>

                            <!-- Key Info -->
                            <div class="grid grid-cols-3 gap-4 pt-8">
                                <div class="glass-effect rounded-lg p-4 text-center">
                                    <p class="text-2xl font-bold text-blue-700">24/7</p>
                                    <p class="text-gray-600 text-xs mt-1">Available</p>
                                </div>
                                <div class="glass-effect rounded-lg p-4 text-center">
                                    <p class="text-2xl font-bold text-blue-700">Secure</p>
                                    <p class="text-gray-600 text-xs mt-1">Government Grade</p>
                                </div>
                                <div class="glass-effect rounded-lg p-4 text-center">
                                    <p class="text-2xl font-bold text-blue-700">Live</p>
                                    <p class="text-gray-600 text-xs mt-1">Progress Tracking</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Visual - Process Flow -->
                    <div class="hidden lg:block">
                        <div class="space-y-4">
                            <!-- Step 1 -->
                            <div class="glass-effect rounded-lg p-6 glow border-l-4 border-blue-500">
                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 text-blue-700 font-bold">1</div>
                                    <div>
                                        <p class="text-gray-900 font-semibold">Submit Complaint</p>
                                        <p class="text-gray-600 text-sm mt-1">File your complaint with supporting details and evidence</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="glass-effect rounded-lg p-6 glow border-l-4 border-blue-600">
                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-200 flex items-center justify-center flex-shrink-0 text-blue-800 font-bold">2</div>
                                    <div>
                                        <p class="text-gray-900 font-semibold">Verification</p>
                                        <p class="text-gray-600 text-sm mt-1">Secretary reviews and validates your complaint details</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="glass-effect rounded-lg p-6 glow border-l-4 border-blue-700">
                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-300 flex items-center justify-center flex-shrink-0 text-blue-900 font-bold">3</div>
                                    <div>
                                        <p class="text-gray-900 font-semibold">Processing & Action</p>
                                        <p class="text-gray-600 text-sm mt-1">Captain assigns task and takes appropriate action</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div class="glass-effect rounded-lg p-6 glow border-l-4 border-green-600">
                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0 text-green-700 font-bold">✓</div>
                                    <div>
                                        <p class="text-gray-900 font-semibold">Resolution & Feedback</p>
                                        <p class="text-gray-600 text-sm mt-1">Issue resolved with final update and citizen feedback</p>
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
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                        System <span class="gradient-text">Capabilities</span>
                    </h2>
                    <p class="text-gray-700 text-lg max-w-2xl mx-auto">
                        Built for transparency, accountability, and community engagement
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Feature 1 - Secure Filing -->
                    <div class="group glass-effect rounded-lg p-8 hover:bg-white/50 transition border border-blue-200/30">
                        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mb-6 group-hover:bg-blue-200 transition">
                            <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Secure Complaint Filing</h3>
                        <p class="text-gray-700 text-sm">Submit detailed complaints with supporting evidence through an encrypted, secure government channel</p>
                    </div>

                    <!-- Feature 2 - Verification -->
                    <div class="group glass-effect rounded-lg p-8 hover:bg-white/50 transition border border-blue-200/30">
                        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mb-6 group-hover:bg-blue-200 transition">
                            <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Citizen Verification</h3>
                        <p class="text-gray-700 text-sm">National ID verification ensures authentic community feedback and prevents fraudulent complaints</p>
                    </div>

                    <!-- Feature 3 - Real-time Tracking -->
                    <div class="group glass-effect rounded-lg p-8 hover:bg-white/50 transition border border-blue-200/30">
                        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mb-6 group-hover:bg-blue-200 transition">
                            <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Real-time Status Updates</h3>
                        <p class="text-gray-700 text-sm">Track complaint progress in real-time with automatic notifications from initial filing to resolution</p>
                    </div>

                    <!-- Feature 4 - Transparency -->
                    <div class="group glass-effect rounded-lg p-8 hover:bg-white/50 transition border border-blue-200/30">
                        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mb-6 group-hover:bg-blue-200 transition">
                            <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Full Transparency</h3>
                        <p class="text-gray-700 text-sm">View all actions taken on your complaint with clear documentation and government accountability</p>
                    </div>

                    <!-- Feature 5 - Multi-level Review -->
                    <div class="group glass-effect rounded-lg p-8 hover:bg-white/50 transition border border-blue-200/30">
                        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mb-6 group-hover:bg-blue-200 transition">
                            <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Multi-level Processing</h3>
                        <p class="text-gray-700 text-sm">Complaints reviewed by Secretary, assigned by Captain, with proper governance structure</p>
                    </div>

                    <!-- Feature 6 - Evidence Management -->
                    <div class="group glass-effect rounded-lg p-8 hover:bg-white/50 transition border border-blue-200/30">
                        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mb-6 group-hover:bg-blue-200 transition">
                            <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Evidence Preservation</h3>
                        <p class="text-gray-700 text-sm">Securely store and manage photos, videos, and documents as supporting evidence</p>
                    </div>
                </div>
            </div>
        </div>

    

        <!-- Footer -->
        <footer class="mt-auto py-12 px-4 border-t border-blue-200/30">
            <div class="max-w-7xl mx-auto">
                <div class="grid md:grid-cols-3 gap-8 mb-8">
                    <div>
                        <h3 class="text-gray-900 font-semibold mb-4">About</h3>
                        <p class="text-gray-700 text-sm">A government-led initiative to enhance transparency and community engagement in barangay services.</p>
                    </div>
                    <div>
                        <h3 class="text-gray-900 font-semibold mb-4">Support</h3>
                        <ul class="text-gray-700 text-sm space-y-2">
                            <li><a href="#" class="hover:text-gray-900 transition">Help Center</a></li>
                            <li><a href="#" class="hover:text-gray-900 transition">Contact Us</a></li>
                            <li><a href="#" class="hover:text-gray-900 transition">FAQs</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-gray-900 font-semibold mb-4">Resources</h3>
                        <ul class="text-gray-700 text-sm space-y-2">
                            <li><a href="#" class="hover:text-gray-900 transition">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-gray-900 transition">Terms of Service</a></li>
                            <li><a href="#" class="hover:text-gray-900 transition">Documentation</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-blue-200/30 pt-8 text-center">
                    <p class="text-gray-600 text-sm">© {{ date('Y') }} Barangay Complaint System.</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
