@extends('layouts.app')

@section('content')

<main class="main">

    <!-- Welcome Modal -->
    @if (session('welcome_message'))
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

<main class="main">
    <!-- Hero Section -->
    {{-- <section id="hero" class="hero section dark-background" style="margin-bottom: 30px;">
        <div id="heroes-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="2000">
            <div class="carousel-item active"> --}}
            <header class="masthead mb-2 position-relative">
                @if ($pdrrmoImagePath)
                    <img src="{{ asset('storage/' . $pdrrmoImagePath) }}" alt="Banner Image" class="banner-image img-fluid">
                @else
                    <div class="d-flex justify-content-center align-items-center" style="height: 100%; background-color: #ffffff;">
                        <div class="text-center">
                            <i class="fas fa-upload fa-3x text-danger"></i>
                            <p class="mt-2 text-danger">No image available. Please upload a banner.</p>
                        </div>
                    </div>
                @endif
    
                @auth
                    <div class="btn-group position-absolute bottom-0 end-0 m-3" role="group">
                        @if (!$pdrrmoImagePath)
                            <a href="javascript:void(0);" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#uploadModal">
                                <i class="fas fa-plus"></i> Add
                            </a>
                        @endif
                        <a href="#" data-bs-toggle="modal" data-bs-target="#uploadModal" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Change Photo
                        </a>
                        @if ($pdrrmo)
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash-alt"></i> Delete
                           
                        </button>
                    @endif
                    
                    </div>
                @endauth
            </header>
            </div>
        </div>
    </section>
    
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
                            <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                required onchange="previewImage(event)">
                        </div>
                        <!-- Image Preview -->
                        <div class="mb-3">
                            <img id="imagePreview" src="#" alt="Image Preview" class="img-fluid"
                                style="display:none; max-height: 300px;">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-cloud-upload-alt"></i> Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this image? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                    
                    @if($pdrrmo)
                        <form action="{{ route('pdrrmo-home.destroy', ['id' => $pdrrmo->id]) }}" method="POST" id="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    @else
                        <p class="text-danger">Image not found, cannot delete!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

 <!-- Hero Section -->
 <section class="carousel-section position-relative">
    @php
        // Fetch available images (ensure to replace this with your actual model logic)
        $images = $carouselImage ? $carouselImage->image_paths : [];
    @endphp

    @if (count($images) > 0)
        <!-- Carousel Items (Images) -->
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($images as $index => $image)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $image) }}" alt="Carousel Image {{ $index + 1 }}" class="d-block w-100" loading="lazy">
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

    @else
        <div class="carousel-item active">
            <div class="no-image-placeholder">
                <i class="fas fa-image fa-3x"></i>
                <p>No Image Available</p>
            </div>
        </div>
    @endif

    @auth
        <!-- Admin Options -->
        <div class="position-absolute bottom-0 end-0 m-3 z-index-10">
            @if (count($images) === 0)
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#carouselUpload">
                    <i class="fas fa-plus-circle"></i> Add Photos
                </button>
            @else
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#carouselUpload">
                    <i class="fas fa-edit"></i> Change Photos
                </button>
            @endif
            @if (count($images) > 0)
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#carouselDelete">
                    <i class="fas fa-trash-alt"></i> Delete Photos
                </button>
            @endif
        </div>
    @endauth
</section>






    <!-- Modal for uploading images for all carousel items -->
    <div class="modal fade" id="carouselUpload" tabindex="-1" aria-labelledby="carouselUploadLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="carouselUploadLabel">Upload Multiple Images for Carousel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('carousel-image.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Multiple Image Upload -->
                        <div class="mb-3">
                            <label for="carouselImages" class="form-label">Choose Images for Carousel</label>
                            <input type="file" class="form-control" id="carouselImages" name="carousel_images[]"
                                accept="image/*" multiple required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Upload Images
                          </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for deleteing images for all carousel items -->
    <div class="modal fade" id="carouselDelete" tabindex="-1" aria-labelledby="carouselDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="carouselDeleteLabel">Delete Carousel Images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete these images from the carousel? This action cannot be undone.</p>
                    <!-- Form to delete images -->
                    <form action="{{ route('carousel-images.delete') }}" method="POST" id="carouselDeleteForm">
                        @csrf
                        @method('DELETE')
                        <div id="deleteImagesContainer">
                            <!-- Dynamically filled with images -->
                        </div>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Delete Images
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

     <!-- Services Section -->
    <section id="latest-updates" class="py-5 bg-light">
        <div class="container-fluid">
            <div class="row">
                <!-- Card Wrapper -->
                <div class="col-12">
                    <div class="card shadow-sm rounded-lg">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column: Issuance and Activities -->
                                <div class="col-lg-6 mb-4 mb-lg-0">
                                    <div class="card shadow-sm rounded-lg mb-4"
                                        style="max-width: 800px; margin: 0 auto;">
                                        <div class="card-body">
                                            <h5 class="fw-bold mb-4">
                                                <a href="{{ route('pdrrmo-home.issuances') }}" class="text-decoration-none">Issuance</a>
                                              </h5>
                                            <!-- Table with Scrollable Content -->
                                            <div class="table-responsive"
                                                style="max-height: 300px; overflow-y: auto;">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($files as $file)
                                                            <tr>
                                                                <td><strong>{{ $file->name }}</strong></td>
                                                                <td class="text-center">
                                                                    <a href="{{ Storage::url($file->path) }}"
                                                                        class="btn btn-primary btn-sm"
                                                                        target="_blank">
                                                                        <i class="fas fa-download"></i> Download
                                                                    </a>
                                                                    @auth
                                                                        <form
                                                                            action="{{ route('file.delete', $file->id) }}"
                                                                            method="POST" style="display:inline;"
                                                                            onsubmit="return confirm('Are you sure you want to delete this file?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger btn-sm">
                                                                                <i class="fas fa-trash-alt"></i> Delete
                                                                            </button>
                                                                        </form>
                                                                    @endauth
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            {{-- @auth
                                                <form action="{{ route('file.upload.submit') }}" method="POST" enctype="multipart/form-data" style="margin-top: 20px;">
                                                    @csrf
                                                    <div class="mt-3">
                                                        <label for="file-upload" class="form-label">Choose Files to Upload</label>
                                                        <input type="file" id="file-upload" name="file[]" class="form-control" multiple />
                                                    </div>
                                                    <div class="mt-3 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-upload"></i> Upload Files
                                                        </button>
                                                    </div>
                                                </form>
                                            @endauth --}}
                                        </div>
                                    </div>

                                    <div class="card shadow-sm rounded-lg mb-4"
                                        style="max-width: 800px; margin: 0 auto; position: relative;">
                                        <div class="card-body">
                                            <h5 class="fw-bold mb-4">Recent Activities</h5>
                                            <!-- Image Carousel Wrapper -->
                                            <div id="recentActivitiesCarousel" class="carousel slide"
                                                data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    <!-- Loop through the activities and their images -->
                                                    @foreach ($activities as $activity)
                                                        @foreach ($activity->images as $index => $image)
                                                            <div
                                                                class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                                <!-- Wrap the image in a clickable link -->
                                                                <a
                                                                    href="{{ route('activities.show', $activity->id) }}">
                                                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                                                        class="d-block w-100 carousel-img"
                                                                        alt="Activity {{ $loop->parent->iteration }} Image {{ $index + 1 }}">
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    @endforeach
                                                </div>
                                                <!-- Carousel Controls -->
                                                <button class="carousel-control-prev" type="button"
                                                    data-bs-target="#recentActivitiesCarousel" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon"
                                                        aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button"
                                                    data-bs-target="#recentActivitiesCarousel" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon"
                                                        aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                            <!-- End of Image Carousel Wrapper -->
                                        </div>

                                        @auth
                                            <!-- Buttons in the Bottom Right Corner with Padding -->
                                            <div class="position-absolute bottom-0 end-0 p-4 z-index-10">
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#activitiesUpload">
                                                        <i class="fas fa-plus-circle"></i> Add Photos
                                                    </button>
                                                {{-- <button type="button" class="btn btn-warning btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#activitiesUpload">
                                                    <i class="fas fa-edit"></i> Change Photos
                                                </button> --}}

                                                <!-- Button for Deleting Photos -->
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#activitiesDelete">
                                                        <i class="fas fa-trash-alt"></i> Delete Photos
                                                    </button>
                                            </div>
                                        @endauth
                                    </div>

                                    <!-- Modal for Uploading Multiple Photos -->
                                    <div class="modal fade" id="activitiesUpload" tabindex="-1"
                                        aria-labelledby="activitiesUploadLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="activitiesUploadLabel">Upload Activity
                                                        Images</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Upload Form -->
                                                    <form action="{{ route('activities.store') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" required>

                                                            <label for="description"
                                                                class="form-label">Description</label>
                                                            <textarea class="form-control" id="description" name="description"></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="image" class="form-label">Select
                                                                Images</label>
                                                            <input type="file" class="form-control" id="image"
                                                                name="images[]" multiple required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Upload
                                                            Images</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <!-- Modal for Deleting Photos -->
                                <div class="modal fade" id="activitiesDelete" tabindex="-1" aria-labelledby="activitiesDeleteLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="activitiesDeleteLabel">Delete Selected Photos</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete these images? This action cannot be undone.</p>
                                                <!-- Form for Deleting Images -->
                                                <form action="{{ route('activities.delete') }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        @foreach ($activities as $activity)
                                                            @foreach ($activity->images as $index => $image)
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="image_ids[]" value="{{ $image->id }}" id="deleteImage{{ $image->id }}">
                                                                    <label class="form-check-label" for="deleteImage{{ $image->id }}">
                                                                        <div class="image-container" style="text-align: center; display: flex; justify-content: center; align-items: center;">
                                                                            <img src="{{ asset('storage/' . $image->image_path) }}" style="max-width: 100%; height: auto; margin-bottom: 10px;" alt="Activity {{ $activity->id }} Image {{ $index + 1 }}">
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        @endforeach
                                                    </div>
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash-alt"></i> Delete Selected Photos
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                                    <div class="card shadow-sm rounded-lg w-100">
                                        <div class="card-body text-center">
                                            <h5 class="fw-bold mb-4">Latest Updates</h5>
                                            <div class="alert alert-warning fw-bold fs-6 mb-4" id="current-time">
                                            </div>
                                            <div class="fb-page"
                                                data-href="https://www.facebook.com/p/Operation-Center-Pdrrmo-Iloilo-61570456584511/"
                                                data-tabs="timeline" data-width="700" data-height="700"
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
                                @include('pdrrmo-home.featured-videos') 
                            </div>
                            @include('pdrrmo-home.links') 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</main>

    <script>
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
            // Get both date and time in desired format
            const dateString = now.toLocaleString('en-GB', options);
            document.getElementById('current-time').innerHTML = dateString;
        }
    
        // Initialize time update every second
        setInterval(updateTime, 1000);
        updateTime();
    
        // Function to display the welcome modal (if set in session)
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('welcome_message'))
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
    
        // Function to populate the image paths in the delete images container
        document.addEventListener('DOMContentLoaded', function () {
            // Ensure image_paths is an array even if it's null or undefined
            const images = @json($carouselImage && $carouselImage->image_paths ? $carouselImage->image_paths : []);
            const container = document.getElementById('deleteImagesContainer');
            const baseUrl = "{{ asset('storage/') }}";  // Base URL for images
    
            // Populate the delete image container with checkboxes for each image
            images.forEach(function (imagePath) {
                const imageDiv = document.createElement('div');
                imageDiv.classList.add('form-check');
                
                imageDiv.innerHTML = `
                    <input class="form-check-input" type="checkbox" value="${imagePath}" id="image-${imagePath}" name="image_paths[]">
                    <label class="form-check-label" for="image-${imagePath}">
                        <img src="${baseUrl}/${imagePath}" class="img-fluid mx-auto d-block" style="max-width: 50%; object-fit: contain;">
                    </label>
                `;
                
                container.appendChild(imageDiv);
            });
        });
    
        // Function to initialize the delete modal with selected image information
        function openDeleteModal(imagesToDelete) {
            const deleteImagesContainer = document.getElementById('deleteImagesContainer');
            deleteImagesContainer.innerHTML = '';  // Clear any previous selected images
    
            if (imagesToDelete.length === 0) {
                alert("No images selected to delete.");
                return;
            }
    
            // Create a list of selected images
            imagesToDelete.forEach(function(image) {
                const imageDiv = document.createElement('div');
                imageDiv.textContent = image;
                deleteImagesContainer.appendChild(imageDiv);
            });
    
            // Set the form action to delete the selected images
            const form = document.getElementById('carouselDeleteForm');
            form.action = '/carousel-image/delete'; // Modify this route as per your backend logic
        }
    
     

        function previewImage(event) {
            var reader = new FileReader();
            
            reader.onload = function() {
                var imagePreview = document.getElementById('imagePreview');
                
                imagePreview.src = reader.result;
                
                imagePreview.style.display = 'block';
            };
            
            reader.readAsDataURL(event.target.files[0]);
        }
        
        document.getElementById('deleteModal').addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; 
            var form = document.getElementById('delete-form');
        });

    </script>
    

<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v17.0"></script>

@endsection