@extends('layouts.app')

@section('content')

<div class="page-title accent-background py-4">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Rescue Operations</h1>
        <nav class="breadcrumbs">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('programs-services.rescue-operations.index') }}">Rescue Operations</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ ucwords(str_replace(['_', '-'], ' ', $category)) }}</li>
            </ol>
        </nav>
    </div>
</div>

@push('styles')
    <style>
        .uniform-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            object-position: center;
        }

        .album-image,
        .modal-body .col-md-4 {
            height: 250px;
        }

        .modal-body img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        @media (max-width: 767.98px) {
            .uniform-img,
            .album-image,
            .modal-body .col-md-4,
            .modal-body img {
                height: 180px;
            }
        }

        @media (max-width: 575.98px) {
            .uniform-img,
            .album-image,
            .modal-body .col-md-4,
            .modal-body img {
                height: 150px;
            }
        }
    </style>
@endpush

<section id="rescue-operation-album" class="rescue-operation-album section py-5">
    <div class="container">

        <h2 class="text-center mb-4">
            {{ ucwords(str_replace(['_', '-'], ' ', $category)) }}
        </h2>

        @if($latestRescueOperation = $rescueOperations->sortByDesc('created_at')->last())
            @if($latestRescueOperation->description)
                <!-- Inline style for black color on description -->
                <p class="lead text-center mb-5" style="color: black;">{{ $latestRescueOperation->description }}</p>
            @else
                <p class="text-center text-muted mb-5">No description available for this category.</p>
            @endif
        @else
            <p class="text-center text-muted mb-5">No rescue operations found for this category.</p>
        @endif

        @if($rescueOperations->count() > 0)
            @php
                $allImages = $rescueOperations->flatMap(function($operation) {
                    return is_array($operation->images) ? $operation->images : json_decode($operation->images, true);
                });
                $totalImages = $allImages->count();
                $remainingImages = $totalImages - 3;
            @endphp

            @if($totalImages > 0)
                <div class="row g-3 justify-content-center">
                    @foreach($allImages->take(3) as $index => $image)
                        <div class="col-12 col-sm-6 col-md-4 position-relative">
                            <div class="album-image" data-bs-toggle="modal" data-bs-target="#fullAlbumModal" style="cursor: pointer;">
                                <!-- Inline style to maintain uniform image size -->
                                <img src="{{ asset('storage/' . $image) }}" alt="Rescue Image" class="img-fluid rounded shadow-sm" style="width: 100%; height: 250px; object-fit: cover; object-position: center;" loading="lazy">

                                @if($index === 2 && $totalImages > 3)
                                    <!-- Inline style for white color on overlay -->
                                    <div class="more-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="color: white;">
                                        +{{ $remainingImages }} more
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-muted">No images available for this category.</p>
            @endif
        @else
            <p class="text-center text-muted">No rescue operations found for this category.</p>
        @endif

    </div>

    <!-- Full Album Modal -->
    <div class="modal fade" id="fullAlbumModal" tabindex="-1" aria-labelledby="fullAlbumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ ucwords(str_replace(['_', '-'], ' ', $category)) }} - Full Album</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        @foreach($allImages as $image)
                            <div class="col-12 col-sm-6 col-md-4">
                                <!-- Inline style to maintain uniform image size -->
                                <img src="{{ asset('storage/' . $image) }}" 
                                     alt="Rescue Image" 
                                     class="img-fluid rounded shadow-sm mb-2" 
                                     style="width: 100%; height: 250px; object-fit: cover; object-position: center;" 
                                     data-bs-toggle="modal" 
                                     data-bs-target="#imageModal" 
                                     data-bs-whatever="{{ asset('storage/' . $image) }}">

                                <a href="{{ asset('storage/' . $image) }}" 
                                   title="{{ ucwords(str_replace(['_', '-'], ' ', $category)) }}" 
                                   data-gallery="portfolio-gallery-{{ strtolower($category) }}" 
                                   class="glightbox preview-link">
                                    <i class="bi bi-zoom-in"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
