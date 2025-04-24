<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>PDRRMO</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
<link href="{{ asset('assets/img/final-logo.png') }}" rel="icon">
<link href="{{ asset('assets/img/final-logo.png') }}" rel="apple-touch-icon">


  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  
 <!-- Vendor CSS Files -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

<!-- Main CSS File -->
<link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">


</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center">

      <a href="{{ route('about-pdrrmo.index') }}" class="logo d-flex align-items-center me-auto">
        <img src="{{ asset('assets/img/final-logo.png') }}" alt="">
        <h3 class="sitename">PDRRMO ILOILO</h3>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li class="nav-item"><a href="{{ route('pdrrmo-home.index') }}" class="nav-link active">Home</a></li>
          <li class="dropdown"><a href="#"><span>About</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
                <li><a href="{{ route('about-pdrrmo.index') }}" class="dropdown-item">About PDRRMO</a></li>
                <li><a href="{{ route('about-pdrrmc.index') }}" class="dropdown-item">About PDRRMC</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Programs and Services</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
                <li><a href="{{ route('programs-services.external-services.index') }}" class="dropdown-item">External Services</a></li>
                <li><a href="{{ route('programs-services.internal-services.index') }}" class="dropdown-item">Internal Services</a></li>
                <li><a href="{{ route('programs-services.rescue-operations.index') }}" class="dropdown-item">Rescue Operations</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Operations Center</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
                <li class="nav-item"><a href="{{ route('operations-center.index') }}" class="nav-link">Resources</a></li>
                @auth<li class="nav-item"><a href="{{ route('super-admin.team') }}" class="nav-link">Developer Team</a></li>@endauth
          </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('contact.index') }}" class="btn" style="background-color: #fe6305; color: white; font-size: 14px; padding: 5px 15px; text-align: center; border-radius: 50px;">Emergency Contact</a>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="header-social-links">
        @auth
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle"></i> 
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('authentication.profile') }}" style="color: black;">
                        <i class="fas fa-user fa-sm fa-fw text-gray-400 me-2"></i> Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('activity.log') }}" style="color: black;">
                        <i class="fas fa-list fa-sm fa-fw text-gray-400 me-2"></i> Activity Log
                    </a>
                </li>
                <li>
                  <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" 
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                     style="color: black;">
                      <i class="fas fa-sign-out-alt fa-sm fa-fw text-gray-400 me-2"></i> Log Out
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
              </li>
            </ul>
        </div>
        @endauth
    </div>
    
    </div>
  </header>

  <main id="content" class="flex-grow-1">
    @yield('content')
 </main>

    <!-- Footer Section -->
    @include('layouts.footer')

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>


</body>

</html>
