@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header Section -->
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-700">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Employee Requests Management</h1>
                        <p class="mt-1 text-blue-100">Review and manage all employee requests</p>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div
                    class="mx-6 mt-6 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-700 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Action Bar -->
            <div
                class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                @if (auth()->user()->hasRole('user'))
                    <a href="{{ route('employee-requests.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Request
                    </a>
                @endif

                <div class="flex flex-col sm:flex-row sm:items-center gap-4 w-full sm:w-auto">
                    <form id="filter-form" method="GET" action="{{ route('employee-requests.index') }}"
                        class="flex flex-col sm:flex-row sm:items-center gap-4 w-full sm:w-auto">
                        <input type="text" name="search" placeholder="Search requests..."
                            value="{{ request('search') }}"
                            class="w-full sm:w-56 pl-3 pr-8 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                        <div class="relative w-full sm:w-48">
                            <select id="filter-status" name="status"
                                class="w-full pl-3 pr-8 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>All
                                    Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                    Approved
                                </option>
                                <option value="denied" {{ request('status') == 'denied' ? 'selected' : '' }}>Denied
                                </option>
                            </select>
                        </div>
                        <div class="relative w-full sm:w-48">
                            <select id="filter-type" name="type"
                                class="w-full pl-3 pr-8 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="all" {{ request('type', 'all') == 'all' ? 'selected' : '' }}>All
                                    Types</option>
                                <option value="leave" {{ request('type') == 'leave' ? 'selected' : '' }}>Leave
                                </option>
                                <option value="overtime" {{ request('type') == 'overtime' ? 'selected' : '' }}>Overtime
                                </option>
                                <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Other
                                </option>
                            </select>
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                            Filter
                        </button>
                        <a href="{{ route('employee-requests.export', request()->except('download')) }}"
                            class="inline-flex items-center px-4 py-2 border border-blue-600 text-sm font-medium rounded-md shadow-sm text-blue-700 bg-white hover:bg-blue-50 focus:outline-none">
                            Export
                        </a>
                        <a href="{{ route('payrolls.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Payrolls
                        </a>
                    </form>
                </div>
            </div>

            <!-- Requests Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Request ID
                            </th>
                            @if (auth()->user()->hasRole('admin'))
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Employee
                                </th>
                            @endif
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($requests as $request)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $request->id }}
                                </td>

                                @if (auth()->user()->hasRole('admin'))
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-gray-900">{{ $request->user->name }}</p>
                                                <p class="text-gray-500 text-xs">{{ $request->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                @endif

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">
                                    {{ $request->type }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs">
                                    <div class="line-clamp-2">{{ $request->description }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span @class([
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        'bg-green-100 text-green-800' => $request->status === 'approved',
                                        'bg-yellow-100 text-yellow-800' => $request->status === 'pending',
                                        'bg-red-100 text-red-800' => $request->status === 'denied',
                                    ])>
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('employee-requests.show', $request) }}"
                                            class="text-blue-600 hover:text-blue-900 flex items-center">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View
                                        </a>

                                        @if (auth()->user()->hasRole('user') && $request->user_id == auth()->id())
                                            <a href="{{ route('employee-requests.edit', $request) }}"
                                                class="text-yellow-600 hover:text-yellow-800 flex items-center">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('employee-requests.destroy', $request) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800 flex items-center"
                                                    onclick="return confirm('Are you sure you want to delete this request?')">
                                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        @endif

                                        @if (auth()->user()->hasRole('admin'))
                                            <form action="{{ route('employee-requests.update', $request) }}"
                                                method="POST" class="flex items-center">
                                                @csrf
                                                @method('PUT')
                                                <select name="status"
                                                    class="mr-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                    onchange="this.form.submit()">
                                                    <option value="pending" @selected($request->status == 'pending')>Pending</option>
                                                    <option value="approved" @selected($request->status == 'approved')>Approved</option>
                                                    <option value="denied" @selected($request->status == 'denied')>Denied</option>
                                                </select>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr x-data="{ open: false }">
                                <td colspan="6" class="bg-gray-50 px-8 py-3">
                                    <button type="button"
                                        class="text-blue-600 hover:underline text-xs mb-2"
                                        @click="open = !open">
                                        <span x-show="!open">Show Comments</span>
                                        <span x-show="open">Hide Comments</span>
                                    </button>
                                    <div x-show="open" x-transition>
                                        <div class="font-semibold text-gray-700 mb-1">
                                            Comments for Request #{{ $request->id }}
                                        </div>
                                        <div class="space-y-2 mb-2">
                                            @forelse($request->comments->take(3) as $comment)
                                                @php
                                                    $isAdmin = $comment->user && $comment->user->hasRole('admin');
                                                    $user = auth()->user();
                                                @endphp
                                                <div class="{{ $isAdmin ? 'bg-yellow-50 border-yellow-400' : 'bg-white' }} rounded p-2 border flex items-start">
                                                    @if($isAdmin)
                                                        <svg class="h-4 w-4 text-yellow-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 2a2 2 0 012 2v1.586l.707.707A2 2 0 0114 7v2.586l.707.707A2 2 0 0116 12v2a2 2 0 01-2 2h-1v1a2 2 0 01-2 2 2 2 0 01-2-2v-1H6a2 2 0 01-2-2v-2a2 2 0 01.293-1.293L5 9.586V7a2 2 0 01.293-1.293L6 4.586V4a2 2 0 012-2h2z"/>
                                                        </svg>
                                                    @endif
                                                    <div class="flex-1">
                                                        <div class="flex items-center mb-1">
                                                            <span class="font-semibold text-xs {{ $isAdmin ? 'text-yellow-700' : '' }}">
                                                                {{ $comment->user->name }}
                                                                @if($isAdmin)
                                                                    <span class="ml-1 text-[10px] font-bold uppercase">(Admin)</span>
                                                                @endif
                                                            </span>
                                                            <span class="ml-2 text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <div class="text-gray-700 text-xs">{{ $comment->body }}</div>
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
                                                <div class="text-gray-400 text-xs">No comments yet.</div>
                                            @endforelse
                                        </div>
                                        <form action="{{ route('comments.store') }}" method="POST" class="flex space-x-2">
                                            @csrf
                                            <input type="hidden" name="commentable_type" value="App\Models\EmployeeRequest">
                                            <input type="hidden" name="commentable_id" value="{{ $request->id }}">
                                            <input type="text" name="body" class="flex-1 border rounded px-2 py-1 text-xs"
                                                placeholder="Add a comment..." required>
                                            <button type="submit"
                                                class="px-3 py-1 bg-blue-600 text-white rounded text-xs">Post</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($requests->isEmpty())
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">
                        @if (auth()->user()->hasRole('admin'))
                            No employee requests found
                        @else
                            You haven't submitted any requests yet
                        @endif
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if (auth()->user()->hasRole('user'))
                            Get started by creating a new request
                        @endif
                    </p>
                    @if (auth()->user()->hasRole('user'))
                        <div class="mt-6">
                            <a href="{{ route('employee-requests.create') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                New Request
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        // Submit filter form on change
        document.getElementById('filter-status')?.addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
        document.getElementById('filter-type')?.addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
    </script>
@endsection
