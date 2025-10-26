<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ $urgentRequest->title }}
            </h2>
            <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $urgentRequest->getStatusColor() }}">
                {{ ucfirst(str_replace('_', ' ', $urgentRequest->status)) }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Request Details -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Emergency Details</h3>
                            
                            <div class="grid grid-cols-2 gap-6 mb-6">
                                <div>
                                    <p class="text-sm text-gray-600 font-medium">Category</p>
                                    <p class="text-base font-semibold text-gray-900 mt-1">{{ ucfirst($urgentRequest->category) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-medium">Priority</p>
                                    <p class="text-base font-semibold mt-1">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ ucfirst($urgentRequest->priority) }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-medium">Location</p>
                                    <p class="text-base font-semibold text-gray-900 mt-1">{{ $urgentRequest->location }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-medium">Submitted</p>
                                    <p class="text-base font-semibold text-gray-900 mt-1">{{ $urgentRequest->submitted_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600 font-medium">Description</p>
                                <p class="text-base text-gray-900 mt-2 whitespace-pre-line">{{ $urgentRequest->description }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Requester Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Requester Information</h3>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600 font-medium">Name</p>
                                        <p class="text-base font-semibold text-gray-900 mt-1">{{ $urgentRequest->citizen->full_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 font-medium">Contact</p>
                                        <p class="text-base font-semibold text-gray-900 mt-1">{{ $urgentRequest->citizen->phone }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 font-medium">Email</p>
                                        <p class="text-base font-semibold text-gray-900 mt-1">{{ $urgentRequest->citizen->email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 font-medium">Address</p>
                                        <p class="text-base font-semibold text-gray-900 mt-1">{{ Str::limit($urgentRequest->citizen->complete_address, 40) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Update Form (if not yet resolved) -->
                    @if ($urgentRequest->status !== 'resolved')
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Respond to Request</h3>
                                
                                <form method="POST" action="{{ route('tanod.update-status', $urgentRequest->id) }}" class="space-y-4">
                                    @csrf

                                    <!-- Status Selection -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-3">Response Status</label>
                                        <div class="space-y-2">
                                            <label class="flex items-center">
                                                <input type="radio" name="status" value="in_progress" required class="form-radio text-orange-600">
                                                <span class="ml-3 text-gray-700">In Progress</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" name="status" value="on_the_way" required class="form-radio text-purple-600">
                                                <span class="ml-3 text-gray-700">On The Way</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" name="status" value="resolved" required class="form-radio text-green-600">
                                                <span class="ml-3 text-gray-700">Resolved</span>
                                            </label>
                                        </div>
                                        @error('status')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Message -->
                                    <div>
                                        <label for="message" class="block text-sm font-medium text-gray-700">Message (optional)</label>
                                        <textarea 
                                            id="message" 
                                            name="message"
                                            rows="3"
                                            placeholder="Add any important details for the requester..."
                                            class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            maxlength="500"
                                        ></textarea>
                                        @error('message')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="flex gap-2 pt-4">
                                        <button 
                                            type="submit" 
                                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition"
                                        >
                                            Update Status
                                        </button>
                                        <a href="{{ route('tanod.dashboard') }}" class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition">
                                            Cancel
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Status Update History -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Response History</h3>
                                
                                <div class="space-y-4">
                                    @foreach ($updates as $update)
                                        <div class="border-l-4 border-blue-500 pl-4 py-2">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $update->getStatusBadge() }}">
                                                        {{ ucfirst(str_replace('_', ' ', $update->status)) }}
                                                    </span>
                                                    <p class="text-xs text-gray-600 mt-1">{{ $update->created_at->format('M d, H:i') }}</p>
                                                </div>
                                            </div>
                                            @if ($update->message)
                                                <p class="text-sm text-gray-700 mt-2">{{ $update->message }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    
                    <!-- Request Summary -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Request Summary</h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs text-gray-600 font-medium">Request ID</p>
                                    <p class="text-base font-semibold text-gray-900 break-all">#{{ $urgentRequest->id }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 font-medium">Status</p>
                                    <p class="text-base font-semibold text-gray-900 mt-1">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $urgentRequest->getStatusColor() }}">
                                            {{ ucfirst(str_replace('_', ' ', $urgentRequest->status)) }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 font-medium">Priority</p>
                                    <p class="text-base font-semibold text-gray-900 mt-1">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ ucfirst($urgentRequest->priority) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <p class="text-xs text-gray-600 font-medium mb-2">Timeline</p>
                                    <ul class="space-y-2 text-sm">
                                        <li class="flex justify-between">
                                            <span>Submitted:</span>
                                            <span class="font-semibold">{{ $urgentRequest->submitted_at->format('M d') }}</span>
                                        </li>
                                        @if ($urgentRequest->assigned_at)
                                            <li class="flex justify-between">
                                                <span>Assigned:</span>
                                                <span class="font-semibold">{{ $urgentRequest->assigned_at->format('M d') }}</span>
                                            </li>
                                        @endif
                                        @if ($urgentRequest->responded_at)
                                            <li class="flex justify-between">
                                                <span>Responded:</span>
                                                <span class="font-semibold">{{ $urgentRequest->responded_at->format('M d') }}</span>
                                            </li>
                                        @endif
                                        @if ($urgentRequest->resolved_at)
                                            <li class="flex justify-between">
                                                <span>Resolved:</span>
                                                <span class="font-semibold">{{ $urgentRequest->resolved_at->format('M d') }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Tips -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="text-sm font-semibold text-blue-900 mb-3">Quick Tips</h4>
                        <ul class="text-sm text-blue-800 space-y-2">
                            <li>• Always acknowledge receipt promptly</li>
                            <li>• Keep citizen updated on progress</li>
                            <li>• Mark as "On The Way" when en route</li>
                            <li>• Mark as "Resolved" when completed</li>
                            <li>• Add optional location coordinates</li>
                        </ul>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
