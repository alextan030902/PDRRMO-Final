@extends('layouts.app')

@section('content')

<div class="card shadow-sm rounded-lg container my-5 mb-4">
    <!-- About Section with Border and Title -->
    <div class="border border-primary rounded p-4 mb-3 mt-3">
        <button class="btn btn-warning" onclick="toggleEdit('about')">Edit</button>
        <h2 class="text-center mb-4" style="color: #FF9A00"><strong>About PDRRMO</strong></h2>
        
        <!-- Display Mode -->
        <div id="about-display">
            <p class="card-text">{!! $about->content ?? 'Default content' !!}</p>
        </div>

        <!-- Edit Mode -->
        <form id="about-edit-form" action="{{ route('about.update', 'about') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="content" id="about_content">
            <div id="about-editor" class="quill-editor" data-content="{{ htmlentities($about->content ?? 'Default content') }}"></div>
            <button type="submit" class="btn btn-primary mt-3">Save</button>
            <button type="button" class="btn btn-secondary mt-3" onclick="toggleEdit('about')">Cancel</button>
        </form>
    </div>

    <!-- Other Sections (Without Border) -->
    @foreach(['mandate', 'vision', 'mission', 'functions'] as $section)
        <div class="mb-3">
            
            <h2 class="mb-4" style="color: #FF9A00"><strong>{{ ucfirst($section) }}</strong></h2>
            
            <!-- Display Mode -->
            <div id="{{ $section }}-display">
                <p class="card-text">{!! ${$section}->content ?? 'Default content' !!}</p>
                <button class="btn btn-warning" onclick="toggleEdit('{{ $section }}')">Edit</button>
            </div>

            <!-- Edit Mode -->
            <form id="{{ $section }}-edit-form" action="{{ route('about.update', $section) }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="content" id="{{ $section }}_content">
                <div id="{{ $section }}-editor" class="quill-editor" data-content="{{ htmlentities(${$section}->content ?? 'Default content') }}"></div>
                <button type="submit" class="btn btn-primary mt-3">Save</button>
                <button type="button" class="btn btn-secondary mt-3" onclick="toggleEdit('{{ $section }}')">Cancel</button>
            </form>
        </div>
        <hr>
    @endforeach
    <div class="card shadow-sm rounded-lg mb-3">
        <div class="card-body shadow-sm border-0 text-center">
            <div class="row mb-5">
                <h2 class="card-title text-center mb-1" style="color: #FF9A00">
                    <strong>Organizational Structure</strong>
                </h2>
                <div class="col-12 text-center ">
                    <img src="{{ asset('assets/img/OrgStruct.png') }}" alt="Banner Image" class="banner-image img-fluid rounded-lg">
                </div>
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
</script>

@endsection
