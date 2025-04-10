<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>PDRRMO ILOILO</title>

    <link href="{{ asset('assets/img/final-logo.png') }}" rel="icon" type="image/png">
    <link href="{{ asset('assets/img/final-logo.png') }}" rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;400;600;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: url('{{ asset('assets/img/background.png') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            font-family: 'Nunito', sans-serif;
        }

        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            border-radius: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .card-body {
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .form-control {
            border-radius: 0.75rem;
            padding: 1rem;
            border: 1px solid #ddd;
            font-size: 1rem;
            width: 100%;
            min-width: 300px;
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
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .img-container img {
            max-width: 100%;
            height: 150px; 
        }

        .modal-dialog {
            max-width: 250px;
        }

        .modal-content {
            text-align: center;
            padding: 2rem;
        }

        .modal-dialog-centered {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .password-icon {
            position: absolute;
            right: 15px;
            top: 45%;
            cursor: pointer;
        }

        .form-group {
            position: relative;
        }

        @media (max-width: 768px) {
            .card {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="img-container">
                    <img src="{{ asset('assets/img/2011.png') }}" alt="Login Image">
                </div>
                <h1 class="h4 mb-4 text-center">Welcome!</h1>
                <form method="POST" action="{{ url('login') }}" class="user" id="loginForm">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter Email Address..." required value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required id="passwordField">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <i class="fas fa-eye password-icon" id="togglePassword"></i>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="customCheck" name="remember">
                        <label class="form-check-label" for="customCheck">Remember Me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="loadingSpinnerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="spinner-border text-warning" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Please wait...</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        const form = document.getElementById('loginForm');
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingSpinnerModal'));
        const passwordField = document.getElementById('passwordField');
        const togglePasswordIcon = document.getElementById('togglePassword');

        togglePasswordIcon.addEventListener('click', function() {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                togglePasswordIcon.classList.replace('fa-eye', 'fa-eye-slash'); 
            } else {
                passwordField.type = 'password';
                togglePasswordIcon.classList.replace('fa-eye-slash', 'fa-eye'); 
            }
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            loadingModal.show();
            form.submit();
        });
    </script>
</body>

</html>
