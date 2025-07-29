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

<main class="container mt-5">
  <h3 class="text-center mb-4 text-primary">Submitted Refund Applications</h3>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- Filter Form --}}
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
        <option value="disbursed" {{ request('status') == 'disbursed' ? 'selected' : '' }}>Disbursed</option>
      </select>
    </div>
    <div class="col-md-3">
      <input type="date" name="date" class="form-control" value="{{ request('date') }}">
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
    </div>
  </form>

  {{-- Bulk Action Form --}}
  <form method="POST" action="{{ route('admin.bulk.action') }}" id="bulkForm">
    @csrf
    <input type="hidden" name="action" id="bulkActionType">

    @if($applications->isEmpty())
      <div class="alert alert-info text-center">No refund applications found.</div>
    @else
      <div class="mb-3 d-flex justify-content-end gap-2">
        @if(session('admin_role') === 'approver')
          <button type="button" class="btn btn-success" onclick="submitBulkAction('approve')">
            <i class="bi bi-check-circle"></i> Approve Selected
          </button>
        @endif

        @if(session('admin_role') === 'disburser')
          <button type="button" class="btn btn-info text-white" onclick="submitBulkAction('disburse')">
            <i class="bi bi-cash-coin"></i> Disburse Selected
          </button>
        @endif
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-primary">
            <tr>
              <th><input type="checkbox" id="selectAll"></th>
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
                  @php $role = session('admin_role'); @endphp
                  @if (
                    ($application->status === 'submitted' && $role === 'approver') ||
                    ($application->status === 'approved' && $role === 'disburser')
                  )
                    <input type="checkbox" name="ids[]" value="{{ $application->id }}">
                  @endif
                </td>
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
                </td>
                <td>₦{{ number_format($application->student->refund_amount, 2) }}</td>
                <td>{{ $application->created_at->format('d M Y, h:i A') }}</td>
                <td>
                  <div class="d-grid gap-2">
                    <a href="{{ route('admin.view', $application->id) }}" class="btn btn-outline-primary btn-sm">
                      <i class="bi bi-eye"></i> View
                    </a>

                    @if ($application->status === 'submitted' && $role === 'approver')
                      <form action="{{ route('admin.update', $application->id) }}" method="POST" class="d-flex gap-1">
                        @csrf
                
                        <button name="action" value="approve" class="btn btn-success btn-sm w-100">Approve</button>
                        <button name="action" value="decline" class="btn btn-danger btn-sm w-100">Decline</button>
                      </form>

                    @elseif ($application->status === 'approved' && $role === 'disburser')
                      <form action="{{ route('admin.mark.disbursed', $application->id) }}" method="POST" class="w-100">
                        @csrf
          
                        <button class="btn btn-info btn-sm w-100" onclick="return confirm('Mark as disbursed?')">
                          <i class="bi bi-cash-coin"></i> Disburse
                        </button>
                      </form>
                    @else
                      <small class="text-muted">No further action</small>
                    @endif
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function submitBulkAction(action) {
    const form = document.getElementById('bulkForm');
    const actionField = document.getElementById('bulkActionType');
    actionField.value = action;

    const checked = form.querySelectorAll('input[name="ids[]"]:checked');
    if (checked.length === 0) {
      alert("Please select at least one application.");
      return;
    }

    const confirmMessage = action === 'approve'
      ? "Are you sure you want to approve selected applications?"
      : "Are you sure you want to disburse selected applications?";

    if (confirm(confirmMessage)) {
      form.submit();
    }
  }

  document.getElementById('selectAll')?.addEventListener('change', function () {
    document.querySelectorAll('input[name="ids[]"]').forEach(cb => cb.checked = this.checked);
  });
</script>

</body>
</html>
