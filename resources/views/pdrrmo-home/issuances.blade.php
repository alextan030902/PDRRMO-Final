@extends('layouts.app')

@section('content')

<div class="page-title accent-background py-4">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Issuances</h1>
        <nav class="breadcrumbs">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('pdrrmo.index') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Issuances</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        @auth
        <button class="btn btn-outline-success" id="resetButton" data-bs-toggle="modal" data-bs-target="#addIssuanceModal">
            <i class="fas fa-plus me-2"></i> Add Issuance
        </button>
        @endauth
        
        <div class="d-flex justify-content-end align-items-center">
            <form id="filterForm" method="GET" action="{{ route('pdrrmo-home.issuances') }}">
                <div class="row g-2">
                    <!-- Category Selection -->
                    <div class="col-md-6 col-sm-12">
                        <label for="categorySelect" class="form-label mb-0">Category:</label>
                        <select class="form-select form-select-sm shadow-sm" id="categorySelect" name="category" onchange="updateYears()">
                            <option value="">Select a Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
            
                    <!-- Year Selection -->
                    <div class="col-md-6 col-sm-12">
                        <label for="yearSelect" class="form-label mb-0">Filter by Year:</label>
                        <select class="form-select form-select-sm shadow-sm" id="yearSelect" name="year" onchange="submitFormIfValid()">
                            <option value="">Select a Year</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Issuance Modal -->
<div class="modal fade" id="addIssuanceModal" tabindex="-1" aria-labelledby="addIssuanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addIssuanceModalLabel">Add New Issuance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addIssuanceModalForm" action="{{ route('file.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="categorySelect" class="form-label">Category</label>
                        <select class="form-select" id="categorySelect" name="category" required>
                            <option value="">Select a Category</option>
                            <option value="Memo">Memo</option>
                            <option value="Executive Order">Executive Order</option>
                            <option value="Resolution">Resolution</option>
                            <option value="Advisory">Advisory</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="filenameInput" class="form-label">Filename</label>
                        <input type="text" class="form-control" id="filenameInput" name="filename" placeholder="Enter file name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="fileUpload" class="form-label">File Upload</label>
                        <input class="form-control" type="file" id="fileUpload" name="file" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="dateInput" class="form-label">Date</label>
                        <input type="date" class="form-control" id="dateInput" name="date" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> Close
                </button>
                <button type="submit" form="addIssuanceModalForm" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Save Issuance
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the file: <strong id="fileName"></strong>?
            </div>
            <div class="modal-footer">
                <form id="deleteForm" action="{{ route('file.delete', '') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="fileId" name="fileId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-2"></i> Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Issuances Table -->
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <!-- Combined Table for all files -->
        <div class="col-lg-10 col-md-8 col-sm-10 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                </div>
                <div class="card-body overflow-auto" style="max-height: 400px;">
                    <table class="table table-bordered table-sm table-align-middle mx-auto">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($files as $file)
                                <tr>
                                    <td><strong>{{ $file->name }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($file->date)->format('m/d/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ asset('storage/' . $file->path) }}" class="btn btn-primary btn-sm" download="{{ $file->name }}">
                                            <i class="fas fa-download me-2"></i> Download
                                        </a>
                                        @auth
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $file->id }}" data-name="{{ $file->name }}">
                                            <i class="fas fa-trash-alt me-2"></i> Delete
                                        </button>
                                        @endauth
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No files found for the selected filters.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    // This function will be triggered when the category is selected
    function updateYears() {
        // Get the selected category value
        var category = document.getElementById("categorySelect").value;

        // Reset the year dropdown to its default state
        var yearSelect = document.getElementById("yearSelect");
        yearSelect.innerHTML = '<option value="">Select a Year</option>';

        // If no category is selected, do nothing
        if (!category) return;

        // Make an AJAX request to get the years for the selected category
        fetch(`/get-years-by-category?category=${category}`)
            .then(response => response.json())  // Parse the response as JSON
            .then(data => {
                // Check if there are any years available for the selected category
                if (data.years && data.years.length > 0) {
                    // Populate the year dropdown with available years
                    data.years.forEach(function(year) {
                        var option = document.createElement("option");
                        option.value = year;
                        option.textContent = year;
                        yearSelect.appendChild(option);
                    });
                } else {
                    // If no years available, show a placeholder
                    var option = document.createElement("option");
                    option.value = "";
                    option.textContent = "No years available";
                    yearSelect.appendChild(option);
                }
            })
            .catch(error => {
                console.error('Error fetching years:', error);
            });
    }

    // Submit the form if both category and year are selected
    function submitFormIfValid() {
        var category = document.getElementById("categorySelect").value;
        var year = document.getElementById("yearSelect").value;

        // Only submit the form if both category and year are selected
        if (category && year) {
            document.getElementById("filterForm").submit();
        }
    }
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var fileId = button.getAttribute('data-id');
        var fileName = button.getAttribute('data-name');
        
        var modalFileName = deleteModal.querySelector('#fileName');
        var deleteForm = deleteModal.querySelector('#deleteForm');
        var fileIdInput = deleteForm.querySelector('#fileId');
        
        modalFileName.textContent = fileName;
        fileIdInput.value = fileId;
        deleteForm.action = '/file/' + fileId;
    });

</script>

@endsection
