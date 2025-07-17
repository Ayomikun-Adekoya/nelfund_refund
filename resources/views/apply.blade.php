<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Apply for Refund - Refund Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>
<body>

<header class="p-3 bg-primary text-white">
  <div class="container">
    <a href="{{ url('/') }}" class="text-white text-decoration-none h4">
      <i class="bi bi-cash-coin me-2"></i> Refund Portal
    </a>
  </div>
</header>

<main class="container mt-5">

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Request for Refund</li>
    </ol>
  </nav>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Refund Request</h5>
    </div>
    <div class="card-body">

      @if (!isset($student))
        {{-- Step 1: Enter Tracking ID --}}
        {{-- Step 1: Enter Tracking ID and Matric Number --}}
<form method="POST" action="{{ route('refund.apply.verify') }}">
  @csrf
  <div class="mb-3">
    <label for="tracking_id" class="form-label">Tracking ID</label>
    <input type="text" class="form-control" name="tracking_id" id="tracking_id" placeholder="e.g. REF-1234XYZ" required>
  </div>

  <div class="mb-3">
    <label for="matric_number" class="form-label">Matric Number</label>
    <input type="text" class="form-control" name="matric_number" id="matric_number" placeholder="e.g. 123456" required>
  </div>

  <button type="submit" class="btn btn-primary">Check Eligibility</button>
</form>

      @else
        {{-- Step 2: Refund Application Form --}}
        <h6 class="mb-3">Welcome {{ $student->full_name }} ({{ $student->matric_number }})</h6>

        @php
          $refundAmount = ($student->loanamount - $student->amountpaid) + $student->levies;
        @endphp

        <form method="POST" action="{{ route('refund.submit', $student->id) }}" enctype="multipart/form-data">
          @csrf

          <div class="mb-3">
            <label class="form-label">Eligible Refund Amount</label>
            <input type="text" class="form-control" value="₦{{ number_format($student->refund_amount, 2) }}" readonly>
          </div>
                    <div class="mb-3">
            <label class="form-label">Loan Amount</label>
            <input type="text" class="form-control" value="₦{{ number_format($student->loanamount, 2) }}" readonly>
          </div>
                    <div class="mb-3">
            <label class="form-label">Levies</label>
            <input type="text" class="form-control" value="₦{{ number_format($student->levies, 2) }}" readonly>
          </div>
                    <div class="mb-3">
            <label class="form-label">Amount Paid</label>
            <input type="text" class="form-control" value="₦{{ number_format($student->amountpaid, 2) }}" readonly>
          </div>
          <div class="mb-3">
            <label for="account_name" class="form-label">Account Name</label>
            <input type="text" class="form-control" name="account_name" id="account_name" required>
          </div>

          <div class="mb-3">
            <label for="account_number" class="form-label">Account Number</label>
            <input type="text" class="form-control" name="account_number" id="account_number" required>
          </div>

          <div class="mb-3">
            <label for="bank_name" class="form-label">Bank Name</label>
            <input type="text" class="form-control" name="bank_name" id="bank_name" required>
          </div>

          <div class="mb-3">
            <label for="proof_file" class="form-label">Upload Proof of Payment (PDF, JPG, PNG)</label>
            <input type="file" class="form-control" name="proof_file" id="proof_file" accept=".pdf,.jpg,.jpeg,.png" required>
          </div>

          <button type="submit" class="btn btn-success">Submit Application</button>
        </form>
      @endif

    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
