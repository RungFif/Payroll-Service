@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-12">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 px-6 py-4">
                <h1 class="text-lg font-semibold text-white">Create Employee Request</h1>
            </div>

            <div class="p-6 space-y-6">
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-md">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('employee-requests.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-black">Type</label>
                        <select name="type" id="type"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm 
                         focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-black">
                            <option value="">— Select Type —</option>
                            <option value="leave" {{ old('type') == 'leave' ? 'selected' : '' }}>Leave</option>
                            <option value="overtime" {{ old('type') == 'overtime' ? 'selected' : '' }}>Overtime</option>
                            <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-black">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm 
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-black"
                            placeholder="Tell us more…">{{ old('description') }}</textarea>
                    </div>

                    <!-- Actions -->
                    <div class="pt-4 flex justify-end space-x-3">
                        <a href="{{ route('employee-requests.index') }}"
                            class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium 
                    px-5 py-2 rounded-md transition">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium 
                         px-6 py-2 rounded-md shadow transition">
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
