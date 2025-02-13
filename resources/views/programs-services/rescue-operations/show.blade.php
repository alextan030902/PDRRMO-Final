@extends('layouts.app')

@section('content')
<section id="rescue-operation-details" class="rescue-operation-details section">
  <div class="container">
      <!-- Center the category title -->
      <h2 class="text-center">{{ ucwords(str_replace('_', ' ', $category)) }}</h2> <!-- Displaying the category name -->

      <!-- Fetch the latest rescue operation for description only -->
      @if($latestRescueOperation = $rescueOperations->sortByDesc('created_at')->first())
          <!-- Center the description -->
          @if($latestRescueOperation->description)
              <div class="content text-center">
                  <p>{{ $latestRescueOperation->description }}</p>
              </div>
          @else
              <p class="text-center">No content available for this rescue operation.</p>
          @endif
      @else
          <p class="text-center">No rescue operations found for this category.</p>
      @endif

      <!-- Display images for all rescue operations in the category -->
      @if($rescueOperations->count() > 0)
          <div class="images mt-4">
              <h4 class="text-center">Images</h4> <!-- Center the Images heading -->
              <div class="row collage-row">
                  @foreach($rescueOperations as $rescueOperation)
                      @foreach($rescueOperation->images as $image)
                          <div class="col-lg-3 col-md-4 col-sm-6">
                              <div class="image-item">
                                  <img src="{{ asset('storage/' . $image) }}" alt="{{ $rescueOperation->category }}" class="img-fluid" loading="lazy">
                              </div>
                          </div>
                      @endforeach
                  @endforeach
              </div>
          </div>
      @else
          <p class="text-center">No images available for this category.</p>
      @endif
  </div>
</section>
@endsection
