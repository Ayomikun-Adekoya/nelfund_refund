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
      @if(session('admin_name'))
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

<main class="container mt-5">
  <h3 class="text-center mb-4 text-primary">Submitted Refund Applications</h3>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
      <input type="text" name="search" class="form-control" placeholder="Search name, matric, tracking ID" value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
      <select name="status" class="form-select">
        <option value="">All Statuses</option>
        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
        <option value="declined" {{ request('status') == 'declined' ? 'selected' : '' }}>Declined</option>
      </select>
    </div>
    <div class="col-md-3">
      <input type="date" name="date" class="form-control" value="{{ request('date') }}">
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
    </div>
  </form>

  @if($applications->isEmpty())
    <div class="alert alert-info text-center">No refund applications found.</div>
  @else
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-primary">
          <tr>
            <th>Student</th>
            <th>Tracking ID</th>
            <th>Bank Details</th>
            <th>Proof</th>
            <th>Status</th>
            <th>Refund Amount</th>
            <th>Submitted</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($applications as $application)
            <tr>
              <td>
                <strong>{{ $application->student->full_name }}</strong><br>
                <small>{{ $application->student->matric_number }}</small>
              </td>
              <td>{{ $application->tracking_id }}</td>
              <td>
                {{ $application->account_name }}<br>
                {{ $application->account_number }}<br>
                {{ $application->bank_name }}
              </td>
              <td>
                <a href="{{ asset('storage/' . $application->proof_file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                  View Proof
                </a>
              </td>
              <td>
                @if ($application->status === 'approved')
                  <span class="badge bg-success">Approved</span>
                @elseif ($application->status === 'declined')
                  <span class="badge bg-danger">Declined</span>
                @else
                  <span class="badge bg-warning text-dark">Submitted</span>
                @endif
              </td>
              <td>
                ₦{{ number_format($application->student->refund_amount, 2) }}
              </td>
              <td>{{ $application->created_at->format('d M Y, h:i A') }}</td>
              <td>
                @if ($application->status === 'submitted')
                  <form action="{{ route('admin.update', $application->id) }}" method="POST" class="d-flex gap-1">
                    @csrf
                    @method('PATCH')
                    <button name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                    <button name="action" value="decline" class="btn btn-danger btn-sm">Decline</button>
                  </form>
                @else
                  <small>No further action</small>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
