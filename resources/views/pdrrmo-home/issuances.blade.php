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

<!-- Filter Button and Dropdown -->
<div class="container mt-3 d-flex justify-content-between">
    <button class="btn btn-outline-success" id="resetButton" data-bs-toggle="modal" data-bs-target="#addIssuanceModal">
        <i class="fas fa-plus me-2"></i> Add Issuance
    </button>

    <!-- Year Filter Dropdown -->
    <div class="d-flex align-items-center">
        <label for="yearSelect" class="me-2">Filter by Year:</label>
        <select class="form-select" id="yearSelect" name="year">
            <option value="">Select a Year</option>
            @foreach ($years as $year)
                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
            @endforeach
        </select>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> Close
                </button>
                <button type="submit" form="addIssuanceModalForm" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Save Issuance
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Issuances Table -->
<div class="container mt-5">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Category</th>
                <th scope="col">Filename</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Memos -->
            @foreach ($memos as $memo)
                <tr class="memo-item {{ $loop->index >= 10 ? 'd-none' : '' }}">
                    <td>Memo</td>
                    <td><a href="{{ asset('storage/' . $memo->path) }}" target="_blank">{{ $memo->name }}</a></td>
                    <td>{{ $memo->date }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $memo->id }}" data-name="{{ $memo->name }}">
                            <i class="fas fa-trash-alt me-2"></i> Delete
                        </button>
                    </td>
                </tr>
            @endforeach

            <!-- Executive Orders -->
            @foreach ($executiveOrders as $order)
                <tr class="executive-order-item {{ $loop->index >= 10 ? 'd-none' : '' }}">
                    <td>Executive Order</td>
                    <td><a href="{{ asset('storage/' . $order->path) }}" target="_blank">{{ $order->name }}</a></td>
                    <td>{{ $order->date }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $order->id }}" data-name="{{ $order->name }}">
                            <i class="fas fa-trash-alt me-2"></i> Delete
                        </button>
                    </td>
                </tr>
            @endforeach

            <!-- Resolutions -->
            @foreach ($resolutions as $resolution)
                <tr class="resolution-item {{ $loop->index >= 10 ? 'd-none' : '' }}">
                    <td>Resolution</td>
                    <td><a href="{{ asset('storage/' . $resolution->path) }}" target="_blank">{{ $resolution->name }}</a></td>
                    <td>{{ $resolution->date }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $resolution->id }}" data-name="{{ $resolution->name }}">
                            <i class="fas fa-trash-alt me-2"></i> Delete
                        </button>
                    </td>
                </tr>
            @endforeach

            <!-- Advisories -->
            @foreach ($advisories as $advisory)
                <tr class="advisory-item {{ $loop->index >= 10 ? 'd-none' : '' }}">
                    <td>Advisory</td>
                    <td><a href="{{ asset('storage/' . $advisory->path) }}" target="_blank">{{ $advisory->name }}</a></td>
                    <td>{{ $advisory->date }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $advisory->id }}" data-name="{{ $advisory->name }}">
                            <i class="fas fa-trash-alt me-2"></i> Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- See More Button -->
    @if($memos->count() > 10 || $executiveOrders->count() > 10 || $resolutions->count() > 10 || $advisories->count() > 10)
        <div class="d-flex justify-content-center">
            <button class="btn btn-primary btn-sm see-more" data-type="memo">See More</button>
            <button class="btn btn-success btn-sm see-more" data-type="executive-order">See More</button>
            <button class="btn btn-info btn-sm see-more" data-type="resolution">See More</button>
            <button class="btn btn-warning btn-sm see-more" data-type="advisory">See More</button>
        </div>
    @endif
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const seeMoreButtons = document.querySelectorAll('.see-more');

        seeMoreButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const type = button.getAttribute('data-type');
                const items = document.querySelectorAll('.' + type + '-item');
                
                // Toggle the visibility of hidden items
                items.forEach(function (item, index) {
                    if (index >= 10) {
                        item.classList.toggle('d-none');
                    }
                });

                // Toggle the button text between 'See More' and 'See Less'
                if (button.textContent === "See More") {
                    button.textContent = "See Less";
                } else {
                    button.textContent = "See More";
                }
            });
        });
    });

    // When the year filter changes, reload the page with the selected year as a query parameter
    document.getElementById('yearSelect').addEventListener('change', function () {
        var selectedYear = this.value;
        var url = new URL(window.location.href);
        url.searchParams.set('year', selectedYear);
        window.location.href = url.toString();
    });

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
