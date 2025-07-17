<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - NELFUND Refund</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>

<body>

    <header class="p-3 bg-primary text-white">
        <div class="container d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Admin Dashboard</h4>
            <div class="d-flex align-items-center gap-3">
                @if (session('admin_name'))
                    <span>Welcome, {{ session('admin_name') }}</span>
                    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-light">Logout</button>
                    </form>
                @endif
                <a href="{{ url('/') }}" class="btn btn-sm btn-outline-light">Go to Home</a>
            </div>
        </div>
    </header>

    {{ $slot }}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
