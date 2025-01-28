@extends('layouts.app')

@section('content')

  <!-- Edit Form Section -->
  <div class="container mt-5">
    <h2 class="mb-4">Edit Banner and Carousel</h2>
    
    <!-- Banner Image Edit Form -->
    <form action="{{ route('pdrrmo-home.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="mb-4">
        <label for="banner_image" class="form-label">Banner Image</label>
        <input type="file" class="form-control" id="banner_image" name="banner_image">
        @error('banner_image')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <img src="#" alt="Current Banner" class="img-fluid" style="max-height: 200px; object-fit: cover;">
      </div>

      <button type="submit" class="btn btn-primary">Update Banner</button>
    </form>

    <!-- Carousel Images Edit Form -->
    <form action="{{ route('pdrrmo-home.carousel') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <h3 class="mt-5 mb-3">Edit Carousel Images</h3>

      @for ($i = 1; $i <= 3; $i++)
        <div class="mb-4">
          <label for="carousel_image_{{ $i }}" class="form-label">Carousel Image {{ $i }}</label>
          <input type="file" class="form-control" id="carousel_image_{{ $i }}" name="carousel_image_{{ $i }}">
          @error('carousel_image_' . $i)
            <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-4">
          <img src="{{ asset("assets/img/hero-carousel/hero-carousel-{$i}.jpg") }}" alt="Current Carousel Image {{ $i }}" class="img-fluid" style="max-height: 200px; object-fit: cover;">
        </div>
      @endfor

      <button type="submit" class="btn btn-primary">Update Carousel</button>
    </form>
  </div>

@endsection
