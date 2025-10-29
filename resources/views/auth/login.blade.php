<x-guest-layout>
    <!-- Header -->
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back</h2>
        <p class="text-gray-600">Sign in to your account and manage your complaints</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 bg-green-100 border border-green-300 text-green-800 p-3 rounded-lg" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-900" />
            <div class="relative mt-2">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <x-text-input id="email" class="block w-full pl-12 bg-white/50 border border-gray-300 text-gray-900 placeholder-gray-500 rounded-lg focus:border-blue-600 focus:bg-white focus:ring-1 focus:ring-blue-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="your@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-900" />
            <div class="relative mt-2" x-data="{ showPassword: false }">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" class="block w-full pl-12 pr-12 bg-white/50 border border-gray-300 text-gray-900 placeholder-gray-500 rounded-lg focus:border-blue-600 focus:bg-white focus:ring-1 focus:ring-blue-500" x-bind:type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="Enter your password" @keydown.enter="$el.form.submit()" />
                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-600 hover:text-blue-600 transition">
                    <!-- Eye Icon (when password is hidden) -->
                    <template x-if="!showPassword">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </template>
                    <!-- Eye Off Icon (when password is shown) -->
                    <template x-if="showPassword">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </template>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 bg-white text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-700">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <div>
            <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-700 to-blue-900 hover:from-blue-800 hover:to-blue-950 text-white font-semibold rounded-lg transition shadow-md hover:shadow-lg flex items-center justify-center">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                {{ __('Sign In') }}
            </button>
        </div>

        <!-- Register Link -->
        <div class="text-center pt-6 border-t border-gray-300">
            <p class="text-sm text-gray-700">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition">
                    Register as Citizen
                </a>
            </p>
        </div>

        <!-- Test Accounts Info -->
        <div class="mt-6 p-4 rounded-lg bg-blue-50 border border-blue-200">
            <p class="text-xs font-semibold text-blue-900 mb-3">📝 Demo Accounts:</p>
            <div class="text-xs text-blue-800 space-y-2">
                <div class="flex justify-between items-center">
                    <span><strong>Captain:</strong> captain@mail.com</span>
                    <span class="text-blue-700">/ password</span>
                </div>
                <div class="flex justify-between items-center">
                    <span><strong>Secretary:</strong> secretary@mail.com</span>
                    <span class="text-blue-700">/ password</span>
                </div>
                <hr class="my-2 border-blue-300">
                <div class="flex justify-between items-center">
                    <span><strong>Tanod 1:</strong> tanod1@mail.com</span>
                    <span class="text-blue-700">/ password</span>
                </div>
                <div class="flex justify-between items-center">
                    <span><strong>Tanod 2:</strong> tanod2@mail.com</span>
                    <span class="text-blue-700">/ password</span>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
