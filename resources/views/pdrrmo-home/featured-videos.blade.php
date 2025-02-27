<section id="services" class="services section light-background position-relative">
    <div class="container section-title" data-aos="fade-up">
        <h2>Featured Videos</h2>

        @auth
         <button type="button" class="btn btn-primary position-absolute top-0 end-0 m-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="bi bi-plus-circle"></i> Add Link
        </button>
        @endauth
    </div>

    <div class="container position-relative pt-4"> 
        <div class="row gy-4">
            @foreach($videos as $video)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item item-cyan position-relative">
                        <div class="embed-responsive embed-responsive-ratio ratio-16x9">
                            @php
                                $parsedUrl = parse_url($video->video_url);
                                parse_str($parsedUrl['query'], $queryParams);
                                $videoId = $queryParams['v'] ?? ''; 
                
                                $embedUrl = $videoId ? "https://www.youtube.com/embed/{$videoId}" : '';
                            @endphp
                
                            @if($embedUrl)
                                <iframe class="embed-responsive-item" src="{{ $embedUrl }}" allowfullscreen></iframe>
                            @else
                                <p>Invalid video URL</p> 
                            @endif
                        </div>
                        @auth
                            <form action="{{ route('video.destroy', $video->id) }}" method="POST" style="position: absolute; top: 10px; right: 10px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Video URL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('video.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="video_url">Video URL</label>
                            <input type="url" name="video_url" id="video_url" class="form-control" placeholder="Enter YouTube Video URL" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Video</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
