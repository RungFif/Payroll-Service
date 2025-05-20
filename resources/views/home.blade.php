<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payroll Service - Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    @php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
        if ($user) {
            if ($user->hasRole('admin')) {
                header('Location: ' . route('payrolls.index'));
                exit;
            } elseif ($user->hasRole('user')) {
                header('Location: ' . route('employee-requests.index'));
                exit;
            }
        }
    @endphp
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Payroll Service</a>
            <div class="d-flex">
                @if(Auth::check())
                    <span class="navbar-text me-3">Hello, {{ Auth::user()->name }}</span>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-light btn-sm me-2">Profile</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-light btn-sm" type="submit">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light btn-sm">Login</a>
                @endif
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="max-w-2xl mx-auto py-12">
            <div class="bg-white rounded-xl shadow-md p-8 text-center">
                <h1 class="text-3xl font-bold mb-4 text-blue-700">Welcome to Payroll Portal</h1>
                <p class="mb-8 text-gray-600">Choose where you want to go:</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('employee-requests.index') }}"
                       class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold shadow hover:bg-blue-700 transition">
                        View Employee Requests
                    </a>
                    <a href="{{ route('payrolls.index') }}"
                       class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold shadow hover:bg-indigo-700 transition">
                        View Payrolls
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>