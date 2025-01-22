@extends('layouts.app')

@section('content')

<div class="container my-5">
    <div class="row">
        <!-- First Card -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <img src="https://via.placeholder.com/800x400" class="card-img-top" alt="Card Image 1">
                <div class="card-body">
                    <h5 class="card-title">Card Title 1</h5>
                    <p class="card-text">
                        This is a wider card with supporting text below as a natural lead-in to additional content. 
                        This content is a little bit longer.
                    </p>
                    <a href="#" class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>
        <!-- Second Card -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <img src="https://via.placeholder.com/800x400" class="card-img-top" alt="Card Image 2">
                <div class="card-body">
                    <h5 class="card-title">Card Title 2</h5>
                    <p class="card-text">
                        This is another card with supporting text below as a natural lead-in to additional content. 
                        It contains some extra text to balance the layout.
                    </p>
                    <a href="#" class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
