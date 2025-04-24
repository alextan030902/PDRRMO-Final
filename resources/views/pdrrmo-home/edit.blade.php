@extends('layouts.app')

@section('content')
<div class="container mt-5">
        <div class="card-body">
            <div class="row justify-content-center mb-4">
                @foreach($activity->images as $image)
                <div class="col-md-12 mb-4 d-flex justify-content-center">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Activity Image" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                </div>
                @endforeach
            </div>

             <div class="text-center mb-4">
                <h1 class="card-title fw-bold text-dark">{{ $activity->title }}</h1>
                <p class="card-text text-dark">{{ $activity->description }}</p>
            </div>
        </div>
</div>
@endsection
