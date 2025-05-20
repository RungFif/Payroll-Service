@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Add Payroll</h1>
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('payrolls.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf
        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700">User</label>
            <select name="user_id" id="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                <option value="">Select User</option>
                @foreach($users as $user)
                    @if(!$user->hasRole('admin'))
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div>
            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
            <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
        </div>
        <div>
            <label for="period" class="block text-sm font-medium text-gray-700">Period</label>
            <input type="text" name="period" id="period" value="{{ old('period') }}" placeholder="e.g. May 2025" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
        </div>
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
            </select>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('payrolls.index') }}" class="mr-2 inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">Cancel</a>
            <button type="submit" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Save</button>
        </div>
    </form>
</div>
@endsection
