<x-header>
    {{-- <main class=""> --}}
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
        <h3 class="text-center mb-4 text-primary">Submitted Refund Applications</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Pending</h5>
                                <!-- <h2 class="display-6">42</h2> -->
                                <h2 id="pendingCount" class="display-6">0</h2>
                            </div>
                            <i class="bi bi-hourglass-split" style="font-size: 3rem"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Approved</h5>
                                <!-- <h2 class="display-6">128</h2> -->
                                <h2 id="approvedCount" class="display-6">0</h2>
                            </div>
                            <i class="bi bi-check2-circle" style="font-size: 3rem"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Rejected</h5>
                                <!-- <h2 class="display-6">15</h2> -->
                                <h2 id="rejectedCount" class="display-6">0</h2>
                            </div>
                            <i class="bi bi-x-circle" style="font-size: 3rem"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search name, matric, tracking ID"
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted
                    </option>
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

        @if ($applications->isEmpty())
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
                        @foreach ($applications as $application)
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
                                    <a href="{{ asset('storage/' . $application->proof_file) }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm">
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
                                        <form action="{{ route('admin.update', $application->id) }}" method="POST"
                                            class="d-flex gap-1">
                                            @csrf
                                            @method('PATCH')
                                            <button name="action" value="approve"
                                                class="btn btn-success btn-sm">Approve</button>
                                            <button name="action" value="decline"
                                                class="btn btn-danger btn-sm">Decline</button>
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
</x-header>
