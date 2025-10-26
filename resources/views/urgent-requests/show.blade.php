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
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('urgent-requests.index') }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Urgent Requests
            </a>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="col-span-3 lg:col-span-2 space-y-6">
                <!-- Request Header Card -->
                <div class="bg-white rounded-xl border border-blue-200/50 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $urgentRequest->title }}</h1>
                            <p class="text-gray-600">Submitted on {{ $urgentRequest->submitted_at->format('M d, Y \a\t H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-4 py-2 rounded-lg font-semibold mb-2 {{ $urgentRequest->getStatusColor() }}">
                                {{ ucfirst(str_replace('_', ' ', $urgentRequest->status)) }}
                            </span>
                            <br>
                            <span class="inline-block px-4 py-2 rounded-lg font-semibold bg-red-100 text-red-800">
                                {{ ucfirst($urgentRequest->priority) }} Priority
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Request Details Card -->
                <div class="bg-white rounded-xl border border-blue-200/50 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Request Details</h2>
                    <div class="space-y-4">
                        <div>
                            <span class="text-sm font-medium text-gray-600">Category</span>
                            <p class="text-gray-900 font-semibold">{{ ucfirst($urgentRequest->category) }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Location</span>
                            <p class="text-gray-900 font-semibold">{{ $urgentRequest->location }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Description</span>
                            <p class="text-gray-900 mt-2 whitespace-pre-wrap">{{ $urgentRequest->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Assigned Tanod Card -->
                @if ($urgentRequest->tanod)
                    <div class="bg-white rounded-xl border border-blue-200/50 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Assigned Tanod</h2>
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr($urgentRequest->tanod->first_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">
                                        {{ $urgentRequest->tanod->first_name }} {{ $urgentRequest->tanod->last_name }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Assigned at {{ $urgentRequest->assigned_at?->format('M d, Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Status Updates Timeline -->
                @if ($updates->count() > 0)
                    <div class="bg-white rounded-xl border border-blue-200/50 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Status Updates</h2>
                        <div class="space-y-4">
                            @foreach ($updates as $update)
                                <div class="flex gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 rounded-full 
                                            @if($update->status === 'in_progress')
                                                bg-orange-100 border-2 border-orange-500
                                            @elseif($update->status === 'on_the_way')
                                                bg-purple-100 border-2 border-purple-500
                                            @elseif($update->status === 'resolved')
                                                bg-green-100 border-2 border-green-500
                                            @endif
                                            flex items-center justify-center">
                                            <svg class="w-5 h-5 
                                                @if($update->status === 'in_progress')
                                                    text-orange-600
                                                @elseif($update->status === 'on_the_way')
                                                    text-purple-600
                                                @elseif($update->status === 'resolved')
                                                    text-green-600
                                                @endif
                                            " fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 pb-8">
                                        <p class="font-semibold text-gray-900">
                                            @if($update->status === 'in_progress')
                                                Started Response
                                            @elseif($update->status === 'on_the_way')
                                                On The Way
                                            @elseif($update->status === 'resolved')
                                                Resolved
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-600">{{ $update->created_at->format('M d, Y H:i') }}</p>
                                        @if ($update->message)
                                            <p class="mt-2 text-gray-700 bg-gray-50 rounded-lg p-3">{{ $update->message }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-span-3 lg:col-span-1">
                <!-- Action Buttons -->
                @if ($urgentRequest->status !== 'resolved' && in_array($urgentRequest->status, ['submitted', 'assigned']))
                    <div class="bg-white rounded-xl border border-blue-200/50 p-6">
                        <form method="POST" action="{{ route('urgent-requests.cancel', $urgentRequest->id) }}" onsubmit="return confirm('Are you sure you want to cancel this request?');">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-700 font-medium rounded-lg hover:bg-red-200 transition">
                                Cancel Request
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Quick Info -->
                <div class="bg-white rounded-xl border border-blue-200/50 p-6 space-y-4">
                    <div>
                        <span class="text-xs font-medium text-gray-600 uppercase">Request ID</span>
                        <p class="text-lg font-mono font-bold text-gray-900">#{{ $urgentRequest->id }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-gray-600 uppercase">Category</span>
                        <p class="text-sm font-semibold text-gray-900">{{ ucfirst($urgentRequest->category) }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-gray-600 uppercase">Current Status</span>
                        <p class="mt-1 inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $urgentRequest->getStatusColor() }}">
                            {{ ucfirst(str_replace('_', ' ', $urgentRequest->status)) }}
                        </p>
                    </div>
                    @if ($urgentRequest->resolved_at)
                        <div>
                            <span class="text-xs font-medium text-gray-600 uppercase">Resolved On</span>
                            <p class="text-sm text-gray-900">{{ $urgentRequest->resolved_at->format('M d, Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
