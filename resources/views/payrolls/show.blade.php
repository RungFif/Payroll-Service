@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header Section -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center">
                    <svg class="h-4 w-4 text-gray-700 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Payroll Details</h1>
                        <p class="text-sm text-gray-600">Payroll #{{ $payroll->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Details Content -->
            <div class="px-6 py-4 space-y-6">
                <!-- User -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <span class="block text-sm font-medium text-gray-500">Employee</span>
                    </div>
                    <div class="col-span-2">
                        <span class="font-medium text-gray-900">{{ $payroll->user->name ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- Amount -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <span class="block text-sm font-medium text-gray-500">Amount</span>
                    </div>
                    <div class="col-span-2">
                        <span class="font-mono text-gray-900">₱{{ number_format($payroll->amount, 2) }}</span>
                    </div>
                </div>

                <!-- Period -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <span class="block text-sm font-medium text-gray-500">Pay Period</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-gray-900">{{ $payroll->period }}</span>
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
                            'bg-green-100 text-green-800' => $payroll->status === 'paid',
                            'bg-yellow-100 text-yellow-800' => $payroll->status === 'pending',
                            'bg-red-100 text-red-800' => $payroll->status === 'cancelled',
                        ])>
                            {{ ucfirst($payroll->status) }}
                        </span>
                    </div>
                </div>

                <!-- Created At -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <span class="block text-sm font-medium text-gray-500">Created On</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-gray-900">{{ $payroll->created_at->format('M j, Y \a\t g:i a') }}</span>
                    </div>
                </div>

                <!-- Last Updated -->
                @if ($payroll->updated_at != $payroll->created_at)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="col-span-1">
                            <span class="block text-sm font-medium text-gray-500">Last Updated</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-900">{{ $payroll->updated_at->format('M j, Y \a\t g:i a') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('payrolls.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Payrolls
                    </a>
                    @if (auth()->user()->hasRole('admin'))
                        <a href="{{ route('payrolls.edit', $payroll) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Payroll
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="mt-8">
            <h2 class="text-lg font-semibold mb-2">Comments</h2>
            <div class="space-y-4 mb-4">
                @forelse($payroll->comments as $comment)
                    @php
                        $isAdmin = $comment->user && $comment->user->hasRole('admin');
                        $user = auth()->user();
                    @endphp
                    <div class="{{ $isAdmin ? 'bg-yellow-50 border-yellow-400' : 'bg-gray-50' }} rounded p-3 border flex items-start">
                        @if($isAdmin)
                            <svg class="h-4 w-4 text-yellow-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a2 2 0 012 2v1.586l.707.707A2 2 0 0114 7v2.586l.707.707A2 2 0 0116 12v2a2 2 0 01-2 2h-1v1a2 2 0 01-2 2 2 2 0 01-2-2v-1H6a2 2 0 01-2-2v-2a2 2 0 01.293-1.293L5 9.586V7a2 2 0 01.293-1.293L6 4.586V4a2 2 0 012-2h2z"/>
                            </svg>
                        @endif
                        <div class="flex-1">
                            <div class="flex items-center mb-1">
                                <span class="font-semibold text-sm {{ $isAdmin ? 'text-yellow-700' : '' }}">
                                    {{ $comment->user->name }}
                                    @if($isAdmin)
                                        <span class="ml-1 text-[10px] font-bold uppercase">(Admin)</span>
                                    @endif
                                </span>
                                <span class="ml-2 text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-gray-700 text-sm">{{ $comment->body }}</div>
                            <div class="flex items-center mt-1 space-x-2">
                                <form action="{{ route('comments.like', $comment) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800 text-xs flex items-center" {{ $comment->likedBy($user->id) ? 'disabled' : '' }}>
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 9V5a3 3 0 00-6 0v4M5 15h14a2 2 0 002-2v-2a2 2 0 00-2-2H7l-2 8v-6z"/>
                                        </svg>
                                        {{ $comment->likes()->count() }}
                                    </button>
                                </form>
                                <form action="{{ route('comments.dislike', $comment) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs flex items-center" {{ $comment->dislikedBy($user->id) ? 'disabled' : '' }}>
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 15v4a3 3 0 006 0v-4m5-6H7l-2 8v-6a2 2 0 012-2h14a2 2 0 012 2v2a2 2 0 01-2 2z"/>
                                        </svg>
                                        {{ $comment->dislikes()->count() }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-gray-400 text-sm">No comments yet.</div>
                @endforelse
            </div>
            <form action="{{ route('comments.store') }}" method="POST" class="flex space-x-2">
                @csrf
                <input type="hidden" name="commentable_type" value="App\Models\Payroll">
                <input type="hidden" name="commentable_id" value="{{ $payroll->id }}">
                <input type="text" name="body" class="flex-1 border rounded px-3 py-2 text-sm"
                    placeholder="Add a comment..." required>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded text-sm">Post</button>
            </form>
        </div>
    </div>
@endsection
