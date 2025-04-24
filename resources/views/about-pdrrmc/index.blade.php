@extends('layouts.app')

@section('content')

<div class="page-title accent-background py-4">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">About PDRRMC</h1>
        <nav class="breadcrumbs">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('pdrrmo.index') }}">
                        <i class="fas fa-home"></i> Home
                      </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">About PDRRMC</li>
            </ol>
        </nav>
    </div>
</div>



    <div class="card shadow-lg rounded-lg p-5 mb-5">
        
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

        <div class="row">
            @foreach(['mandate', 'vision', 'mission', 'functions'] as $section)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            @auth
                            <button class="btn btn-warning position-absolute top-0 end-0 m-2" onclick="toggleEdit('{{ $section }}')">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            @endauth
                            <h5 class="card-title text-center" style="color: #FF9A00"><strong>{{ ucfirst($section) }}</strong></h5>
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
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="card shadow-lg rounded-lg mb-3 bg-light w-100">
            <div class="card-body border-0 text-center position-relative">
                @auth
                    <button class="btn btn-warning position-absolute top-0 end-0 mt-3 me-3 d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#updateImageModal">
                        <i class="bi bi-pencil"></i> <span>Update</span>
                    </button>
                @endauth
                <h2 class="card-title mb-4" style="color: #FF9A00">
                    <strong>Organizational Structure</strong>
                </h2>
        
                <div class="col-12 text-center">
                    @if($orgChartPath)
                    <a href="{{ asset($orgChartPath) }}" 
                       class="glightbox" 
                       data-gallery="org-structure-gallery" 
                       title="Organizational Structure">
                        <img src="{{ asset($orgChartPath) }}" 
                             alt="Organizational Structure" 
                             class="img-fluid rounded-lg shadow-sm"
                             style="max-width: 100%; max-height: 100%; object-fit: contain; cursor: zoom-in;">
                    </a>
                @else
                    <p>No organizational chart available.</p>
                @endif
                
                </div>
            </div>
        </div>
        
        
        
        
        <div class="modal fade" id="updateImageModal" tabindex="-1" aria-labelledby="updateImageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateImageModalLabel">Update Organizational Chart</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('org-chart.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="org-chart-file" class="form-label">Select New Image</label>
                                <input type="file" class="form-control" id="org-chart-file" name="org_chart_image" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

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

                if (!quillInstances[section]) {
                    quillInstances[section] = new Quill('#' + section + '-editor', { theme: 'snow' });

                    let editorElement = document.getElementById(section + '-editor');
                    let existingContent = editorElement.getAttribute('data-content');

                    quillInstances[section].root.innerHTML = decodeEntities(existingContent);
                }
            }
        }

        function decodeEntities(encodedString) {
            let textArea = document.createElement('textarea');
            textArea.innerHTML = encodedString;
            return textArea.value;
        }

        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(event) {
                let section = this.id.replace('-edit-form', '');
                document.getElementById(section + '_content').value = quillInstances[section].root.innerHTML;
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            if (document.getElementById('successToast')) {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
            }

            if (document.getElementById('errorToast')) {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                errorToast.show();
            }
        });
    </script>

@endsection

