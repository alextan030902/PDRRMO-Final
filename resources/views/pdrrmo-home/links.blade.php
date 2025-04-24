<section>
    <div class="container section-title position-relative text-center" data-aos="fade-up">
        <h2>Useful Links</h2>
        @auth
        <button class="btn btn-primary position-absolute top-0 end-0 mt-2" data-bs-toggle="modal" data-bs-target="#addLinkModal">
            <i class="fas fa-plus me-1"></i> Add 
        </button>
        @endauth
    </div>

    <div class="container-fluid"> 
        <div class="row g-3">
            @foreach($links as $link)
                <div class="col-md-3 position-relative">
                    <a href="{{ $link->link }}" target="_blank">
                        <img src="{{ asset($link->image) }}" class="img-fluid w-100" alt="Useful Link" onerror="this.onerror=null; this.src='{{ asset('storage/links/default-placeholder.png') }}';">
                    </a>

                    <form action="{{ route('useful-links.destroy', $link->id) }}" method="POST" class="position-absolute top-0 end-0 p-2">
                        @csrf
                        @method('DELETE')
                        @auth
                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        @endauth
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</section>

<div class="modal fade" id="addLinkModal" tabindex="-1" aria-labelledby="addLinkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('useful-links.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="addLinkModalLabel">Add Useful Link</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="link" class="form-label">Link URL</label>
                    <input type="url" name="link" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image</label>
                    <input type="file" name="image" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
    </div>
</div>
