<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Check Status - Refund System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>
<body>
  <header class="p-3 bg-primary text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-between">
        <a href="{{ url('/') }}" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none h4">
          <i class="bi bi-cash-coin me-2"></i> Refund Portal
        </a>
      </div>
    </div>
  </header>

  <main class="container mt-5">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Check Status</li>
      </ol>
    </nav>

    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm mb-5">
      <div class="card-header">
        <h3 class="h5 mb-0">Check Your Refund Application Status</h3>
      </div>
      <div class="card-body">
        <form action="{{ route('check-status.submit') }}" method="POST" class="row g-3">
          @csrf

          <div class="col-md-6">
            <label for="tracking_id" class="form-label">Tracking ID</label>
            <input type="text" name="tracking_id" id="tracking_id" class="form-control" placeholder="e.g., AAA1AA1A1" required>
          </div>

          <div class="col-md-6">
            <label for="matric_number" class="form-label">Matric Number</label>
            <input type="text" name="matric_number" id="matric_number" class="form-control" placeholder="e.g., 739610" required>
          </div>

          <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary">Check Status</button>
          </div>
        </form>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
