<x-header>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">All Applications</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary">
                        Export
                    </button>
                </div>
            </div>
        </div>

        <!-- Filter Controls -->
        <div class="card card-body mb-3">
            <form id="filterForm" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="statusFilter" class="form-label">Filter by Status</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Pending">Pending</option>
                        <option value="In Review">In Review</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Processed">Processed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" id="startDate" class="form-control" />
                </div>
                <div class="col-md-3">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" id="endDate" class="form-control" />
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Applications Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Tracking ID</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="allApplicationsBody" class="align-middle">
                    <tr>
                        <td colspan="6" class="text-center">
                            Loading applications...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul id="pagination" class="pagination justify-content-center">
                <!-- Pagination items will be inserted here by JS -->
            </ul>
        </nav>
    </main>
    <!-- Application Details Modal (same as in admin.html) -->
    <div class="modal fade" id="applicationModal" tabindex="-1" aria-labelledby="applicationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applicationModalLabel">
                        Application Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="applicationModalBody">
                    <p class="text-center">Loading details...</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-success" id="saveChangesBtn">
                        Save Changes & Notify
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-header>
