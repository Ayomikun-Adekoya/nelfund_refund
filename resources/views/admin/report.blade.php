{{-- resources/views/admin/report.blade.php --}}
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
  <h4 class="text-primary mb-4"><i class="bi bi-bar-chart-fill me-2"></i>Loan Refund Reports</h4>

  {{-- Sort codes --}}
  @php
    $sortCodes = [
      'Access Bank plc' => '044',
      'Alpha Morgan Bank' => '108',
      'Citibank Nigeria Ltd' => '023',
      'Ecobank Nigeria Plc' => '050',
      'Fidelity Bank Plc' => '070',
      'First Bank Nigeria Ltd' => '011',
      'First City Monument Bank Plc' => '214',
      'Globus Bank Ltd' => '103',
      'Guaranty Trust Bank Plc' => '058',
      'Jaiz Bank Plc' => '301',
      'Keystone Bank Ltd' => '082',
      'Lotus Bank' => '303',
      'Nova Commercial Bank Ltd' => '461',
      'Polaris Bank Plc' => '076',
      'Premium Trust Bank' => '105',
      'Providus Bank Ltd' => '101',
      'Signature Bank Ltd' => '106',
      'Stanbic IBTC Bank Plc' => '221',
      'Standard Chartered Bank Nigeria Ltd' => '068',
      'Sterling Bank' => '232',
      'SunTrust Bank Nigeria Ltd' => '100',
      'Taj Bank' => '626',
      'Titan Trust Bank Ltd' => '102',
      'Union Bank of Nigeria Plc' => '032',
      'United Bank for Africa Plc' => '033',
      'Unity Bank Plc' => '215',
      'Wema Bank Plc' => '035',
      'Zenith Bank Plc' => '057',
    ];
  @endphp

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
      <button type="submit" class="btn btn-outline-primary w-100">
        <i class="bi bi-funnel-fill me-1"></i> Generate
      </button>
    </div>
  </form>

  {{-- Export Buttons --}}
  <div class="d-flex gap-2 mb-4">
    <a href="{{ route('admin.report.export.pdf') }}" class="btn btn-outline-danger">
      <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF
    </a>
    <a href="{{ route('admin.report.export.excel', request()->all()) }}" class="btn btn-outline-success">
      <i class="bi bi-file-earmark-excel-fill me-1"></i> Export Excel
    </a>
  </div>

  {{-- Results Table --}}
  @if($applications->isEmpty())
    <div class="alert alert-warning text-center">No records found for this filter.</div>
  @else
    <div class="table-responsive">
      <table class="table table-bordered table-striped small">
        <thead class="table-primary">
          <tr>
            <th>Full Name</th>
            <th>Matric No</th>
            <th>Department</th>
            <th>Level</th>
            <th>Refund Due</th>
            <th>NELFUND Tracking ID</th>
            <th>Account Name</th>
            <th>Account No</th>
            <th>Bank</th>
            <th>Sort Code</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Hostel</th>
            <th>Status</th>
            <th>Submitted At</th>
            <th>Approved At</th>
            <th>Disbursed At</th>
          </tr>
        </thead>
        <tbody>
          @foreach($applications as $application)
            <tr>
              <td>{{ $application->student->full_name }}</td>
              <td>{{ $application->student->matric_number }}</td>
              <td>{{ $application->student->department }}</td>
              <td>{{ $application->student->level }}</td>
              <td>₦{{ number_format($application->student->refund_amount, 2) }}</td>
              <td>{{ $application->tracking_id }}</td>
              <td>{{ $application->account_name }}</td>
              <td>{{ $application->account_number }}</td>
              <td>{{ $application->bank_name }}</td>
              <td>{{ $sortCodes[$application->bank_name] ?? 'N/A' }}</td>
              <td>{{ $application->phone }}</td>
              <td>{{ $application->email }}</td>
              <td>{{ $application->hostel }}</td>
              <td>
                <span class="badge bg-{{ $application->status === 'approved' ? 'success' : ($application->status === 'declined' ? 'danger' : ($application->status === 'disbursed' ? 'primary' : 'warning text-dark')) }}">
                  {{ ucfirst($application->status) }}
                </span>
              </td>
              <td>{{ $application->submitted_at ? $application->submitted_at->format('d M Y, h:i A') : '-' }}</td>
              <td>{{ $application->approved_at ? $application->approved_at->format('d M Y, h:i A') : '-' }}</td>
              <td>{{ $application->disbursed_at ? $application->disbursed_at->format('d M Y, h:i A') : '-' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
