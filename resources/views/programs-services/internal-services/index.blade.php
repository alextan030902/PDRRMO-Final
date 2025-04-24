@extends('layouts.app')

@section('content')

<div class="page-title accent-background py-4">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Internal Services</h1>
        <nav class="breadcrumbs">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('pdrrmo.index') }}">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Internal Services</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid">
    <div class="container-fluid my-5">
        <div class="row g-4 align-items-stretch"> 
            <div class="col-lg-6 d-flex flex-column">
                <div class="card shadow-lg rounded-3 border-light d-flex flex-column" style="height: 100%;">
                    <div class="text-center p-3">
                        <h5 class="text-orange fw-bold" style="font-size: 1.5rem;">INTERNAL SERVICES</h5>
                    </div>
            
                    <div class="px-4 pb-2">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search for a file..." onkeyup="filterServices()">
                    </div>
            
                    <!-- Scrollable area only for content -->
                    <div class="flex-grow-1 overflow-auto px-4" style="max-height: 800px;">
                        <div class="accordion" id="servicesAccordion">
                            @if($files->isEmpty())
                                <p class="text-center text-muted">No files available.</p>
                            @else
                                @foreach ($files as $file)
                                    <div class="accordion-item service-item" data-title="{{ strtolower($file->title) }}">
                                        <h2 class="accordion-header" id="heading{{ $file->id }}">
                                            <button class="accordion-button btn-custom collapsed fs-5 fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $file->id }}" aria-expanded="false" aria-controls="collapse{{ $file->id }}">
                                                {{ $file->title }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $file->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $file->id }}" data-bs-parent="#servicesAccordion">
                                            <div class="accordion-body p-4">
                                                <p>{{ $file->description }}</p>
                                                @if($file->file_path)
                                                    <p>
                                                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-link text-primary">
                                                            <i class="fas fa-download"></i> Download Attachment
                                                        </a>
                                                    </p>
                                                @else
                                                    <p class="text-muted">No file attached.</p>
                                                @endif
                                                <div class="d-flex justify-content-end mt-3">
                                                    <button type="button" class="btn btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#editModal{{ $file->id }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <form action="{{ route('programs-services.internal.destroy', $file->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-outline-danger ms-2 rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteItemModal{{ $file->id }}">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
            
                    <!-- Upload button OUTSIDE scrollable area, right-aligned -->
                    @auth
                    <div class="d-flex justify-content-end p-3 border-top">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            <i class="fas fa-upload"></i> Upload File
                        </button>
                    </div>
                    @endauth
                </div>
            </div>
            
            

            <div class="col-lg-6 d-flex flex-column">
                <div class="card shadow-lg rounded-lg w-100 border-light h-100"> 
                    <div class="card-body text-center h-100">
                        <h5 class="fw-bold mb-4">LATEST UPDATES</h5> 
                        <div class="alert alert-warning fw-bold fs-5 mb-4" id="current-time"></div>
                        <div class="fb-page"
                            data-href="https://www.facebook.com/p/Operation-Center-Pdrrmo-Iloilo-61570456584511/"
                            data-tabs="timeline" data-width="500" data-height="800"
                            data-small-header="false" data-adapt-container-width="true"
                            data-hide-cover="false" data-show-facepile="false">
                            <blockquote cite="https://www.facebook.com/p/Operation-Center-Pdrrmo-Iloilo-61570456584511/" class="fb-xfbml-parse-ignore">
                                <a href="https://www.facebook.com/p/Operation-Center-Pdrrmo-Iloilo-61570456584511/">PDRRMO Facebook</a>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals (Edit, Upload, Delete) -->
    @foreach ($files as $file)
    <div class="modal fade" id="editModal{{ $file->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $file->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit File: {{ $file->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('programs-services.internal.update', $file->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title', $file->title) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="4" required>{{ old('description', $file->description) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">File</label>
                            <input type="file" class="form-control" name="file">
                            <small class="text-muted">Current: <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">{{ basename($file->file_path) }}</a></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteItemModal{{ $file->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">Are you sure you want to delete this file?</div>
                <div class="modal-footer">
                    <form action="{{ route('programs-services.internal.destroy', $file->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('programs-services.internal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">File Upload</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="fileUpload" class="form-label">Choose File</label>
                            <input type="file" class="form-control" name="file" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- JavaScript -->
<script>
    // Real-time Search functionality
    function filterServices() {
        let input = document.getElementById('searchInput');
        let filter = input.value.toLowerCase();
        let items = document.getElementsByClassName('service-item');

        Array.from(items).forEach(item => {
            let title = item.getAttribute('data-title');
            if (title.indexOf(filter) > -1) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>

<script>
    // Real-time time update
    function updateTime() {
        const now = new Date();
        const options = { 
            year: 'numeric', month: 'long', day: 'numeric', 
            hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true 
        };
        document.getElementById('current-time').textContent = now.toLocaleString('en-GB', options);
    }
    setInterval(updateTime, 1000);
    updateTime();
</script>

<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v17.0"></script>

@endsection
