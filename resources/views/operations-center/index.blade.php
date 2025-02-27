@extends('layouts.app')

@section('content')

<div class="page-title accent-background py-4">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Resources</h1>
        <nav class="breadcrumbs">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('pdrrmo.index') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Resources</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container text-center d-flex justify-content-between align-items-center">
    <div>
        <h3 class="mt-3" style="font-family: 'Poppins', sans-serif; color: #FE6305;">Equipment and Vehicles</h3>
        <p style="font-family: 'Roboto', sans-serif; max-width: 1200px; margin: auto; color: #003489;">
            The Provincial Disaster Risk Reduction and Management Office (PDRRMO) as part of its measure for disaster
            preparedness and response have acquired equipment and emergency vehicles. Its purpose is to provide quick
            response and assistance to our fellow Ilonggos. The list of equipment and vehicles includes the following:
        </p>
    </div>

    @auth
    <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addItemModal">
        <i class="bi bi-plus-square"></i> Add New
    </button>
    @endauth
</div>

<div class="container text-start">
    <h3 class="mt-5" style="font-family: 'Poppins', sans-serif; color: #FE6305;">Emergency Vehicles</h3>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($items as $item)
            @if($item->type === 'vehicle')
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top img-fluid card-img" alt="{{ $item->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <div class="d-flex justify-content-between">
                                @auth
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editItemModal"
                                    onclick="setEditForm({{ $item->id }}, '{{ $item->name }}', '{{ $item->type }}')">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#deleteItemModal"
                                    onclick="setDeleteForm({{ $item->id }})">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

<div class="container text-start mb-5">
    <h3 class="mt-5" style="font-family: 'Poppins', sans-serif; color: #FE6305;">Equipments</h3>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($items as $item)
            @if($item->type === 'equipment')
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top img-fluid card-img" alt="{{ $item->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <div class="d-flex justify-content-between">
                                @auth
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editItemModal"
                                    onclick="setEditForm({{ $item->id }}, '{{ $item->name }}', '{{ $item->type }}')">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#deleteItemModal"
                                    onclick="setDeleteForm({{ $item->id }})">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

<div class="container">
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemModalLabel">Add New Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addItemForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="vehicle">Vehicle</option>
                                <option value="equipment">Equipment</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100"><i class="bi bi-floppy"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteItemModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-square-fill"></i> Cancel</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Edit Modal -->
    <div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editItemForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="editName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editImage" class="form-label">Image</label>
                            <input type="file" class="form-control" id="editImage" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="editType" class="form-label">Type</label>
                            <select class="form-select" id="editType" name="type">
                                <option value="vehicle">Vehicle</option>
                                <option value="equipment">Equipment</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100"><i class="bi bi-floppy"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery and AJAX Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function setEditForm(id, name, type) {
        $('#editItemForm').attr('action', '/operation-center/' + id);
        $('#editName').val(name);
        $('#editType').val(type); // Set the type (vehicle/equipment)
    }

    $('#editItemForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#editItemModal').modal('hide');
                location.reload(); // Refresh the page to show updated item
            },
            error: function (response) {
                alert('Error updating item');
            }
        });
    });
</script>

<script>
    function setDeleteForm(id) {
        $('#deleteForm').attr('action', '/operation-center/' + id);
    }
</script>

<script>
    $(document).ready(function () {
        $('#addItemForm').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            // Ensure type is explicitly appended
            formData.append("type", $("#type").val());

            $.ajax({
                url: "{{ route('operation-center.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#addItemModal').modal('hide');
                    location.reload(); // Refresh the page to show the new item
                },
                error: function (response) {
                    alert('Error adding item');
                }
            });
        });
    });
</script>

<!-- Custom Styles -->
<style>
    .card-img {
        width: 100%; /* Make the image take full width of the card */
        height: 200px; /* Fixed height to maintain consistency */
        object-fit: cover; /* Ensure image is properly cropped */
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .card:hover .card-img {
        transform: scale(1.05); /* Slight zoom effect */
        opacity: 0.8; /* Reduce opacity slightly on hover */
    }
</style>

@endsection
