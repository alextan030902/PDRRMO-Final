@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manage Hero Carousel</h2>

    <!-- Image Upload Form -->
    <form action="{{ route('hero-carousel.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="image" class="form-label">Upload Image</label>
            <input type="file" class="form-control" name="image" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <!-- Display Uploaded Images -->
    <div class="mt-4">
        <h4>Uploaded Images</h4>
        <div class="row">
            @foreach($carousels as $carousel)
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('storage/'.$carousel->image_path) }}" class="card-img-top" alt="Carousel Image" style="max-height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <form action="{{ route('hero-carousel.destroy', $carousel) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
