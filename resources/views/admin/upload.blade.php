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

@include('admin.partials.navbar')

<div class="container mt-5">
  <h4 class="text-primary mb-3"><i class="bi bi-upload me-2"></i>Upload Eligible Students</h4>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- ✅ Upload Instructions --}}
  <div class="alert alert-info">
    <strong>Instructions:</strong>
    <p class="mb-1">
      Please upload a <code>.csv</code> or <code>.xlsx</code> file with the following column headers:
    </p>
    <ul class="mb-2">
      <li><code>matric_number</code></li>
      <li><code>full_name</code></li>
      <li><code>department</code></li>
      <li><code>level</code></li>
      <li><code>faculty</code></li>
      <li><code>loanamount</code></li>
      <li><code>levies</code></li>
      <li><code>amountpaid</code></li>
      <li><code>paymentmode</code></li>
    </ul>
    <small>
      You can 
      <a href="{{ route('admin.upload.sample') }}" class="fw-bold text-decoration-underline">download a sample Excel template</a> 
      for formatting guidance.
    </small>
  </div>

  {{-- ✅ Upload Form --}}
  <form action="{{ route('admin.upload.students.submit') }}" method="POST" enctype="multipart/form-data">
    
    @csrf
    <div class="mb-3">
      <label for="student_file" class="form-label">Select File (.csv or .xlsx)</label>
      <input type="file" class="form-control" id="student_file" name="student_file" accept=".csv,.xlsx" required>
    </div>
    <button type="submit" class="btn btn-primary">
      <i class="bi bi-cloud-upload me-1"></i> Upload
    </button>
  </form>
</div>

</body>
</html>
