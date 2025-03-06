@extends('layouts.app')

@section('content')

<!-- Page Title -->
<div class="page-title accent-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Internal Services</h1>
      <nav class="breadcrumbs">
        <ol>
            <a href="{{ route('pdrrmo.index') }}">Home</a>
          <li class="current">Internal Services</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->


<div class="container-fluid my-5">
    <div class="row g-4 align-items-stretch"> 
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="d-flex flex-column h-100"> 
                <div class="text-center mb-4">
                    <h5 class="text-orange fw-bold" style="font-size: 1.5rem;">INTERNAL SERVICES</h5>
                </div>
                <div class="card shadow-lg rounded-3 border-light h-100"> <!-- Full height card -->
                    <div class="card-body">
                        <div class="accordion" id="servicesAccordion">
                            @if($files->isEmpty())
                                <p class="text-center text-muted">No files available.</p>
                            @else
                                <!-- Display the first 15 files -->
                                @foreach ($files->take(15) as $file)
                                    <div class="accordion-item">
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
                                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $file->id }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
        
                                                    <form action="{{ route('programs-services.internal.destroy', $file->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger ms-2" onclick="return confirm('Are you sure you want to delete this file?')">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
        
                                <!-- See More Button if there are more files -->
                                @if($files->count() > 15)
                                    <div class="d-flex justify-content-center mt-3">
                                        <button class="btn btn-link text-primary" data-bs-toggle="collapse" data-bs-target="#extraFiles" aria-expanded="false" aria-controls="extraFiles">
                                            <i class="fas fa-chevron-down"></i> See More
                                        </button>
                                    </div>
                                @endif
        
                                <!-- Display the remaining files, initially collapsed -->
                                <div id="extraFiles" class="collapse">
                                    @foreach ($files->skip(15) as $file)
                                        <div class="accordion-item">
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
                                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $file->id }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
        
                                                        <form action="{{ route('programs-services.internal.destroy', $file->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger ms-2" onclick="return confirm('Are you sure you want to delete this file?')">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
        
                        <!-- Upload File Button -->
                        <div class="d-flex justify-content-center mt-4">
                            <button class="btn btn-primary rounded-pill ms-auto" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                <i class="fas fa-upload"></i> Upload File
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- Disaster and Calamity Updates Section -->
        <div class="col-lg-6 d-flex flex-column mb-4 mb-lg-0">
            <div class="card shadow-lg rounded-lg w-100 border-light h-100"> <!-- Full height card -->
                <div class="card-body text-center h-100">
                    <h5 class="fw-bold mb-4">LATEST UPDATES</h5> <!-- Primary color text -->
                    <div class="alert alert-warning fw-bold fs-5 mb-4" id="current-time">
                        <!-- Real-time date and time will be inserted here -->
                    </div>
                    <div class="fb-page"
                        data-href="https://www.facebook.com/p/Operation-Center-Pdrrmo-Iloilo-61570456584511/"
                        data-tabs="timeline" data-width="700" data-height="800"
                        data-small-header="false" data-adapt-container-width="true"
                        data-hide-cover="false" data-show-facepile="false">
                        <blockquote
                            cite="https://www.facebook.com/p/Operation-Center-Pdrrmo-Iloilo-61570456584511/"
                            class="fb-xfbml-parse-ignore">
                            <a
                                href="https://www.facebook.com/p/Operation-Center-Pdrrmo-Iloilo-61570456584511/">Your
                                Page Name</a>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Edit Modal -->
@foreach ($files as $file)
    <div class="modal fade" id="editModal{{ $file->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $file->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $file->id }}">Edit File: {{ $file->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('programs-services.internal.update', $file->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $file->title) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $file->description) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">File</label>
                            <input type="file" class="form-control" id="file" name="file">
                            <small class="text-muted">Current File: <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">{{ basename($file->file_path) }}</a></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!-- File Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">File Upload</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('programs-services.internal.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter a title for the file" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Enter a description for the file" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="fileUpload" class="form-label">Choose File</label>
                        <input type="file" class="form-control" id="fileUpload" name="file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Update time function
    function updateTime() {
        const now = new Date();
        const options = {
            month: 'long',
            day: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        };
        const dateString = now.toLocaleString('en-GB', options);
        document.getElementById('current-time').innerHTML = dateString;
    }

    setInterval(updateTime, 1000); // Update every second
    updateTime(); // Initial call to set the time immediately
</script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v17.0"></script>

@endsection
