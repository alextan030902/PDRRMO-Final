@extends('layouts.app')

@section('content')

<!-- Banner Section -->
<section id="banner" class="banner section light-background">
  <div class="container">
      <div class="row">
          <div class="col-12 text-center">
             <img src="{{ asset('assets/img/banner.png') }}" alt="Banner Image" class="img-fluid banner-image">
          </div>
      </div>
  </div>
</section>

<!-- Hero Carousel Section -->
<section id="hero" class="hero section dark-background">
    <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

        <div class="carousel-item active">
            <img src="{{ asset('assets/img/hero-carousel/hero-carousel-1.jpg') }}" alt="First Slide">
        </div><!-- End Carousel Item -->
        
        <div class="carousel-item">
            <img src="{{ asset('assets/img/hero-carousel/hero-carousel-2.jpg') }}" alt="Second Slide">
        </div><!-- End Carousel Item -->
        
        <div class="carousel-item">
            <img src="{{ asset('assets/img/hero-carousel/hero-carousel-3.jpg') }}" alt="Third Slide">
        </div><!-- End Carousel Item -->

        <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a>

        <ol class="carousel-indicators"></ol>

    </div>
</section>

@endsection
