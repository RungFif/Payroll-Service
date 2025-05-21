<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payroll Portal</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        body {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            font-family: 'Figtree', ui-sans-serif, system-ui, sans-serif;
        }
        .payroll-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 4px 24px 0 rgba(37, 99, 235, 0.08);
            padding: 2.5rem 2rem;
            max-width: 420px;
            margin: 0 auto;
        }
        .payroll-btn {
            display: inline-block;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            transition: background 0.2s, color 0.2s;
            box-shadow: 0 1px 2px 0 rgba(0,0,0,0.04);
        }
        .payroll-btn-blue {
            background: linear-gradient(to right, #2563eb, #6366f1);
            color: #fff;
        }
        .payroll-btn-blue:hover {
            background: linear-gradient(to right, #1e40af, #4f46e5);
        }
        .payroll-btn-indigo {
            background: #fff;
            color: #3730a3;
            border: 1px solid #6366f1;
        }
        .payroll-btn-indigo:hover {
            background: #f3f4f6;
            color: #3730a3;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex flex-col justify-center items-center py-12">
        <div class="payroll-card text-center">
            <svg class="mx-auto mb-4 h-12 w-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h1 class="text-3xl font-bold text-blue-700 mb-2">Welcome to Payroll Portal</h1>
            <p class="text-gray-600 mb-8">Manage your payroll and employee requests with ease.</p>
            @if (Route::has('login'))
                <div class="mb-6">
                    @auth
                        <a href="{{ url('/home') }}" class="payroll-btn payroll-btn-blue mr-2">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="payroll-btn payroll-btn-blue mr-2">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="payroll-btn payroll-btn-indigo">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('employee-requests.index') }}" class="payroll-btn payroll-btn-blue">Employee Requests</a>
                <a href="{{ route('payrolls.index') }}" class="payroll-btn payroll-btn-indigo">Payrolls</a>
            </div>
        </div>
        <footer class="mt-8 text-gray-400 text-xs">
            &copy; {{ date('Y') }} Payroll Portal. All rights reserved.
        </footer>
    </div>
</body>
</html>
