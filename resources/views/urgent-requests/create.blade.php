<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Submit Urgent Request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Info Box -->
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0-6a4 4 0 100 8 4 4 0 000-8zm0-1a5 5 0 110 10 5 5 0 010-10z" />
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">
                                    Emergency situations only. Use this to report urgent/emergency situations that require immediate Tanod response.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('urgent-requests.store') }}" class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">
                                Request Title <span class="text-red-600">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                value="{{ old('title') }}"
                                placeholder="e.g., Car accident on main street"
                                class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                maxlength="255"
                                required
                            >
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Description <span class="text-red-600">*</span>
                            </label>
                            <textarea 
                                id="description" 
                                name="description"
                                rows="4"
                                placeholder="Provide detailed information about the emergency..."
                                class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                maxlength="1000"
                                required
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">
                                Location <span class="text-red-600">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="location" 
                                name="location"
                                value="{{ old('location') }}"
                                placeholder="Where is the emergency?"
                                class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                maxlength="255"
                                required
                            >
                            @error('location')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">
                                Category <span class="text-red-600">*</span>
                            </label>
                            <select 
                                id="category" 
                                name="category"
                                class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                required
                            >
                                <option value="">-- Select Category --</option>
                                <option value="medical" {{ old('category') == 'medical' ? 'selected' : '' }}>Medical Emergency</option>
                                <option value="accident" {{ old('category') == 'accident' ? 'selected' : '' }}>Accident</option>
                                <option value="fire" {{ old('category') == 'fire' ? 'selected' : '' }}>Fire</option>
                                <option value="security" {{ old('category') == 'security' ? 'selected' : '' }}>Security Threat</option>
                                <option value="disaster" {{ old('category') == 'disaster' ? 'selected' : '' }}>Disaster</option>
                                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other Emergency</option>
                            </select>
                            @error('category')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700">
                                Priority Level <span class="text-red-600">*</span>
                            </label>
                            <select 
                                id="priority" 
                                name="priority"
                                class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                required
                            >
                                <option value="">-- Select Priority --</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                            @error('priority')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('urgent-requests.index') }}" class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition">
                                Cancel
                            </a>
                            <button 
                                type="submit" 
                                class="px-6 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium rounded-lg transition"
                            >
                                Submit Urgent Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
