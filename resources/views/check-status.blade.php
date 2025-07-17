<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Check Refund Status - NELFUND Portal</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>
<body>

  <header class="p-3 bg-primary text-white">
    <div class="container d-flex justify-content-between align-items-center">
      <h4 class="mb-0"><i class="bi bi-search me-2"></i>Check Refund Status</h4>
      <a href="{{ url('/') }}" class="btn btn-light btn-sm">Go to Home</a>
    </div>
  </header>

  <main class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Track Your Refund Application</h5>
          </div>
          <div class="card-body">

            @if(session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('check-status.submit') }}" method="POST">
              @csrf

              <div class="mb-3">
                <label for="tracking_id" class="form-label">Tracking ID <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="tracking_id" name="tracking_id" placeholder="e.g., TRK-1234XYZ" value="{{ old('tracking_id') }}" required>
              </div>

              <div class="mb-3">
                <label for="matric_number" class="form-label">Matric Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="matric_number" name="matric_number" placeholder="e.g., 339910" value="{{ old('matric_number') }}" required>
              </div>

              <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-arrow-right-circle me-1"></i> Check Status
              </button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
