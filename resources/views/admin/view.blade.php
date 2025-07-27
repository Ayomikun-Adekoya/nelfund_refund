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

@include('admin.partials.navbar')

<body>
<div class="container mt-5">
  <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary mb-4">
    <i class="bi bi-arrow-left"></i> Back to Dashboard
  </a>

  <h4 class="text-primary mb-4">Student Application Details</h4>

  <ul class="list-group mb-4">
    <li class="list-group-item"><strong>Full Name:</strong> {{ $application->student->full_name }}</li>
    <li class="list-group-item"><strong>Matric Number:</strong> {{ $application->student->matric_number }}</li>
    <li class="list-group-item"><strong>Department:</strong> {{ $application->student->department }}</li>
    <li class="list-group-item"><strong>Level:</strong> {{ $application->student->level }}</li>
    <li class="list-group-item"><strong>Faculty:</strong> {{ $application->student->faculty }}</li>

    {{-- Grouped Row for Financial Fields --}}
    <li class="list-group-item">
      <div class="row">
        <div class="col-md-4"><strong>NELFUND Loan:</strong> ₦{{ number_format($application->student->loanamount) }}</div>
        <div class="col-md-4"><strong>School Levies:</strong> ₦{{ number_format($application->student->levies) }}</div>
        <div class="col-md-4"><strong>Amount Paid:</strong> ₦{{ number_format($application->student->amountpaid) }}</div>
      </div>
    </li>
  </ul>

  <h5 class="mb-3">Application Details</h5>
  <ul class="list-group mb-4">
    <li class="list-group-item"><strong>Tracking ID:</strong> {{ $application->tracking_id }}</li>
    <li class="list-group-item"><strong>Account Name:</strong> {{ $application->account_name }}</li>
    <li class="list-group-item"><strong>Account Number:</strong> {{ $application->account_number }}</li>
    <li class="list-group-item"><strong>Bank:</strong> {{ $application->bank_name }}</li>
    <li class="list-group-item"><strong>Status:</strong>
      @switch($application->status)
        @case('approved')
          <span class="badge bg-success">Approved</span>
          @break
        @case('declined')
          <span class="badge bg-danger">Declined</span>
          @break
        @case('disbursed')
          <span class="badge bg-info text-white">Disbursed</span>
          @break
        @default
          <span class="badge bg-warning text-dark">Submitted</span>
      @endswitch
    </li>
    <li class="list-group-item"><strong>Submitted On:</strong> {{ $application->created_at->format('d M Y, h:i A') }}</li>
  </ul>

  {{-- Action Buttons --}}
  @php $role = session('admin_role'); @endphp

  @if($application->status === 'submitted' && $role === 'approver')
    <form action="{{ route('admin.update', $application->id) }}" method="POST" class="d-flex gap-3">
      @csrf
      @method('PATCH')
      <button type="submit" name="action" value="approve" class="btn btn-success">
        <i class="bi bi-check-circle-fill me-1"></i> Approve
      </button>
      <button type="submit" name="action" value="decline" class="btn btn-danger">
        <i class="bi bi-x-circle-fill me-1"></i> Decline
      </button>
    </form>

  @elseif($application->status === 'approved' && $role === 'disburser')
    <form action="{{ route('admin.mark.disbursed', $application->id) }}" method="POST" class="mt-3">
      @csrf
      @method('PATCH')
      <button class="btn btn-info" onclick="return confirm('Mark this application as disbursed?')">
        <i class="bi bi-cash-coin me-1"></i> Mark as Disbursed
      </button>
    </form>
  @endif
</div>
</body>
</html>
