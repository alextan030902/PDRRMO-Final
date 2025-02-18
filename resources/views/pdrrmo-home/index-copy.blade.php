@extends('layouts.app')

@section('content')


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
        <section id="hero" class="hero section dark-background" style="margin-bottom: 30px;">
            <div id="heroes-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="2000">
                <div class="carousel-item active">
                    @if ($pdrrmoImagePath)
                        <img src="{{ asset('storage/' . $pdrrmoImagePath) }}" alt="Banner Image" class="banner-image img-fluid">
                    @else
                        <div class="d-flex justify-content-center align-items-center" style="height: 100%; background-color: #090909;">
                            <div class="text-center">
                                <i class="fas fa-upload fa-3x text-warning"></i>
                                <p class="mt-2 text-warning">No image available. Please upload a banner.</p>
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
                            <a href="#" data-bs-toggle="modal" data-bs-target="#uploadModal"
                                class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Change Photo
                            </a>
                            @if ($pdrrmo)
                                <form action="{{ route('pdrrmo-home.destroy', ['id' => $pdrrmo->id]) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endauth
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

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">
            <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
                <!-- First Carousel Item -->
                @if ($carouselImage1)
                    <div class="carousel-item active">
                        <img src="{{ asset('storage/' . $carouselImage1) }}" alt="Carousel Image 1" loading="lazy">
                    </div>
                @else
                    <div class="carousel-item active">
                        <div class="no-image-placeholder">
                            <i class="fas fa-image fa-3x"></i>
                            <p>No Image Available</p>
                        </div>
                    </div>
                @endif
                <!-- Second Carousel Item -->
                @if ($carouselImage2)
                    <div class="carousel-item">
                        <img src="{{ asset('storage/' . $carouselImage2) }}" alt="Carousel Image 2" loading="lazy">
                    </div>
                @else
                    <div class="carousel-item">
                        <div class="no-image-placeholder">
                            <i class="fas fa-image fa-3x"></i>
                            <p>No Image Available</p>
                        </div>
                    </div>
                @endif
                <!-- Third Carousel Item -->
                @if ($carouselImage3)
                    <div class="carousel-item">
                        <img src="{{ asset('storage/' . $carouselImage3) }}" alt="Carousel Image 3" loading="lazy">
                    </div>
                @else
                    <div class="carousel-item">
                        <div class="no-image-placeholder">
                            <i class="fas fa-image fa-3x"></i>
                            <p>No Image Available</p>
                        </div>
                    </div>
                @endif
                <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
                </a>
                <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
                </a>
                @auth
                    <div class="position-absolute bottom-0 end-0 m-3 z-index-10">
                        @if (!$carouselImage1 && !$carouselImage2 && !$carouselImage3)
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#carouselUpload">
                                <i class="fas fa-plus-circle"></i> Add Photos
                            </button>
                        @endif
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#carouselUpload">
                            <i class="fas fa-edit"></i> Change Photos
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#carouselDelete">
                            <i class="fas fa-trash-alt"></i> Delete Photos
                        </button>
                    </div>
                @endauth
                <ol class="carousel-indicators"></ol>
            </div>
        </section>
        <!-- Modal -->
        <div class="modal fade" id="carouselDelete" tabindex="-1" aria-labelledby="carouselDeleteLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="carouselDeleteLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Select an image to delete:</p>
                        <!-- Image 1 -->
                        @if ($carouselImage1)
                            <div class="mb-3">
                                <img src="{{ asset($carouselImage1) }}" alt="Image 1" class="img-thumbnail"
                                    width="100">
                                <button type="button" class="btn btn-danger btn-sm delete-image" data-image-index="1">
                                    Delete Image 1
                                </button>
                            </div>
                        @endif
                        <!-- Image 2 -->
                        @if ($carouselImage2)
                            <div class="mb-3">
                                <img src="{{ asset($carouselImage2) }}" alt="Image 2" class="img-thumbnail"
                                    width="100">
                                <button type="button" class="btn btn-danger btn-sm delete-image" data-image-index="2">
                                    Delete Image 2
                                </button>
                            </div>
                        @endif
                        <!-- Image 3 -->
                        @if ($carouselImage3)
                            <div class="mb-3">
                                <img src="{{ asset($carouselImage3) }}" alt="Image 3" class="img-thumbnail"
                                    width="100">
                                <button type="button" class="btn btn-danger btn-sm delete-image" data-image-index="3">
                                    Delete Image 3
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Form for Deleting Image -->
        <form id="deleteImageForm" action="{{ route('carousel.destroy', ['imageIndex' => 1]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" style="display:none;" id="deleteImageButton"></button>
        </form>
        <!-- Modal for uploading images for all carousel items -->
        <div class="modal fade" id="carouselUpload" tabindex="-1" aria-labelledby="carouselUploadLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="carouselUploadLabel">Upload Images for Carousel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('carousel-image.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Image 1 -->
                            <div class="mb-3">
                                <label for="carouselImage1" class="form-label">Choose Image for Carousel 1</label>
                                <input type="file" class="form-control" id="carouselImage1" name="image_1"
                                    accept="image/*" required>
                            </div>
                            <!-- Image 2 -->
                            <div class="mb-3">
                                <label for="carouselImage2" class="form-label">Choose Image for Carousel 2</label>
                                <input type="file" class="form-control" id="carouselImage2" name="image_2"
                                    accept="image/*" required>
                            </div>
                            <!-- Image 3 -->
                            <div class="mb-3">
                                <label for="carouselImage3" class="form-label">Choose Image for Carousel 3</label>
                                <input type="file" class="form-control" id="carouselImage3" name="image_3"
                                    accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload All</button>
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
                                                <h5 class="fw-bold mb-4">Issuance</h5>

                                                <!-- Table with Scrollable Content -->
                                                <div class="table-responsive"
                                                    style="max-height: 300px; overflow-y: auto;">
                                                    <table class="table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($files as $file)
                                                                <tr>
                                                                    <td><strong>{{ $file->name }}</strong></td>
                                                                    <td class="d-flex">
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

                                                <!-- See More Button and Content below the Table -->
                                                @auth
                                                    <form action="{{ route('file.upload.submit') }}" method="POST"
                                                        enctype="multipart/form-data" style="margin-top: 20px;">
                                                        @csrf
                                                        <div class="mt-3">
                                                            <label for="file-upload" class="form-label">Choose Files to
                                                                Upload</label>
                                                            <input type="file" id="file-upload" name="file[]"
                                                                class="form-control" multiple />
                                                        </div>
                                                        <div class="mt-3">

                                                            <button type="submit" class="btn btn-primary w-100">
                                                                <i class="fas fa-upload"></i> Upload Files
                                                            </button>
                                                        </div>
                                                    </form>
                                                @endauth
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
                                                    @if ($carouselImages->isEmpty())
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#activitiesUpload">
                                                            <i class="fas fa-plus-circle"></i> Add Photos
                                                        </button>
                                                    @endif
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#activitiesUpload">
                                                        <i class="fas fa-edit"></i> Change Photos
                                                    </button>

                                                    <!-- Button for Deleting Photos -->
                                                    @if (!$carouselImages->isEmpty())
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#activitiesDelete">
                                                            <i class="fas fa-trash-alt"></i> Delete Photos
                                                        </button>
                                                    @endif
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
                                        <div class="modal fade" id="activitiesDelete" tabindex="-1"
                                            aria-labelledby="activitiesDeleteLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="activitiesDeleteLabel">Delete Selected
                                                            Photos</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Form for Deleting Images -->
                                                        <form action="{{ route('activities.delete') }}" method="POST">
                                                            @csrf
                                                            <div class="form-group">
                                                                @foreach ($activities as $activity)
                                                                    @foreach ($activity->images as $index => $image)
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" name="image_ids[]"
                                                                                value="{{ $image->id }}"
                                                                                id="deleteImage{{ $image->id }}">
                                                                            <label class="form-check-label"
                                                                                for="deleteImage{{ $image->id }}">
                                                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                                                    width="100"
                                                                                    alt="Activity {{ $activity->id }} Image {{ $index + 1 }}">
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

                                    <!-- Right Column: Disasters and Calamity Updates -->
                                    <div class="col-lg-6 d-flex justify-content-center align-items-center">
                                        <div class="card shadow-sm rounded-lg w-100">
                                            <div class="card-body text-center">
                                                <h5 class="fw-bold mb-4">Latest Updates</h5>
                                                <div class="alert alert-warning fw-bold fs-6 mb-4" id="current-time">
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

                                    <section id="services" class="services section light-background">
                                        <div class="container section-title" data-aos="fade-up">
                                            <h2>Featured Videos</h2>
                                          </div><!-- End Section Title -->
                                        <div class="container">
                                  
                                            <div class="row gy-4">
  
                                                <!-- First iframe -->
                                                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                                                  <div class="service-item item-cyan position-relative">
                                                    <div class="embed-responsive embed-responsive-ratio ratio-16x9">
                                                      <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/qqhLKMcV-4g" allowfullscreen></iframe>
                                                    </div>
                                                  </div>
                                                </div>
                                                
                                                <!-- Second iframe (Add another iframe here) -->
                                                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                                                  <div class="service-item item-cyan position-relative">
                                                    <div class="embed-responsive embed-responsive-ratio ratio-16x9">
                                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/Om93Fzu64Oo?si=Mdw9hj1sHsoO6_zr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                                    </div>
                                                  </div>
                                                </div>
                                              
                                                <!-- Service Item with Icon -->
                                                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                                                    <div class="service-item item-cyan position-relative">
                                                      <div class="embed-responsive embed-responsive-ratio ratio-16x9">
                                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/oQYDHzkPXts?si=SQa-ZdcxnTAiJqoB" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                                      </div>
                                                    </div>
                                                  </div>
                                              </div>
                                        </div>
                                      </section><!-- /Services Section -->

                                </div>
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
            // Get both date and time
            const dateString = now.toLocaleString('en-GB', options);
            document.getElementById('current-time').innerHTML = dateString;
        }

        setInterval(updateTime, 1000); // Update every second
        updateTime(); // Initial call to set the time immediately

        // Trigger modal and toast notifications when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Show Welcome Modal (if set in session)
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

        })

        // Function to show the preview of the new selected image
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');
            const currentImagePreview = document.getElementById('currentImagePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.style.display = 'block';
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }

        // Handle image delete action
        $('.delete-image').on('click', function() {
            var imageIndex = $(this).data('image-index');
            var actionUrl = '/carousel/destroy/' + imageIndex;

            $('#deleteImageForm').attr('action', actionUrl);
            $('#deleteImageButton').click();
        });

        Upload Button Click
        $('#uploadBtn').on('click', function() {
            var formData = new FormData();
            var files = $('#file-upload')[0].files;

            // Check if files are selected
            if (files.length > 0) {
                for (var i = 0; i < files.length; i++) {
                    formData.append('file[]', files[i]);
                }

                // Send AJAX request
                $.ajax({
                    url: "{{ route('file.upload.submit') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert(response.message);
                        $('#uploadFileModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        alert('File upload failed: ' + error);
                    }
                });
            } else {
                alert('Please select a file to upload.');
            }
        });
    </script>
    <!-- Facebook SDK (for integration) -->
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v17.0"></script>

@endsection



@extends('layouts.app')

@section('content')
<div class="container mt-5 position-relative">
    <h1 class="text-center" style="color: #003489; margin-bottom: 1rem;">MDRRMO CONTACT DETAILS</h1>
    @auth
        <button type="button" class="btn btn-primary position-absolute" style="top: 10px; right: 10px;" data-bs-toggle="modal" data-bs-target="#addRowModal">
            <i class="bi bi-person-plus"></i> Add Contact
        </button>
    @endauth

    <!-- Table to display contacts -->
    <table class="table table-bordered border-info">
        <thead class="text-center">
            <tr>
                {{-- <th scope="col">Category</th> --}}
                <th scope="col">District</th>
                <th scope="col">Municipality</th>
                <th scope="col">Focal Person</th>
                <th scope="col">Contact Number</th>
                <th scope="col">Email</th>
                <th scope="col">Response Team</th>
                @auth
                    <th scope="col">Actions</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @if($contacts->isEmpty())
                <tr>
                    <td colspan="{{ Auth::check() ? '7' : '6' }}" class="text-center">No contacts available</td>
                </tr>
            @else
                @php
                    // Group contacts by district and then sort them numerically
                    $contactsByDistrict = $contacts->groupBy('district')->sortKeys();
                @endphp
    
                @foreach($contactsByDistrict as $district => $districtContacts)
                    <tr>
                        <td colspan="{{ Auth::check() ? '7' : '6' }}" class="text-center bg-light"><strong>{{ $district }}</strong></td>
                    </tr>
                    
                    @php
                        // Sort the municipalities alphabetically
                        $districtContacts = $districtContacts->sortBy('municipality');
                    @endphp
    
                    @foreach($districtContacts as $contact)
                        <tr class="text-center">
                            {{-- <td>{{ $contact->category }}</td> --}}
                            <td>{{ $contact->district }}</td>
                            <td>{{ $contact->municipality }}</td>
                            <td>{{ $contact->focal_person }}</td>
                            <td>{{ $contact->contact_number }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->response_team }}</td>
                            @auth
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editContactModal" data-id="{{ $contact->id }}">
                                        <i class="fa fa-pencil-alt"></i> Edit
                                    </a>
                                    <form action="{{ route('contact.destroy', $contact->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            @endauth
                        </tr>
                    @endforeach
                @endforeach
            @endif
        </tbody>
    </table>

    <!-- Modal for adding contact -->
    <div class="modal fade" id="addRowModal" tabindex="-1" aria-labelledby="addRowModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRowModalLabel">Add New Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="category" class="col-sm-4 col-form-label">Category</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="category" name="category" required>
                                    <option value="" disabled selected>Select a category</option>
                                    <option value="MDRRMO">MDRRMO</option>
                                    <option value="HOSPITALS">HOSPITALS</option>
                                    <option value="IPPO">IPPO</option>
                                    <option value="BFP">BFP</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="district" class="col-sm-4 col-form-label">District</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="district" name="district" required>
                                    <option value="" disabled selected>Select a district</option>
                                    <option value="1st District">1st District</option>
                                    <option value="2nd District">2nd District</option>
                                    <option value="3rd District">3rd District</option>
                                    <option value="4th District">4th District</option>
                                    <option value="5th District">5th District</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="municipality" class="col-sm-4 col-form-label">Municipality</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="municipality" name="municipality" required>
                                    <option value="" disabled selected>Select a municipality</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="focal_person" class="col-sm-4 col-form-label">DRRM Office/ Focal Person</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="focal_person" name="focal_person" required>
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <label for="contact_number" class="col-sm-4 col-form-label">Contact Number</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <label for="email" class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <label for="response_team" class="col-sm-4 col-form-label">Local Response Team</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="response_team" name="response_team" required>
                            </div>
                        </div>
    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> 
                                <i class="bi bi-x-circle"></i> Close
                            </button>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editContactModal" tabindex="-1" aria-labelledby="editContactModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editContactModalLabel">Edit Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('contact.update', $contact->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Add hidden input to hold the contact ID -->
                        <input type="hidden" id="editContactId" name="id">
                        
                        <div class="row mb-3">
                            <label for="edit_category" class="col-sm-4 col-form-label">Category</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_category" name="category" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="edit_district" class="col-sm-4 col-form-label">District</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_district" name="district" required>
                            </div>
                        </div>
                    
                        <div class="row mb-3">
                            <label for="edit_municipality" class="col-sm-4 col-form-label">Municipality</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_municipality" name="municipality" required>
                            </div>
                        </div>
                    
                        <div class="row mb-3">
                            <label for="edit_focal_person" class="col-sm-4 col-form-label">Focal Person</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_focal_person" name="focal_person" required>
                            </div>
                        </div>
                    
                        <div class="row mb-3">
                            <label for="edit_contact_number" class="col-sm-4 col-form-label">Contact Number</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_contact_number" name="contact_number" required>
                            </div>
                        </div>
                    
                        <div class="row mb-3">
                            <label for="edit_email" class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="edit_email" name="email" required>
                            </div>
                        </div>
                    
                        <div class="row mb-3">
                            <label for="edit_response_team" class="col-sm-4 col-form-label">Response Team</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_response_team" name="response_team" required>
                            </div>
                        </div>
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle"></i> Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const municipalities = {
    "1st District": ["Igbaras Iloilo", "Guimbal Iloilo", "Miag-ao Iloilo", "Oton Iloilo", "Tigbauan Iloilo", "Tubungan Iloilo", "San Joaquin Iloilo"],
    "2nd District": ["Alimodian Iloilo", "Leganes Iloilo", "Leon Iloilo", "New Lucena Iloilo", "Pavia Iloilo", "San Miguel Iloilo", "Sta. Barbara Iloilo", "Zarraga Iloilo"],
    "3rd District": ["Badiangan Iloilo", "Bingawan Iloilo", "Cabatuan Iloilo", "Calinog Iloilo", "Janiuay Iloilo", "Lambunao Iloilo", "Maasin Iloilo", "Mina Iloilo", "Pototan Iloilo"],
    "4th District": ["Anilao Iloilo", "Banate Iloilo", "Barotac Nuevo Iloilo", "Dingle Iloilo", "Duenas Iloilo", "Dumangas Iloilo", "Passi Iloilo", "San Enrique Iloilo"],
    "5th District": ["Ajuy Iloilo", "Balasan Iloilo", "Barotac Viejo Iloilo", "Batad Iloilo", "Carles Iloilo", "Concepcion Iloilo", "Estancia Iloilo", "Lemery Iloilo", "San Dionisio Iloilo", "San Rafael Iloilo", "Sara Iloilo"]
};

    document.getElementById("district").addEventListener("change", function() {
        const district = this.value;
        const municipalitySelect = document.getElementById("municipality");

        // Clear previous options
        municipalitySelect.innerHTML = '<option value="" disabled selected>Select a municipality</option>';

        // Populate new options
        if (municipalities[district]) {
            municipalities[district].forEach(municipality => {
                const option = document.createElement("option");
                option.value = municipality;
                option.textContent = municipality;
                municipalitySelect.appendChild(option);
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Select all edit buttons
        const editButtons = document.querySelectorAll('.edit-btn');

        // Attach click event listener to each edit button
        editButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                // Get the contact ID from the data-id attribute
                const contactId = event.target.getAttribute('data-id');
                
                // Get the closest <tr> element to extract data for the fields
                const row = event.target.closest('tr');
                const category = row.querySelector('td:nth-child(1)').innerText; // District
                const district = row.querySelector('td:nth-child(2)').innerText; // District
                const municipality = row.querySelector('td:nth-child(3)').innerText; // Municipality
                const focalPerson = row.querySelector('td:nth-child(4)').innerText; // Focal Person
                const contactNumber = row.querySelector('td:nth-child(5)').innerText; // Contact Number
                const email = row.querySelector('td:nth-child(6)').innerText; // Email
                const responseTeam = row.querySelector('td:nth-child(7)').innerText; // Response Team

                // Fill the modal form fields with this data
                document.getElementById('edit_category').value = category;
                document.getElementById('edit_district').value = district;
                document.getElementById('edit_municipality').value = municipality;
                document.getElementById('edit_focal_person').value = focalPerson;
                document.getElementById('edit_contact_number').value = contactNumber;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_response_team').value = responseTeam;

                // Optionally, store the contactId in a hidden input for submitting the correct ID with the form
                document.getElementById('editContactId').value = contactId;
            });
        });
    });

    function confirmDelete() {
        return confirm('Are you sure you want to delete this contact?');
    }

</script>

@endsection
