<style>
  .navbar-blue {
    background-color: #0d6efd;
    color: white;
  }
  .navbar-blue .nav-link {
    color: white;
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease-in-out;
  }
  .navbar-blue .nav-link:hover {
    background-color: #ffffff;
    color: #0d6efd;
    border-radius: 5px;
  }
  .navbar-blue .nav-link.active {
    background-color: #ffffff !important;
    color: #0d6efd !important;
    border-radius: 5px;
  }
  .navbar-header h4 {
    margin-bottom: 0;
  }
</style>

<header class="p-3 navbar-blue shadow-sm">
  <div class="container d-flex justify-content-between align-items-center navbar-header">
    <h4 class="text-white">
      <i class="bi bi-speedometer2 me-2"></i>Admin Dashboard
    </h4>

    <div class="d-flex align-items-center gap-3">
      @if(session('admin_name'))
        <span class="text-white fw-medium">Welcome, {{ session('admin_name') }}</span>
        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-sm btn-light">Logout</button>
        </form>
      @endif
      <a href="{{ url('/') }}" class="btn btn-sm btn-outline-light">Go to Home</a>
    </div>
  </div>

  <nav class="navbar-blue mt-3">
    <div class="container">
      <ul class="nav nav-pills gap-2">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-house-door me-1"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}">
            <i class="bi bi-people me-1"></i> Users
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.report') ? 'active' : '' }}" href="{{ route('admin.report') }}">
            <i class="bi bi-clipboard-data me-1"></i> Report
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.upload.students') ? 'active' : '' }}" href="{{ route('admin.upload.students') }}">
            <i class="bi bi-upload me-1"></i> Upload Students
          </a>
        </li>
      </ul>
    </div>
  </nav>
</header>
