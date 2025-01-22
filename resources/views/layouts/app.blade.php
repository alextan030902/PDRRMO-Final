<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }} - PDRRMO VI</title>

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon" type="image/png">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- SEO and Social Media Meta Tags -->
  <meta name="description" content="PDRRMO VI - Providing disaster management services for Region VI">
  <meta name="keywords" content="PDRRMO, Region VI, Disaster Risk Reduction, Emergency Services">
  <meta name="author" content="PDRRMO VI">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&family=Nunito:wght@300;400;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

</head>

<body class="index-page d-flex flex-column min-vh-100">

  <!-- Header Section -->
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <!-- Logo and Site Name -->
      <a href="{{ route('pdrrmo-home.index') }}" class="logo d-flex align-items-center">
        <img src="{{ asset('assets/img/final-logo.png') }}" alt="PDRRMO VI Logo" class="img-fluid" style="max-height: 50px;">
        <h2 class="sitename ms-2">PDRRMO VI</h2>
      </a>

      <!-- Navigation Menu -->
      <nav id="navmenu" class="navmenu">
        <ul class="nav">
          <li class="nav-item"><a href="{{route('pdrrmo-home.index')}}" class="nav-link active">Home</a></li>
          <li class="nav-item"><a href="{{route('about-pdrrmo.index')}}" class="nav-link">About PDRRMO</a></li>
          <li class="nav-item"><a href="{{route('about-pdrrmc.index')}}" class="nav-link">About PDRRMC</a></li>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Programs and Services</a>
            <ul class="dropdown-menu">
              <li><a href="{{route('about-pdrrmc.index')}}" class="dropdown-item">External Services</a></li>
              <li><a href="{{route('about-pdrrmc.index')}}" class="dropdown-item">Internal Services</a></li>
            </ul>
          </li>
          <li class="nav-item"><a href="{{route('resources.index')}}" class="nav-link">Resources</a></li>
          <li class="nav-item"><a href="{{route('about-pdrrmc.index')}}" class="nav-link">Operations Center</a></li>
          <li class="nav-item">
            <a href="{{route('about-pdrrmc.index')}}" class="btn btn-warning rounded-pill text-center d-flex justify-content-center align-items-center px-3 py-2" style="font-size: 14px;">
                Emergency Contact
              </a>
          </li>
        </ul>
        <button class="mobile-nav-toggle d-xl-none btn btn-link">
          <i class="bi bi-list"></i>
        </button>
      </nav>
    </div>
  </header>

  <!-- Main Content Area -->
  <main id="content" class="flex-grow-1">
    @yield('content')
  </main>

  <!-- Footer Section -->
  <footer id="footer" class="footer bg-dark text-light py-4">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="{{ route('pdrrmo-home.index') }}" class="logo d-flex align-items-center">
            <span class="sitename">PDRRMO VI</span>
          </a>
          <div class="footer-contact pt-3">
            <p>A108 Adam Street, New York, NY 535022</p>
            <p><strong>Phone:</strong> +1 5589 55488 55</p>
            <p><strong>Email:</strong> info@example.com</p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href="#" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4>Our Newsletter</h4>
          <p>Subscribe to our newsletter to get the latest updates on our programs and services.</p>
          <form action="forms/newsletter.php" method="post" class="php-email-form">
            <div class="newsletter-form d-flex">
              <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
              <input type="submit" value="Subscribe" class="btn btn-primary ms-2">
            </div>
            <div class="loading">Loading...</div>
            <div class="error-message"></div>
            <div class="sent-message">Thank you for subscribing!</div>
          </form>
        </div>
      </div>
    </div>

    <div class="container text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">PDRRMO VI</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> | Distributed by <a href="https://themewagon.com">ThemeWagon</a>
      </div>
    </div>
  </footer>

  <!-- Scroll Top Button -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center" aria-label="Scroll to top">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Preloader -->
  <div id="preloader"></div>
  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
