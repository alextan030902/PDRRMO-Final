@extends('layouts.app')

@section('content')


   <!-- Welcome Modal -->
   @if(session('welcome_message'))
   <div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
         <div class="modal-header" style="background-color: #003489; color: white;">
           <h5 class="modal-title" id="welcomeModalLabel">Welcome!</h5>
         </div>
         <div class="modal-body" style="background-color: #f8f9fa; color: #333;">
           <p class="text-center">{{ session('welcome_message') }}</p>
         </div>
         <div class="modal-footer" style="background-color: #f8f9fa; justify-content: center;">
           <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Okay</button>
         </div>
       </div>
     </div>
   </div>
 @endif

    @if(session('success'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
        <div class="toast-body">
            {{ session('success') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    </div>
    @endif

    @if(session('error'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
        <div class="toast-body">
            {{ session('error') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    </div>
    @endif

  <!-- Banner Section -->
  <div class="container-fluid mt-0 mb-4 p-0" style="overflow-x: hidden;">
    <div class="row">
        <div class="col-12 text-center position-relative">
            <!-- Banner Image -->
            <img src="{{ asset('storage/' . ($imagePath ?? 'images/banner-final.png')) }}" alt="Banner Image" class="banner-image img-fluid">

            <!-- Conditional Button Display for Authenticated Users -->
            @auth
                <div class="btn-group position-absolute bottom-0 end-0 m-3" role="group">
                    <!-- Only show 'Add' button if no image is uploaded -->
                    @if (!$imagePath)
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            <i class="fas fa-plus"></i> Add
                        </a>
                    @endif

                    <a href="#" data-bs-toggle="modal" data-bs-target="#uploadModal" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Change Photo
                    </a>

                    <form action="{{ route('pdrrmo-home.destroy', ['id' => $pdrrmo->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</div>

<!--Create Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadModalLabel">Upload Image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('pdrrmo-home.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="image" class="form-label">Select an Image</label>
              <input type="file" class="form-control" id="image" name="image" accept="image/*" required onchange="previewImage(event)">
            </div>
  
            <!-- Image Preview -->
            <div class="mb-3">
              <img id="imagePreview" src="#" alt="Image Preview" class="img-fluid" style="display:none; max-height: 300px;">
            </div>
  
            <div class="mb-3">
              <button type="submit" class="btn btn-primary">Upload</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!--Edit Modal -->
  <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pdrrmo-home.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="image" class="form-label">Select an Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required onchange="previewImage(event)">
                    </div>

                    <!-- Current Image Preview (if available) -->
                    <div class="mb-3">
                        <label for="currentImage" class="form-label">Current Image</label>
                        <img id="currentImagePreview" src="{{ asset('assets/img/hero-carousel/hero-carousel-1.jpg') }}" alt="Current Image" class="img-fluid" style="max-height: 300px; display: block;">
                    </div>

                    <!-- New Image Preview -->
                    <div class="mb-3">
                        <label for="newImage" class="form-label">New Image Preview</label>
                        <img id="imagePreview" src="#" alt="Image Preview" class="img-fluid" style="display:none; max-height: 300px;">
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


  <!-- Hero Carousel Section -->
  <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('assets/img/hero-carousel/hero-carousel-1.jpg') }}" class="d-block w-100" alt="Image 1" style="max-height: 400px; object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('assets/img/hero-carousel/hero-carousel-2.jpg') }}" class="d-block w-100" alt="Image 2" style="max-height: 400px; object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('assets/img/hero-carousel/hero-carousel-3.jpg') }}" class="d-block w-100" alt="Image 3" style="max-height: 400px; object-fit: cover;">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<hr class="my-4 border-3 w-100" style="color: black;">

<div class="container mt-4">
    <h3 class="fw-bold">Latest Updates</h3>
</div>

<div class="container mt-4">
    <div class="row gx-4">
        <!-- LEFT COLUMN: ISSUANCE + ACTIVITIES -->
        <div class="col-md-6 d-flex flex-column">
            <!-- ISSUANCE SECTION -->
            <div class="mb-4">
                <h5 class="fw-semibold">Issuance</h5>
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <a href="#" class="text-decoration-none text-primary">NDRRMC Memorandum No. 14, s. 2025</a>
                            </li>
                            <li class="list-group-item">
                                <a href="#" class="text-decoration-none text-primary">NDRRMC Memorandum No. 02, s. 2025</a>
                            </li>
                            <li class="list-group-item">
                                <a href="#" class="text-decoration-none text-primary">NDRRMC Memorandum No. 01, s. 2025</a>
                            </li>
                            <li class="list-group-item">
                                <a href="#" class="text-decoration-none text-primary">NDRRMC Memorandum No. 388, s. 2024</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- ACTIVITIES SECTION FIXED -->
            <div class="mt-3">
                <h5 class="fw-semibold mb-3">Activities</h5>
                <div class="card shadow-sm">
                    <div id="hero-carousel-card" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('assets/img/hero-carousel/hero-carousel-1.jpg') }}" class="d-block w-100 rounded" alt="First Slide">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('assets/img/hero-carousel/hero-carousel-2.jpg') }}" class="d-block w-100 rounded" alt="Second Slide">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('assets/img/hero-carousel/hero-carousel-3.jpg') }}" class="d-block w-100 rounded" alt="Third Slide">
                            </div>
                        </div>

                        <!-- Carousel Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#hero-carousel-card" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#hero-carousel-card" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>

                        <!-- Carousel Indicators -->
                        <div class="carousel-indicators"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: DISASTER & CALAMITY UPDATES -->
        <div class="col-md-6 d-flex flex-column">
            <h5 class="fw-semibold">Disasters and Calamity Updates</h5>
            <div class="card shadow-sm d-flex flex-column flex-grow-1">
                <div class="card-body d-flex flex-column">
                    <div class="alert alert-warning text-white text-center" style="background-color: #ff9A00;">
                        As of <span id="timestamp"></span>
                    </div>
                    <div class="d-flex flex-column flex-grow-1 justify-content-center align-items-center text-muted">
                        <p>No Record!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to format and display the current time
    function updateTime() {
        const now = new Date();
        const formattedTime = now.toLocaleString(); // Customize the format as needed
        document.getElementById('timestamp').textContent = formattedTime;
    }

    // Update the time immediately and then every second
    updateTime(); // Initial call to show time right away
    setInterval(updateTime, 1000); // Update every second

      // Trigger modal when page loads
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('welcome_message'))
                var myModal = new bootstrap.Modal(document.getElementById('welcomeModal'), {
                    keyboard: false,
                    backdrop: 'static'
                });
                myModal.show();

                // Auto close the modal after 5 seconds
                setTimeout(function() {
                    myModal.hide();
                }, 5000); // 5000ms = 5 seconds
            @endif
        });

    function previewImage(event) {
        const reader = new FileReader();
        const imagePreview = document.getElementById('imagePreview');

        reader.onload = function() {
        // Show the preview image
        imagePreview.src = reader.result;
        imagePreview.style.display = "block";
        }

        // Read the file as a data URL
        if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Show Success Toast
        @if(session('success'))
            var successToastEl = document.getElementById('successToast');
            var successToast = new bootstrap.Toast(successToastEl, {
                delay: 5000  // The toast will disappear after 5 seconds (5000ms)
            });
            successToast.show();
        @endif

        // Show Error Toast
        @if(session('error'))
            var errorToastEl = document.getElementById('errorToast');
            var errorToast = new bootstrap.Toast(errorToastEl, {
                delay: 5000  // The toast will disappear after 5 seconds (5000ms)
            });
            errorToast.show();
        @endif
    });

    // Function to show the preview of the new selected image
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');
        const currentImagePreview = document.getElementById('currentImagePreview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.style.display = 'block'; // Show the new image preview
                preview.src = e.target.result; // Set the image preview source
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none'; // Hide the preview if no file is selected
        }
    }

    // Optional: Reset the preview when modal is opened
    $('#uploadModal').on('shown.bs.modal', function () {
        document.getElementById('imagePreview').style.display = 'none'; // Hide the preview on modal open
    });

</script>

@endsection



<section id="hero" class="hero section dark-background mb-3">
    <div id="heroes-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="2000">
        <div class="carousel-inner">
            @php
                $carouselImages = array_filter([$carouselImage1, $carouselImage2, $carouselImage3]);
            @endphp

            @if(count($carouselImages) > 0)
                @foreach($carouselImages as $index => $image)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img src="{{ Storage::url($image) }}" alt="Carousel Image {{ $index + 1 }}" class="d-block w-100 banner-image img-fluid">
                    </div>
                @endforeach
            @else
                <div class="carousel-item active">
                    <div class="text-center text-light py-5">No carousel images available.</div>
                </div>
            @endif
        </div>

        <!-- Carousel Controls -->
        @if(count($carouselImages) > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#heroes-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroes-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        @endif

        @auth
            <!-- Action button for logged-in users -->
            <div class="position-absolute bottom-0 end-0 m-3">
                <a href="javascript:void(0);" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#carouselUpload">
                    <i class="fas fa-edit"></i> Change Photos
                </a>
            </div>
        @endauth
    </div>
</section>





<section id="latest-updates" class="py-5 bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Card Wrapper -->
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column: Issuance and Activities -->
                            <div class="col-lg-6">
                                <h2 class="text-orange fw-bold">Latest Updates</h2>
                                <div class="mb-4">
                                    <h5 class="fw-bold">Issuance</h5>
                                    <div class="list-group">
                                        @foreach ($files as $file)
                                            <div>
                                                <strong>{{ $file->name }}</strong>
                                                <a href="{{ Storage::url($file->path) }}" target="_blank">Download</a>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- File Upload Form -->
                                    <form action="{{ route('file.upload.submit') }}" method="POST" enctype="multipart/form-data">
                                        @csrf  <!-- CSRF token for security -->
                                        <div class="mt-3">
                                            <label for="file-upload" class="form-label">Choose Files to Upload</label>
                                            <input type="file" id="file-upload" name="file[]" class="form-control" multiple />
                                        </div>

                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-upload"></i> Upload Files
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Right Column: Disasters and Calamity Updates -->
                            <div class="col-lg-6">
                                <div class="border p-3 rounded bg-white shadow-sm">
                                    <h5 class="text-orange fw-bold">Disasters and Calamity Updates</h5>
                                    <div class="alert alert-warning text-center fw-bold" id="current-time">
                                        <!-- Real-time time will be inserted here -->
                                    </div>
                                    <div class="fb-page"
                                         data-href="https://www.facebook.com/p/Operation-Center-Pdrrmo-Iloilo-61570456584511/"
                                         data-tabs="timeline" data-width="500" data-height="600" data-small-header="false"
                                         data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false">
                                        <blockquote cite="https://www.facebook.com/p/Operation-Center-Pdrrmo-Iloilo-61570456584511/"
                                                    class="fb-xfbml-parse-ignore">
                                            <a href="https://www.facebook.com/p/Operation-Center-Pdrrmo-Iloilo-61570456584511/">Your Page Name</a>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activities Section -->
                        <div class="col-12 mt-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5 class="fw-bold">Activities</h5>
                                    <div class="card">
                                        <img src="{{ asset('assets/img/banner-final.png') }}" class="card-img-top" alt="Activities">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- <div class="card">
    <div class="card-body">
        <h5 class="fw-bold">Activities</h5>
        <div id="carouselExampleDark" class="carousel carousel-dark slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                    <img src="{{ asset('assets/img/banner-final.png') }}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>First slide label</h5>
                        <p>Some representative placeholder content for the first slide.</p>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="{{ asset('assets/img/final-logo.png') }}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Second slide label</h5>
                        <p>Some representative placeholder content for the second slide.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('assets/img/final-logo.png') }}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Third slide label</h5>
                        <p>Some representative placeholder content for the third slide.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div> --}}