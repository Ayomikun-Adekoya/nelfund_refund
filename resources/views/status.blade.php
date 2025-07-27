<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Application Status - NELFUND Refund</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>
<body>
  <header class="p-3 bg-primary text-white">
    <div class="container">
      <h3><i class="bi bi-cash-coin me-2"></i> Refund Status</h3>
    </div>
  </header>

  <main class="container mt-5">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Status</li>
      </ol>
    </nav>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Refund Application Summary</h4>
      </div>
      <div class="card-body">
        <h5 class="mb-3">Student Information</h5>
        <ul class="list-group mb-4">
          <li class="list-group-item"><strong>Full Name:</strong> {{ $student->full_name }}</li>
          <li class="list-group-item"><strong>Matric Number:</strong> {{ $student->matric_number }}</li>
          <li class="list-group-item"><strong>Department:</strong> {{ $student->department }}</li>
          <li class="list-group-item"><strong>Level:</strong> {{ $student->level }}</li>
          <li class="list-group-item"><strong>Faculty:</strong> {{ $student->faculty }}</li>

          <li class="list-group-item">
            <div class="row">
              <div class="col-md-4"><strong>Nelfund Loan Amount:</strong> ₦{{ number_format($student->loanamount) }}</div>
              <div class="col-md-4"><strong>School Levies:</strong> ₦{{ number_format($student->levies) }}</div>
              <div class="col-md-4"><strong>Amount Paid Before Disbursement:</strong> ₦{{ number_format($student->amountpaid) }}</div>
            </div>
          </li>
        </ul>

        <h5 class="mb-3">Application Details</h5>
        @if ($application)
          <ul class="list-group">
            <li class="list-group-item"><strong>Tracking ID:</strong> {{ $application->tracking_id }}</li>
            <li class="list-group-item"><strong>Account Name:</strong> {{ $application->account_name }}</li>
            <li class="list-group-item"><strong>Account Number:</strong> {{ $application->account_number }}</li>
            <li class="list-group-item"><strong>Bank:</strong> {{ $application->bank_name }}</li>
            <li class="list-group-item"><strong>Submitted On:</strong> {{ $application->created_at->format('d M Y, h:i A') }}</li>

            <li class="list-group-item"><strong>Refund Amount:</strong> ₦{{ number_format($student->refund_amount, 2) }}</li>

<li class="list-group-item d-flex align-items-center">
  <strong class="me-2">Status:</strong>

  @switch($application->status)
    @case('approved')
      <span class="badge bg-success">Approved</span>
      <small class="text-muted ms-2">Application approved, awaiting disbursement.</small>
      @break

    @case('declined')
      <span class="badge bg-danger">Declined</span>
      <small class="text-muted ms-2">Application rejected by admin.</small>
      @break

    @case('disbursed')
      <span class="badge bg-info text-white">Disbursed</span>
      <small class="text-muted ms-2">Refund has been sent to your account.</small>
      @break

    @default
      <span class="badge bg-warning text-dark">Submitted</span>
      <small class="text-muted ms-2">Awaiting review from the admin.</small>
  @endswitch
</li>



            <li class="list-group-item">
              <strong>Proof of Payment:</strong>
              <a href="{{ asset('storage/' . $application->proof_file) }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                View File
              </a>
            </li>
          </ul>
        @else
          <div class="alert alert-info">No refund application found.</div>
        @endif
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
