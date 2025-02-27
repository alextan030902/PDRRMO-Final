@extends('layouts.app')

@section('content')

<div class="page-title accent-background py-4">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">About PDRRMC</h1>
        <nav class="breadcrumbs">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('pdrrmo.index') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">About PDRRMC</li>
            </ol>
        </nav>
    </div>
</div>



    <div class="card shadow-lg rounded-lg p-5 mb-5">
        
        <!-- About Section with Border and Title -->
        <div class="position-relative mb-4">
            @auth
            <button class="btn btn-warning position-absolute top-0 end-0 m-2" onclick="toggleEdit('about')"><i class="bi bi-pencil"></i> Edit</button>
            @endauth
            <div class="border border-primary rounded p-4 bg-light">
                <h2 class="text-center mb-4" style="color: #FF9A00"><strong>About PDRRMC</strong></h2>
                <div id="about-display">
                    <p class="card-text">{!! $about->content ?? 'Add text' !!}</p>
                </div>

                <form id="about-edit-form" action="{{ route('about-pdrrmc.update', 'about') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="content" id="about_content">
                    <div id="about-editor" class="quill-editor" data-content="{{ htmlentities($about->content ?? 'Add text') }}"></div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-save"></i> Save
                        </button>
                        <button type="button" class="btn btn-danger" onclick="toggleEdit('about')">
                            <i class="bi bi-x-circle"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Other Sections (Without Border) -->
        @foreach(['mandate', 'vision', 'mission', 'functions'] as $section)
            <div class="position-relative mb-4">
                @auth
                <button class="btn btn-warning position-absolute top-0 end-0 m-2" onclick="toggleEdit('{{ $section }}')"><i class="bi bi-pencil"></i> Edit</button>
                @endauth
                <h2 class="mb-4" style="color: #FF9A00"><strong>{{ ucfirst($section) }}</strong></h2>
                <div id="{{ $section }}-display">
                    <p class="card-text">{!! ${$section}->content ?? 'Add text' !!}</p>
                </div>

                <form id="{{ $section }}-edit-form" action="{{ route('about-pdrrmc.update', $section) }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="content" id="{{ $section }}_content">
                    <div id="{{ $section }}-editor" class="quill-editor" data-content="{{ htmlentities(${$section}->content ?? 'Add text') }}"></div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-save"></i> Save
                        </button>
                        <button type="button" class="btn btn-danger" onclick="toggleEdit('{{ $section }}')">
                            <i class="bi bi-x-circle"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
            <hr class="my-4">
        @endforeach

        <!-- Organizational Structure Section -->
        <div class="card shadow-lg rounded-lg mb-3 bg-light">
            <div class="card-body border-0 text-center">
                <h2 class="card-title mb-4" style="color: #FF9A00">
                    <strong>Organizational Structure</strong>
                </h2>
                <div class="col-12 text-center">
                    <img src="{{ asset('assets/img/OrgStruct.jpg') }}" alt="Organizational Structure" class="img-fluid rounded-lg shadow-sm">
                </div>
            </div>
        </div>
    </div>

    <!-- Include Quill.js -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        let quillInstances = {};

        function toggleEdit(section) {
            let displayDiv = document.getElementById(section + '-display');
            let editForm = document.getElementById(section + '-edit-form');

            if (displayDiv.style.display === 'none') {
                displayDiv.style.display = 'block';
                editForm.style.display = 'none';
            } else {
                displayDiv.style.display = 'none';
                editForm.style.display = 'block';

                // Initialize Quill only if it hasn't been initialized before
                if (!quillInstances[section]) {
                    quillInstances[section] = new Quill('#' + section + '-editor', { theme: 'snow' });

                    // Fetch the pre-existing content stored in the data attribute
                    let editorElement = document.getElementById(section + '-editor');
                    let existingContent = editorElement.getAttribute('data-content');

                    // Decode HTML entities and set it inside Quill editor
                    quillInstances[section].root.innerHTML = decodeEntities(existingContent);
                }
            }
        }

        // Function to decode HTML entities properly
        function decodeEntities(encodedString) {
            let textArea = document.createElement('textarea');
            textArea.innerHTML = encodedString;
            return textArea.value;
        }

        // Ensure form submits the Quill content properly
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(event) {
                let section = this.id.replace('-edit-form', '');
                document.getElementById(section + '_content').value = quillInstances[section].root.innerHTML;
            });
        });

        // Ensure toast displays when session success or error is set
        document.addEventListener("DOMContentLoaded", function() {
            // Check and show success toast
            if (document.getElementById('successToast')) {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
            }

            // Check and show error toast
            if (document.getElementById('errorToast')) {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                errorToast.show();
            }
        });
    </script>

@endsection

