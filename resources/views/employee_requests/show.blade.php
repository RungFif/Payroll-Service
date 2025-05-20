@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header Section -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-gray-700 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Request Details</h1>
                        <p class="text-sm text-gray-600">Viewing request #{{ $request->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Details Content -->
            <div class="px-6 py-4 space-y-6">
                <!-- Request Type -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <span class="block text-sm font-medium text-gray-500">Request Type</span>
                    </div>
                    <div class="col-span-2">
                        <span class="font-medium text-gray-900 capitalize">{{ $request->type }}</span>
                    </div>
                </div>

                <!-- Status -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <span class="block text-sm font-medium text-gray-500">Status</span>
                    </div>
                    <div class="col-span-2">
                        <span @class([
                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                            'bg-green-100 text-green-800' => $request->status === 'approved',
                            'bg-yellow-100 text-yellow-800' => $request->status === 'pending',
                            'bg-red-100 text-red-800' => $request->status === 'denied',
                        ])>
                            {{ ucfirst($request->status) }}
                        </span>
                    </div>
                </div>

                <!-- Description -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <span class="block text-sm font-medium text-gray-500">Description</span>
                    </div>
                    <div class="col-span-2">
                        <div class="prose prose-sm max-w-none text-gray-800">
                            {!! nl2br(e($request->description)) !!}
                        </div>
                    </div>
                </div>

                <!-- Created At -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <span class="block text-sm font-medium text-gray-500">Submitted On</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-gray-900">{{ $request->created_at->format('M j, Y \a\t g:i a') }}</span>
                    </div>
                </div>

                <!-- Last Updated -->
                @if ($request->updated_at != $request->created_at)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="col-span-1">
                            <span class="block text-sm font-medium text-gray-500">Last Updated</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-900">{{ $request->updated_at->format('M j, Y \a\t g:i a') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('employee-requests.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Requests
                    </a>
                    @if (auth()->user()->id == $request->user_id)
                        <a href="{{ route('employee-requests.edit', $request) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Request
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
