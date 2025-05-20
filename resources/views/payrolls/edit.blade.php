@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center mb-6">
                <svg class="h-6 w-6 text-gray-700 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <h1 class="text-2xl font-bold text-gray-800">Edit Payroll</h1>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <h3 class="font-medium">There were {{ $errors->count() }} errors with your submission</h3>
                    </div>
                    <ul class="mt-2 pl-5 list-disc text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <form action="{{ route('payrolls.update', $payroll) }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    <!-- User Field -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <select name="user_id" id="user_id"
                                class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                required>
                                @foreach($users as $user)
                                    @if(!$user->hasRole('admin'))
                                        <option value="{{ $user->id }}" @selected(old('user_id', $payroll->user_id) == $user->id)>{{ $user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Amount Field -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" step="0.01" name="amount" id="amount"
                                value="{{ old('amount', $payroll->amount) }}"
                                class="block w-full pl-8 pr-12 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>
                    </div>

                    <!-- Period Field -->
                    <div>
                        <label for="period" class="block text-sm font-medium text-gray-700 mb-1">Pay Period</label>
                        <div class="mt-1">
                            <input type="text" name="period" id="period"
                                value="{{ old('period', $payroll->period) }}"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>
                    </div>

                    <!-- Status Field -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <div class="mt-1">
                            <select name="status" id="status"
                                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md">
                                <option value="pending" @selected(old('status', $payroll->status) == 'pending')>Pending</option>
                                <option value="paid" @selected(old('status', $payroll->status) == 'paid')>Paid</option>
                                <option value="denied" @selected(old('status', $payroll->status) == 'denied')>Denied</option>
                            </select>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('payrolls.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Update Payroll
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
