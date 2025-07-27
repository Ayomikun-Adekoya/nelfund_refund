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

<div class="container-fluid mt-4">
  <div class="row">
    <div class="col-md-10 offset-md-1">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-primary"><i class="bi bi-people-fill me-2"></i>Admin Users</h4>

        @if(session('admin_role') === 'approver')
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createAdminModal">
          <i class="bi bi-person-plus me-1"></i> Add Admin
        </button>
        @endif
      </div>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <div class="card shadow-sm">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover table-bordered mb-0">
              <thead class="table-primary">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Created</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($admins as $index => $admin)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $admin->name }}</td>
                  <td>{{ $admin->email }}</td>
                  <td>
                    @php
                      $badgeClass = match($admin->role) {
                        'approver' => 'success',
                        'disburser' => 'info',
                        default => 'secondary',
                      };
                    @endphp
                    <span class="badge bg-{{ $badgeClass }}">
                      {{ ucfirst($admin->role) }}
                    </span>
                  </td>
                  <td>{{ $admin->created_at->format('d M Y') }}</td>
                  <td>
                    @if(session('admin_role') === 'approver' && session('admin_id') != $admin->id)
                    <form action="{{ route('admin.users.delete', $admin->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                    @else
                    <small class="text-muted">No Action</small>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center text-muted">No admin users found.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Create Admin Modal --}}
<div class="modal fade" id="createAdminModal" tabindex="-1" aria-labelledby="createAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.users.create') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="createAdminModalLabel">Create New Admin</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>

          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" required>
              <option value="viewer">Viewer</option>
              <option value="approver">Approver</option>
              <option value="disburser">Disburser</option> <!-- ✅ New Role Added -->
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create Admin</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
