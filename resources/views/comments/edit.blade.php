@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto py-8">
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-lg font-semibold mb-4">Edit Comment</h2>
        <form action="{{ route('comments.update', $comment) }}" method="POST">
            @csrf
            @method('PUT')
            <textarea name="body" rows="4" class="w-full border rounded p-2" required>{{ old('body', $comment->body) }}</textarea>
            <div class="flex justify-end mt-4 space-x-2">
                <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-200 rounded">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
