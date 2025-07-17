<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.applications') }}">
                    <i class="bi bi-file-earmark-text"></i> All Applications
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="bi bi-collection"></i> Records
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.upload') }}">
                    <i class="bi bi-cloud-upload"></i> Upload Students
                </a>
            </li>
        </ul>
    </div>
</nav>
