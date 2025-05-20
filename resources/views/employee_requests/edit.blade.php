@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Form Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-700">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <h1 class="text-2xl font-bold text-white">Edit Employee Request</h1>
                </div>
                <p class="mt-1 text-white">Update your request details below</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mx-6 mt-6 px-4 py-3 rounded-lg bg-red-50 border border-red-200 text-red-700 flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h3 class="font-medium">There were {{ $errors->count() }} errors with your submission</h3>
                        <ul class="mt-1 list-disc pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Form Content -->
            <form action="{{ route('employee-requests.update', $request) }}" method="POST" class="px-6 py-4 space-y-6">
                @csrf
                @method('PUT')

                <!-- Request Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Request Type</label>
                    <div class="relative">
                        <select name="type" id="type"
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md shadow-sm">
                            <option value="leave" {{ old('type', $request->type) == 'leave' ? 'selected' : '' }}>Leave
                                Request</option>
                            <option value="overtime" {{ old('type', $request->type) == 'overtime' ? 'selected' : '' }}>
                                Overtime Request</option>
                            <option value="other" {{ old('type', $request->type) == 'other' ? 'selected' : '' }}>Other
                                Request</option>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <div class="mt-1">
                        <textarea name="description" id="description" rows="4"
                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('description', $request->description) }}</textarea>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Provide detailed information about your request</p>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-black">
                    <a href="{{ route('employee-requests.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-black shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-black text-sm font-medium rounded-md shadow-sm text-black bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        Update Request
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
