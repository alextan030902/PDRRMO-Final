@extends('layouts.app')

@section('content')

<div class="page-title accent-background py-4">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Rescue Operation</h1>
        <nav class="breadcrumbs">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('pdrrmo.index') }}">
                        <i class="fas fa-home"></i> Home
                      </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Rescue Operation</li>
            </ol>
        </nav>
    </div>
</div>

<section id="portfolio" class="portfolio section position-relative">

    @auth
        <button type="button" class="btn btn-primary position-absolute top-0 end-0 m-3" data-bs-toggle="modal" data-bs-target="#addImageModal">
            <i class="fas fa-plus"></i> Add Image
        </button>
    @endauth

    <!-- Add Image Modal -->
    <div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('programs-services.rescue-operations.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="flood">Flood</option>
                                <option value="fire-incidence">Fire Incidence</option>
                                <option value="vehicular-accident">Vehicular Accident</option>
                                <option value="trauma-case">Trauma Case</option>
                                <option value="retrieval-operation">Retrieval Operation</option>
                                <option value="standby-medic">Standby Medic</option>
                                <option value="standard_operative_procedure">Standard Operating Procedure</option>
                                <option value="early-warning">Early Warning System</option>
                            </select>
                            @error('category')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
    
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="mb-3">
                            <label for="images" class="form-label">Upload Images</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple required>
                            @error('images')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save
                          </button>
                          
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">

        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="d-grid gap-2">
                    @if(isset($categories) && !empty($categories))
                        @foreach($categories as $category)
                            @if(!empty($category->category)) 
                                <a href="{{ route('programs-services.rescue-operations.show', ['category' => $category->category]) }}" class="btn" style="background-color: #003489; color: white;">
                                    {{ ucwords(str_replace(['_', '-'], ' ', $category->category)) }}
                                </a>
                            @endif
                        @endforeach
                    @else
                        <p>No categories available.</p>
                    @endif
                </div>
            </div>
        
            <div class="col-md-8">
                <div class="card shadow-lg"> 
                    <div class="card-body d-flex flex-column" style="height: 200%;">
                        <div id="content" class="text-center flex-grow-1">
                            <h2 class="mb-4">Iloilo Rescue Operation</h2> 
                            @if($rescueOperation && $rescueOperation->content)
                                <p>{{ $rescueOperation->content }}</p>
                            @else
                                @php
                                    $latestContent = \App\Models\RescueOperation::whereNotNull('content')->latest()->first();
                                @endphp
                                @if($latestContent)
                                    <p>{{ $latestContent->content }}</p>
                                @else
                                    <p>No content available at the moment.</p>
                                @endif
                            @endif
                        </div>
                     @auth
                        <div class="btn-group mt-3 flex-shrink-0" role="group" aria-label="Action Buttons">
                            {{-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="fas fa-plus"></i> Add
                            </button> --}}
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('programs-services.rescue-operations.destroy', $rescueOperation->id) }}" method="POST" style="display: inline;" id="deleteForm">
                                @csrf
                                @method('DELETE')
                                @auth
                                <button type="button" class="btn btn-danger btn-sm" {{ $rescueOperation ? '' : 'disabled' }} data-toggle="modal" data-target="#deleteModal">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                                @endauth
                            </form>
                        </div>
                     @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Content</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm" action="{{ route('programs-services.rescue-operations.content') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="addContent" class="form-label">Content</label>
                                <textarea class="form-control" id="addContent" name="content" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Close
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" 
            action="{{ $rescueOperation ? route('programs-services.rescue-operations.update', $rescueOperation->id) : '#' }}">
            @csrf
            @method('PUT')

            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Content</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editDescription" class="form-label">Content</label>
                                <textarea class="form-control" id="editDescription" name="content" rows="10" required>
                                    {{ old('description', optional($rescueOperation)->content) }}
                                </textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Close
                            </button>
                        
                            <button type="submit" class="btn btn-primary" {{ $rescueOperation ? '' : 'disabled' }}>
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>

        <div class="isotope-layout mt-5">
            <ul class="portfolio-filters isotope-filters d-flex justify-content-center align-items-center mb-4" data-aos="fade-up" data-aos-delay="100">
                <li data-filter="*" class="filter-active">All</li>
                @foreach($categories as $category)
                    @php
                        $hasOperations = $rescueOperations->filter(function ($operation) use ($category) {
                            return $operation->category === $category->category && $operation->images && isset($operation->images[0]);
                        })->isNotEmpty();
                    @endphp
            
                    @if($hasOperations)
                        <li data-filter=".filter-{{ strtolower($category->category) }}">
                            {{ ucwords(str_replace(['_', '-'], ' ', $category->category)) }}
                        </li>
                    @endif
                @endforeach
            </ul>
        
            <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
                @foreach($rescueOperations as $operation)
                    @if($operation->images && isset($operation->images[0]))
                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-{{ strtolower($operation->category) }}">
                            <img src="{{ asset('storage/' . $operation->images[0]) }}" class="img-fluid" alt="{{ $operation->category }}">
                            <div class="portfolio-info" style="display: flex; align-items: center; justify-content: space-between;">
                                <h4>{{ ucwords(str_replace(['_', '-'], ' ', $operation->category)) }}</h4>
                            
                                <a href="{{ asset('storage/' . $operation->images[0]) }}" 
                                   title="{{ ucwords(str_replace(['_', '-'], ' ', $operation->category)) }}" 
                                   data-gallery="portfolio-gallery-{{ strtolower($operation->category) }}" 
                                   class="glightbox preview-link">
                                    <i class="bi bi-zoom-in"></i>
                                </a>
                            
                                <form action="{{ route('programs-services.rescue-operations.destroy', $operation->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    @auth
                                    <button type="submit" class="btn btn-link text-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endauth
                                </form>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
