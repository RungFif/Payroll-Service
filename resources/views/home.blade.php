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
        <div class="text-center mt-5">
            <h1>Welcome to Payroll Service</h1>
            <p class="lead">Manage your employee payroll efficiently and securely.</p>
            <a href="#" class="btn btn-primary mt-3">Get Started</a>
        </div>
    </div>
</body>
</html>