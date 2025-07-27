<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Apply for Refund - Refund Portal</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <style>
    /* Fix select2 overlap in scrollable areas */
    .select2-container {
      z-index: 9999;
    }
  </style>
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
        <!-- Step 1: Verify Tracking -->
        <form method="POST" action="{{ route('refund.apply.verify') }}">
          @csrf
          <div class="mb-3">
            <label for="matric_number" class="form-label">Matric Number</label>
            <input type="text" class="form-control" name="matric_number" id="matric_number" placeholder="e.g. 123456" required>
          </div>

          <div class="mb-3">
            <label for="tracking_id" class="form-label">Tracking ID</label>
            <input type="text" class="form-control" name="tracking_id" id="tracking_id" placeholder="e.g. REF-1234XYZ" required>
          </div>

          <button type="submit" class="btn btn-primary">Check Eligibility</button>
        </form>

      @else
        <!-- Step 2: Refund Application -->
        <h6 class="mb-3">Welcome {{ $student->full_name }} ({{ $student->matric_number }})</h6>

        <form method="POST" action="{{ route('refund.submit', $student->id) }}" enctype="multipart/form-data">
          @csrf

          <div class="mb-3">
            <label class="form-label">Eligible Refund Amount</label>
            <input type="text" class="form-control" value="₦{{ number_format($student->refund_amount, 2) }}" readonly>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Nelfund Loan Amount</label>
              <input type="text" class="form-control" value="₦{{ number_format($student->loanamount, 2) }}" readonly>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">School Levies</label>
              <input type="text" class="form-control" value="₦{{ number_format($student->levies, 2) }}" readonly>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Amount Paid Before Loan Disbursement</label>
              <input type="text" class="form-control" value="₦{{ number_format($student->amountpaid, 2) }}" readonly>
            </div>
          </div>

          <div class="mb-3">
            <label for="account_name" class="form-label">Account Name</label>
            <input type="text" class="form-control" name="account_name" id="account_name" required>
          </div>

          <div class="mb-3">
            <label for="bank_name" class="form-label">Bank Name</label>
            <select class="form-select" name="bank_name" id="bank_name" required>
              <option value="">-- Select a Bank --</option>
              <option value="Access Bank Plc">Access Bank Plc</option>
              <option value="Alpha Morgan Bank">Alpha Morgan Bank</option>
              <option value="Citibank Nigeria Ltd">Citibank Nigeria Ltd</option>
              <option value="Ecobank Nigeria Plc">Ecobank Nigeria Plc</option>
              <option value="Fidelity Bank Plc">Fidelity Bank Plc</option>
              <option value="First Bank Nigeria Ltd">First Bank Nigeria Ltd</option>
              <option value="First City Monument Bank Plc">First City Monument Bank Plc</option>
              <option value="Globus Bank Ltd">Globus Bank Ltd</option>
              <option value="Guaranty Trust Bank Plc">Guaranty Trust Bank Plc</option>
              <option value="Keystone Bank Ltd">Keystone Bank Ltd</option>
              <option value="Nova Commercial Bank Ltd">Nova Commercial Bank Ltd</option>
              <option value="Optimus Bank">Optimus Bank</option>
              <option value="Parallex Bank Ltd">Parallex Bank Ltd</option>
              <option value="Polaris Bank Plc">Polaris Bank Plc</option>
              <option value="Premium Trust Bank">Premium Trust Bank</option>
              <option value="Providus Bank Ltd">Providus Bank Ltd</option>
              <option value="Signature Bank Ltd">Signature Bank Ltd</option>
              <option value="Stanbic IBTC Bank Plc">Stanbic IBTC Bank Plc</option>
              <option value="Standard Chartered Bank Nigeria Ltd">Standard Chartered Bank Nigeria Ltd</option>
              <option value="Sterling Bank Plc">Sterling Bank Plc</option>
              <option value="SunTrust Bank Nigeria Ltd">SunTrust Bank Nigeria Ltd</option>
              <option value="Titan Trust Bank Ltd">Titan Trust Bank Ltd</option>
              <option value="Union Bank of Nigeria Plc">Union Bank of Nigeria Plc</option>
              <option value="United Bank For Africa Plc">United Bank For Africa Plc</option>
              <option value="Unity Bank Plc">Unity Bank Plc</option>
              <option value="Wema Bank Plc">Wema Bank Plc</option>
              <option value="Zenith Bank Plc">Zenith Bank Plc</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="account_number" class="form-label">Account Number</label>
            <input type="text" class="form-control" name="account_number" id="account_number" required>
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

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function () {
$('#bank_name').select2({
  dropdownParent: $('.card-body'),
  placeholder: "-- Select a Bank --",
  width: '100%',
  minimumResultsForSearch: Infinity  // 🔥 disables search bar
});

  });
</script>
</body>
</html>
