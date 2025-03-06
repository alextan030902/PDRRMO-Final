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



@extends('layouts.app')

@section('content')
<div class="container-fluid my-5">
    <div class="row g-4"> <!-- Added spacing between columns -->

        <!-- Internal Services Section -->
        <div class="col-lg-6 mb-4 mb-lg-0 d-flex flex-column">
            <div class="text-center mb-4">
                <h4 class="text-orange fw-bold display-6">INTERNAL SERVICES</h4> <!-- Larger font for internal services -->
            </div>
            <div class="card shadow-lg rounded-3 border-light">
                <div class="card-body">
                    <div class="accordion" id="internalServicesAccordion">
                        @if($files->isEmpty())
                            <p class="text-center text-muted">No files available.</p>
                        @else
                            @foreach ($files as $file)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $file->id }}">
                                        <button class="accordion-button btn-custom collapsed fs-5 fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $file->id }}" aria-expanded="false" aria-controls="collapse{{ $file->id }}">
                                            {{ $file->title }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $file->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $file->id }}" data-bs-parent="#internalServicesAccordion">
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
            
                                            <!-- Edit and Delete Buttons inside description -->
                                            <div class="d-flex justify-content-end mt-3">
                                                <!-- Edit Button -->
                                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $file->id }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
            
                                                <!-- Delete Button -->
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

        <!-- Disaster and Calamity Updates Section (no change) -->
        <div class="col-lg-6 d-flex justify-content-center align-items-center">
            <div class="card shadow-lg rounded-lg w-100 border-light">
                <div class="card-body text-center">
                    <h5 class="fw-bold mb-4 text-primary">LATEST UPDATES</h5>
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
                            <small>Current File: <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">{{ basename($file->file_path) }}</a></small>
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
                        <a href="#" data-bs-toggle="modal" data-bs-target="#uploadModal" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Change Photo
                        </a>
                        @if ($pdrrmo)
                            <form action="{{ route('pdrrmo-home.destroy', ['id' => $pdrrmo->id]) }}" method="POST" class="d-inline">
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
            @php
                // Fetch available images (ensure to replace this with your actual model logic)
                $images = $carouselImage ? $carouselImage->image_paths : [];
            @endphp
            
            @if (count($images) > 0)
                <!-- Carousel Indicators (only loop once for indicators) -->
                <ol class="carousel-indicators"></ol>

                <!-- Carousel Items (Images) -->
                @foreach ($images as $index => $image)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $image) }}" alt="Carousel Image {{ $index + 1 }}" loading="lazy">
                    </div>
                @endforeach

            @else
                <div class="carousel-item active">
                    <div class="no-image-placeholder">
                        <i class="fas fa-image fa-3x"></i>
                        <p>No Image Available</p>
                    </div>
                </div>
            @endif

            <!-- Carousel Controls -->
            <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>
    
            @auth
                <div class="position-absolute bottom-0 end-0 m-3 z-index-10">
                    @if (count($images) === 0)
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#carouselUpload">
                            <i class="fas fa-plus-circle"></i> Add Photos
                        </button>
                    @endif
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#carouselUpload">
                        <i class="fas fa-edit"></i> Change Photos
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#carouselDelete">
                        <i class="fas fa-trash-alt"></i> Delete Photos
                    </button>
                </div>
            @endauth
        </div>
    </section>
        
    <!-- Modal for uploading images for all carousel items -->
    <div class="modal fade" id="carouselDelete" tabindex="-1" aria-labelledby="carouselDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
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
                        <button type="submit" class="btn btn-danger">Delete Images</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
                      <div class="card shadow-sm rounded-lg mb-4" style="max-width: 800px; margin: 0 auto;">
                        <div class="card-body">
                          <h5 class="fw-bold mb-4">Issuance</h5> <!-- Table with Scrollable Content -->
                          <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-striped table-hover">
                              <thead>
                                <tr>
                                  <th>Name</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody> @foreach ($files as $file) <tr>
                                  <td><strong>{{ $file->name }}</strong></td>
                                  <td class="d-flex"> <a href="{{ Storage::url($file->path) }}" class="btn btn-primary btn-sm" target="_blank"> <i class="fas fa-download"></i> Download </a> @auth <form action="{{ route('file.delete', $file->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this file?');"> @csrf @method('DELETE') <button type="submit" class="btn btn-danger btn-sm"> <i class="fas fa-trash-alt"></i> Delete </button> </form> @endauth </td>
                                </tr> @endforeach </tbody>
                            </table>
                          </div> <!-- See More Button and Content below the Table --> @auth <form action="{{ route('file.upload.submit') }}" method="POST" enctype="multipart/form-data" style="margin-top: 20px;"> @csrf <div class="mt-3"> <label for="file-upload" class="form-label">Choose Files to Upload</label> <input type="file" id="file-upload" name="file[]" class="form-control" multiple /> </div>
                            <div class="mt-3"> <button type="submit" class="btn btn-primary w-100"> <i class="fas fa-upload"></i> Upload Files </button> </div>
                          </form> @endauth
                        </div>
                      </div>
                      <div class="card shadow-sm rounded-lg mb-4" style="max-width: 800px; margin: 0 auto; position: relative;">
                        <div class="card-body">
                          <h5 class="fw-bold mb-4">Recent Activities</h5> <!-- Image Carousel Wrapper -->
                          <div id="recentActivitiesCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                              <!-- Loop through the activities and their images --> @foreach ($activities as $activity) @foreach ($activity->images as $index => $image) <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <!-- Wrap the image in a clickable link --> <a href="{{ route('activities.show', $activity->id) }}"> <img src="{{ asset('storage/' . $image->image_path) }}" class="d-block w-100 carousel-img" alt="Activity {{ $loop->parent->iteration }} Image {{ $index + 1 }}"> </a>
                              </div> @endforeach @endforeach
                            </div> <!-- Carousel Controls --> <button class="carousel-control-prev" type="button" data-bs-target="#recentActivitiesCarousel" data-bs-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="visually-hidden">Previous</span> </button> <button class="carousel-control-next" type="button" data-bs-target="#recentActivitiesCarousel" data-bs-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="visually-hidden">Next</span> </button>
                          </div> <!-- End of Image Carousel Wrapper -->
                        </div> @auth
                        <!-- Buttons in the Bottom Right Corner with Padding -->
                        <div class="position-absolute bottom-0 end-0 p-4 z-index-10"> <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#activitiesUpload"> <i class="fas fa-plus-circle"></i> Add Photos </button> <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#activitiesUpload"> <i class="fas fa-edit"></i> Change Photos </button> <!-- Button for Deleting Photos --> <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#activitiesDelete"> <i class="fas fa-trash-alt"></i> Delete Photos </button> </div> @endauth
                      </div> <!-- Modal for Uploading Multiple Photos -->
                      <div class="modal fade" id="activitiesUpload" tabindex="-1" aria-labelledby="activitiesUploadLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="activitiesUploadLabel">Upload Activity Images</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <!-- Upload Form -->
                              <form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data"> @csrf <div class="mb-3"> <label for="title" class="form-label">Title</label> <input type="text" class="form-control" id="title" name="title" required> <label for="description" class="form-label">Description</label> <textarea class="form-control" id="description" name="description"></textarea> </div>
                                <div class="mb-3"> <label for="image" class="form-label">Select Images</label> <input type="file" class="form-control" id="image" name="images[]" multiple required> </div> <button type="submit" class="btn btn-primary">Upload Images</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div> <!-- Modal for Deleting Photos -->
                      <div class="modal fade" id="activitiesDelete" tabindex="-1" aria-labelledby="activitiesDeleteLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="activitiesDeleteLabel">Delete Selected Photos</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <!-- Form for Deleting Images -->
                              <form action="{{ route('activities.delete') }}" method="POST"> @csrf <div class="form-group"> @foreach ($activities as $activity) @foreach ($activity->images as $index => $image) <div class="form-check"> <input class="form-check-input" type="checkbox" name="image_ids[]" value="{{ $image->id }}" id="deleteImage{{ $image->id }}"> <label class="form-check-label" for="deleteImage{{ $image->id }}"> <img src="{{ asset('storage/' . $image->image_path) }}" width="100" alt="Activity {{ $activity->id }} Image {{ $index + 1 }}"> </label> </div> @endforeach @endforeach </div> <button type="submit" class="btn btn-danger btn-sm"> <i class="fas fa-trash-alt"></i> Delete Selected Photos </button> </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> <!-- Right Column: Disasters and Calamity Updates -->
                    <div class="col-lg-6 d-flex justify-content-center align-items-center">
                      <div class="card shadow-sm rounded-lg w-100">
                        <div class="card-body text-center">
                          <h5 class="fw-bold mb-4">Latest Updates</h5>
                          <div class="alert alert-warning fw-bold fs-6 mb-4" id="current-time">
                            <!-- Real-time date and time will be inserted here -->
                          </div>
                          <div class="fb-page" data-href="https://www.facebook.com/p/Operation-Center-Pdrrmo-Iloilo-61570456584511/" data-tabs="timeline" data-width="700" data-height="800" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false">
                            <blockquote cite="https://www.facebook.com/p/Operation-Center-Pdrrmo-Iloilo-61570456584511/" class="fb-xfbml-parse-ignore"> <a href="https://www.facebook.com/p/Operation-Center-Pdrrmo-Iloilo-61570456584511/">Your Page Name</a> </blockquote>
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
                              <div class="embed-responsive embed-responsive-ratio ratio-16x9"> <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/qqhLKMcV-4g" allowfullscreen></iframe> </div>
                            </div>
                          </div> <!-- Second iframe (Add another iframe here) -->
                          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                            <div class="service-item item-cyan position-relative">
                              <div class="embed-responsive embed-responsive-ratio ratio-16x9"> <iframe width="560" height="315" src="https://www.youtube.com/embed/Om93Fzu64Oo?si=Mdw9hj1sHsoO6_zr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> </div>
                            </div>
                          </div> <!-- Service Item with Icon -->
                          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                            <div class="service-item item-cyan position-relative">
                              <div class="embed-responsive embed-responsive-ratio ratio-16x9"> <iframe width="560" height="315" src="https://www.youtube.com/embed/oQYDHzkPXts?si=SQa-ZdcxnTAiJqoB" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> </div>
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

    document.addEventListener('DOMContentLoaded', function () {
            // Get the image paths from the server (passed via @json in Blade)
            const images = @json($carouselImage->image_paths);  // This will correctly encode the PHP array to JSON
            const container = document.getElementById('deleteImagesContainer');
            
            // Get the base URL for images
            const baseUrl = "{{ asset('storage/') }}";  // This will give you the correct storage URL in Blade

            images.forEach(function (imagePath) {
                const imageDiv = document.createElement('div');
                imageDiv.classList.add('form-check');
                
                // Use template literals for the HTML inside the div, with proper image URL concatenation
                imageDiv.innerHTML = `
                    <input class="form-check-input" type="checkbox" value="${imagePath}" id="image-${imagePath}" name="image_paths[]">
                    <label class="form-check-label" for="image-${imagePath}">
                        <img src="${baseUrl}/${imagePath}" class="img-thumbnail" width="100">
                        ${imagePath}
                    </label>
                `;
                
                // Append the div to the container
                container.appendChild(imageDiv);
            });
        });

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

        setInterval(updateTime, 1000); 
        updateTime(); 

        

    // Function to initialize the delete modal with selected image information
    function openDeleteModal(imagesToDelete) {
        // Clear the previous selected images
        const deleteImagesContainer = document.getElementById('deleteImagesContainer');
        deleteImagesContainer.innerHTML = '';

        if (imagesToDelete.length === 0) {
            alert("No images selected to delete.");
            return;
        }

        // Create list of selected images
        imagesToDelete.forEach(function(image) {
            const imageDiv = document.createElement('div');
            imageDiv.textContent = image;
            deleteImagesContainer.appendChild(imageDiv);
        });

        // Set the form action to delete the selected images
        const form = document.getElementById('carouselDeleteForm');
        form.action = '/carousel-image/delete'; // Modify this route as per your backend logic
    }
    
        // Example usage: Call this function when the delete button is clicked
        // openDeleteModal(['image1.jpg', 'image2.jpg']);
    </script>

    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v17.0"></script>
@endsection




            <!-- Banner Section -->
            <style>
                .masthead img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    /* Ensures full coverage without white bars */
                }

                @media (max-width: 480px) {
                    .masthead {
                        min-height: 30vh;
                    }
                }
            </style>

            <header class="masthead mb-2 position-relative">
                @if ($pdrrmoImagePath)
                    <img src="{{ asset('storage/' . $pdrrmoImagePath) }}" alt="Masthead Image" class="w-100 h-100">
                @else
                    <div class="text-center text-warning d-flex justify-content-center align-items-center h-100">
                        <i class="fas fa-upload fa-3x"></i>
                        <p class="mt-2">No image available. Please upload a banner.</p>
                    </div>
                @endif              @auth
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
                            <form action="{{ route('pdrrmo-home.destroy', ['id' => $pdrrmo->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        @endif
                    </div>
                @endauth
            </header>

               <!-- Hero Section -->
               <section class="carousel-section position-relative">
                @php
                    // Fetch available images (ensure to replace this with your actual model logic)
                    $images = $carouselImage ? $carouselImage->image_paths : [];
                @endphp
            
                @if (count($images) > 0)
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                        <!-- Carousel Indicators -->
                        <div class="carousel-indicators">
                            @foreach ($images as $index => $image)
                                <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="{{ $index }}" 
                                    class="{{ $index === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $index + 1 }}">
                                </button>
                            @endforeach
                        </div>
            
                        <!-- Carousel Inner -->
                        <div class="carousel-inner">
                            @foreach ($images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" alt="Carousel Image {{ $index + 1 }}" loading="lazy">
                                </div>
                            @endforeach
                        </div>
            
                        <!-- Carousel Controls -->
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
                    <div class="carousel slide" id="carouselExample">
                        <div class="carousel-inner">
                            <div class="carousel-item active text-center p-5">
                                <i class="fas fa-image fa-3x"></i>
                                <p>No Image Available</p>
                            </div>
                        </div>
                    </div>
                @endif
            
                @auth
                    <div class="position-absolute bottom-0 end-0 m-3 z-index-10">
                        @if (count($images) === 0)
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
            </section>

            <div class="page-title accent-background py-4">
                <div class="container d-lg-flex justify-content-between align-items-center">
                    <h1 class="mb-2 mb-lg-0">Contact Details</h1>
                    <nav class="breadcrumbs">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('pdrrmo.index') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Contact Details</li>
                        </ol>
                    </nav>
                </div>
            </div><!-- End Page Title -->
            
            
            <div class="container mt-5 position-relative">
                <h1 class="text-center" style="color: #003489; margin-bottom: 16px;">CONTACT DETAILS</h1>
                
                @auth
                    <button type="button" class="btn btn-primary position-absolute top-0 start-0 m-3" data-bs-toggle="modal" data-bs-target="#addRowModal">
                        <i class="bi bi-person-plus"></i> Add Contact
                    </button>
                @endauth
            
                <!-- Category Filter in Top Right Corner -->
                <div class="position-absolute top-0 end-0 m-3" style="right: 120px;">
                    <form method="GET" action="{{ route('contact.index') }}" id="filterForm">
                        <div class="input-group">
                            <select name="category" class="form-select" id="categoryFilter" onchange="document.getElementById('filterForm').submit()">
                                <option value="">Select Category</option>
                                <option value="MDRRMO" {{ request()->category == 'MDRRMO' ? 'selected' : '' }}>MDRRMO</option>
                                <option value="HOSPITALS" {{ request()->category == 'HOSPITALS' ? 'selected' : '' }}>HOSPITALS</option>
                                <option value="IPPO" {{ request()->category == 'IPPO' ? 'selected' : '' }}>IPPO</option>
                                <option value="BFP" {{ request()->category == 'BFP' ? 'selected' : '' }}>BFP</option>
                            </select>
                            <button type="submit" class="btn btn-info" style="display:none;">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>
{{--                 

                @extends('layouts.app')

                @section('content')
                
                <div class="page-title accent-background py-4">
                    <div class="container d-lg-flex justify-content-between align-items-center">
                        <h1 class="mb-2 mb-lg-0">Issuances</h1>
                        <nav class="breadcrumbs">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('pdrrmo.index') }}" class="text-decoration-none">Home</a>
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
                        <select class="form-select w-auto" id="yearSelect" name="year">
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
                
                <!-- Issuances List and Other Content -->
                <div class="container mt-5">
                    <div class="row">
                        <!-- Memo Container -->
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Memo</h5>
                                </div>
                                <div class="card-body">
                                    @foreach ($memos as $index => $memo)
                                        <div class="d-flex align-items-center justify-content-between mb-2 memo-item {{ $index >= 10 ? 'd-none' : '' }}">
                                            <a href="{{ asset('storage/' . $memo->path) }}" target="_blank" class="mr-3 text-decoration-none text-dark">{{ $memo->name }}</a>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $memo->id }}" data-name="{{ $memo->name }}">
                                                <i class="fas fa-trash-alt me-2"></i> Delete
                                            </button>
                                        </div>
                                    @endforeach
                
                                    @if($memos->count() > 10)
                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm see-more" data-type="memo">See More</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                
                        <!-- Executive Order Container -->
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Executive Order</h5>
                                </div>
                                <div class="card-body">
                                    @foreach ($executiveOrders as $index => $order)
                                        <div class="d-flex align-items-center justify-content-between mb-2 executive-order-item {{ $index >= 10 ? 'd-none' : '' }}">
                                            <a href="{{ asset('storage/' . $order->path) }}" target="_blank" class="mr-3 text-decoration-none text-dark">{{ $order->name }}</a>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $order->id }}" data-name="{{ $order->name }}">
                                                <i class="fas fa-trash-alt me-2"></i> Delete
                                            </button>
                                        </div>
                                    @endforeach
                
                                    @if($executiveOrders->count() > 10)
                                        <a href="javascript:void(0);" class="btn btn-success btn-sm see-more" data-type="executive-order">See More</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        <!-- Resolution Container -->
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Resolution</h5>
                                </div>
                                <div class="card-body">
                                    @foreach ($resolutions as $index => $resolution)
                                        <div class="d-flex align-items-center justify-content-between mb-2 resolution-item {{ $index >= 10 ? 'd-none' : '' }}">
                                            <a href="{{ asset('storage/' . $resolution->path) }}" target="_blank" class="mr-3 text-decoration-none text-dark">{{ $resolution->name }}</a>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $resolution->id }}" data-name="{{ $resolution->name }}">
                                                <i class="fas fa-trash-alt me-2"></i> Delete
                                            </button>
                                        </div>
                                    @endforeach
                
                                    @if($resolutions->count() > 10)
                                        <a href="javascript:void(0);" class="btn btn-info btn-sm see-more" data-type="resolution">See More</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                
                        <!-- Advisories Container -->
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="mb-0">Advisories</h5>
                                </div>
                                <div class="card-body">
                                    @foreach ($advisories as $index => $advisory)
                                        <div class="d-flex align-items-center justify-content-between mb-2 advisory-item {{ $index >= 10 ? 'd-none' : '' }}">
                                            <a href="{{ asset('storage/' . $advisory->path) }}" target="_blank" class="mr-3 text-decoration-none text-dark">{{ $advisory->name }}</a>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $advisory->id }}" data-name="{{ $advisory->name }}">
                                                <i class="fas fa-trash-alt me-2"></i> Delete
                                            </button>
                                        </div>
                                    @endforeach
                
                                    @if($advisories->count() > 10)
                                        <a href="javascript:void(0);" class="btn btn-warning btn-sm see-more" data-type="advisory">See More</a>
                                    @endif
                                </div>
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
                
                        // Construct the URL with the selected year as a query parameter
                        var url = new URL(window.location.href);
                        url.searchParams.set('year', selectedYear);
                
                        // Redirect to the updated URL to filter the results
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
                 --}}