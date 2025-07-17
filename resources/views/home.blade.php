<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NELFUND LOAN Refund Portal - Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
  </head>
  <body>
    <header class="p-3 bg-primary text-white">
      <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
          <a href="{{ url('/') }}" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none h4">
            <i class="bi bi-cash-coin me-2"></i> NELFUND LOAN Refund
          </a>

          <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0"></ul>

          <div class="text-end">
            <a href="{{ url('/admin') }}" class="btn btn-outline-light me-2">Admin Login</a>
          </div>
        </div>
      </div>
    </header>

    <main class="container mt-5">
      <div class="bg-light p-5 rounded text-center shadow-sm">
        <h1 class="display-4">Welcome to the NELFUND LOAN Refund Portal</h1>
        <p class="lead text-muted"></p>
        <hr class="my-4" />
        <div class="row g-3 justify-content-center">
          <div class="col-md-5">
            <div class="card h-100">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title">New Refund Request</h5>
                <p class="card-text">
                  Start a new application to request a refund. The process is simple and quick.
                </p>
                <a href="{{ route('refund.apply.form') }}" class="btn btn-primary mt-auto">
                  <i class="bi bi-pencil-square me-2"></i>Request for Refund
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="card h-100">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title">Check Refund Status</h5>
                <p class="card-text">
                  Already applied? Check the status of your existing refund application here.
                </p>
                <a href="{{ route('check-status.submit') }}" class="btn btn-secondary mt-auto">
                  <i class="bi bi-search me-2"></i>Check Refund Status
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
        </form>
      </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
  </body>
</html>
