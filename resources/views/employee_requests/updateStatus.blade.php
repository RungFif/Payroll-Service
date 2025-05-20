@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white rounded-xl shadow-md p-8">
    <h2 class="text-xl font-bold mb-6">Update Request Status</h2>
    <div class="mb-4">
        <p><strong>Request ID:</strong> #{{ $request->id }}</p>
        <p><strong>Employee:</strong> {{ $request->user->name }} ({{ $request->user->email }})</p>
        <p><strong>Type:</strong> {{ ucfirst($request->type) }}</p>
        <p><strong>Description:</strong> {{ $request->description }}</p>
    </div>
    <form action="{{ route('employee-requests.update', $request) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" id="status" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="pending" @selected($request->status == 'pending')>Pending</option>
                <option value="approved" @selected($request->status == 'approved')>Approved</option>
                <option value="denied" @selected($request->status == 'denied')>Denied</option>
            </select>
        </div>
        <div class="flex justify-end space-x-2">
            <a href="{{ route('employee-requests.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Status</button>
        </div>
    </form>
</div>
@endsection