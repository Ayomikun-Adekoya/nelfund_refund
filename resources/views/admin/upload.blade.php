<x-header>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Upload Student Data</h1>
        </div>

        <!-- Upload Card -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-file-earmark-excel me-2"></i>Step 1: Select Excel
                File
            </div>
            <div class="card-body">
                <p class="card-text">
                    Select an Excel file (.xlsx, .xls, .csv) to upload. The file
                    should contain headers matching the student data structure:
                    <strong>studentId, name, email, course</strong>.
                </p>
                <div class="mb-3">
                    <input class="form-control" type="file" id="fileUpload" accept=".xlsx, .xls, .csv" />
                </div>
            </div>
        </div>

        <!-- Preview Card -->
        <div id="previewCard" class="card" style="display: none">
            <div class="card-header">
                <i class="bi bi-eye me-2"></i>Step 2: Preview Data
            </div>
            <div class="card-body">
                <p>
                    Review the first 5 rows of data parsed from your file. If it
                    looks correct, proceed with the upload.
                </p>
                <div id="previewTable" class="table-responsive mb-3">
                    <!-- Preview table will be rendered here -->
                </div>
                <div id="uploadFeedback"></div>
                <button id="uploadButton" class="btn btn-success">
                    <i class="bi bi-database-add me-2"></i>Confirm and Upload Data
                </button>
            </div>
        </div>
    </main>
</x-header>
