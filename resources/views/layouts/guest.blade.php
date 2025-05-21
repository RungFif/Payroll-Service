<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PayrollPro') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-800 antialiased bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="min-h-screen flex flex-col justify-center items-center p-4 sm:p-6">
        <!-- Payroll Logo Container -->
        <div class="mb-8 transition-transform hover:scale-105">
            <a href="/" class="flex flex-col items-center">
                <div class="bg-blue-100 p-4 rounded-full">
                    <svg class="w-12 h-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </a>
        </div>

        <!-- Content Card -->
        <div class="w-full sm:max-w-md bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="px-6 py-8 sm:px-8 sm:py-10">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 text-center border-t border-gray-100">
                <p class="text-xs text-gray-500">
                    &copy; {{ date('Y') }} Payroll Service. All rights reserved.
                </p>
            </div>
        </div>

        <!-- Additional Links -->
        <div class="mt-6 text-center text-sm text-gray-500">
            <a href="/" class="font-medium text-blue-600 hover:text-blue-500">
                Return home
            </a>
        </div>
    </div>
</body>

</html>
