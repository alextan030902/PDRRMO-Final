@extends('layouts.app')

@section('content')

<div class="page-title accent-background py-4">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Profile</h1>
        <nav class="breadcrumbs">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item me-3">
                    <a href="{{ route('pdrrmo.index') }}">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAdminModal">
            <i class="fas fa-user-plus me-1"></i> Add Admin
        </button>
    </div>

    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
    
                    <div class="modal-body">
    
                        <div class="mb-4 text-center">
                            <div class="position-relative d-inline-block">
                                <img id="profilePreview" src="" alt="" class="rounded-circle mb-2" 
                                     style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #ccc;">
                            </div>
                            <div class="mt-2">
                                <label for="profile_image" class="form-label">Profile Picture</label>
                                <input class="form-control" type="file" id="profile_image" name="profile_image" accept="image/*">
                                @error('profile_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
    
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
    
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
    
                        <!-- Password -->
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control pe-5" id="password" name="password" required>
                            <span class="toggle-password" style="
                                position: absolute;
                                top: 50%;
                                right: 15px;
                                transform: translateY(-50%);
                                cursor: pointer;
                            ">
                            </span>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3 position-relative">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control pe-5" id="password_confirmation" name="password_confirmation" required>
                            <span class="toggle-password" style="
                                position: absolute;
                                top: 50%;
                                right: 15px;
                                transform: translateY(-50%);
                                cursor: pointer;
                            ">
                            </span>
                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
   <div class="row">
    <!-- Left Column -->
    <div class="col-md-6">
        <div class="card shadow-sm mb-4 h-100">
            <div class="card-header">
                <h5 class="mb-0">Profile</h5>
            </div>
            <div class="card-body">
                
                <!-- Profile Image Display -->
                <div class="text-center mb-4">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image"
                             class="rounded-circle"
                             style="width: 220px; height: 220px; object-fit: cover; border: 2px solid #ccc;">
                    @else
                        <img src="{{ asset('default-avatar.png') }}" alt="Default Avatar"
                             class="rounded-circle"
                             style="width: 120px; height: 120px; object-fit: cover; border: 2px solid #ccc;">
                    @endif
                </div>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label"><strong>Name</strong></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label"><strong>Email</strong></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="created_at" class="form-label"><strong>Date Created</strong></label>
                        <input type="text" class="form-control text-muted" id="created_at" name="created_at" value="{{ $user->created_at->format('F j, Y') }}" readonly>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Change Password</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- New Password -->
                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <span class="position-absolute top-50 translate-middle-y end-0 me-3 cursor-pointer" onclick="togglePassword('password')">
                        </span>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Confirm Password -->
                    <div class="mb-3 position-relative">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        <span class="position-absolute top-50 translate-middle-y end-0 me-3 cursor-pointer" onclick="togglePassword('password_confirmation')">
                        </span>
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mt-auto text-end">
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    
</div>

<!-- Optional JS for password toggle -->
<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>

</div>

<script>
    document.getElementById('profile_image').addEventListener('change', function (event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('profilePreview');
            preview.src = URL.createObjectURL(file);

            const plusIcon = preview.nextElementSibling;
            if (plusIcon && plusIcon.classList.contains('fa-plus')) {
                plusIcon.style.display = 'none';
            }
        }
    });

    const modal = document.getElementById('addAdminModal');
    modal.addEventListener('hidden.bs.modal', () => {
        const preview = document.getElementById('profilePreview');
        const plusIcon = preview.nextElementSibling;
        preview.src = "https://via.placeholder.com/100?text=+"; 
        if (plusIcon) {
            plusIcon.style.display = 'block'; 
        }
        document.getElementById('profile_image').value = '';
    });

    document.addEventListener("DOMContentLoaded", function () {
        const togglePassword = document.querySelectorAll('.toggle-password');
        togglePassword.forEach(function (icon) {
            icon.addEventListener('click', function () {
                const passwordField = this.previousElementSibling;
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>'; 
                } else {
                    passwordField.type = 'password';
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        });
    });
</script>



@endsection
