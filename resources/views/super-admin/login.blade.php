<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>PDRRMO ILOILO</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/final-logo.png') }}" rel="icon" type="image/png">
    <link href="{{ asset('assets/img/final-logo.png') }}" rel="apple-touch-icon">

    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;400;600;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap 5 CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
       body {
            background: url('{{ asset('assets/img/background.png') }}') no-repeat center center fixed;
            background-size: 100% auto; /* Ensures full width without cropping */
            min-height: 100vh;
            font-family: 'Nunito', sans-serif;
        }
        .card {
            border-radius: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 2rem;
        }
        .form-control {
            border-radius: 0.75rem;
            padding: 1rem;
            border: 1px solid #ddd;
            font-size: 1rem;
        }
        .form-control:focus {
            border-color: #ff6600;
            box-shadow: 0 0 0 0.2rem rgba(255, 102, 0, 0.25);
        }
        .btn-primary {
            background-color: #FF6600;
            border-color: #FF6600;
            border-radius: 0.75rem;
            font-size: 1.1rem;
            padding: 0.75rem;
        }
        .btn-primary:hover {
            background-color: #e65c00;
            border-color: #e65c00;
        }
        .text-center h1 {
            color: #003489;
            font-weight: 700;
        }
        .img-container {
            background-color: transparent;
            border-top-left-radius: 1.5rem;
            border-bottom-left-radius: 1.5rem;
            padding: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .img-container img {
            max-width: 75%;
        }
        .form-check-input {
            border-radius: 0.25rem;
        }

        /* Modal and spinner styles */
        .modal-dialog {
            max-width: 250px;
        }
        .modal-content {
            text-align: center;
            padding: 2rem;
        }

        /* Centering the modal vertically */
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

    </style>
</head>

<body>
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- Add the image on the left side -->
                            <div class="col-lg-6 img-container d-none d-lg-block">
                                <img src="{{ asset('assets/img/2011.png') }}" alt="Login Image">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 mb-4">Welcome!</h1>
                                    </div>
                                    <form method="POST" action="{{ url('login') }}" class="user" id="loginForm">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address..." value="{{ old('email') }}" required>
                                            @if ($errors->has('email'))
                                                <div class="text-danger mt-2">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password" required>
                                            @if ($errors->has('password'))
                                                <div class="text-danger mt-2">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>
                                        <div class="form-group mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck" name="remember">
                                                <label class="form-check-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary btn-user btn-block d-flex justify-content-center">
                                                <i class="bi bi-box-arrow-in-right"></i> Login
                                            </button>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Modal Spinner (Bootstrap Modal) -->
    <div class="modal fade" id="loadingSpinnerModal" tabindex="-1" aria-labelledby="loadingSpinnerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"> <!-- Centering Modal -->
            <div class="modal-content">
                <div class="modal-body">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Please wait...</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        // Get the form and modal elements
        const form = document.getElementById('loginForm');
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingSpinnerModal'));

        // When the form is submitted
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting immediately
            loadingModal.show(); // Show the loading modal
            form.submit(); // Proceed with the form submission
        });
    </script>

</body>


</html>
