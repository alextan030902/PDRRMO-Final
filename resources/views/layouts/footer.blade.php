<footer class="footer bg-light text-dark py-4">
    <div class="d-flex justify-content-end gap-2">
        @auth
        <button type="button" class="btn btn-success" title="Add" data-bs-toggle="modal" data-bs-target="#addContactModal">
            <i class="bi bi-plus-circle"></i> Add Contact Info
        </button>

        <button class="btn btn-outline-secondary" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal">
            <i class="bi bi-pencil"></i> Edit
        </button>
        @endauth
    </div>

    <div class="container">
        <div class="d-block d-md-table w-100">
            <table class="table table-borderless text-start d-none d-md-table">
                <colgroup>
                    <col style="width: 29%;">
                    <col style="width: 10%;">
                    <col style="width: 20%;">
                    <col style="width: 20%;">
                    <col style="width: 20%;">
                </colgroup>
                <tbody>
                    <tr>
                        <td class="text-center" rowspan="2" style="width: 400px;">
                            <!-- Check if $contactInfo exists and display logos -->
                            @if ($contactInfo)
                                <div class="logo-images">
                                    @if ($contactInfo->logo1)
                                        <img src="{{ asset('storage/' . $contactInfo->logo1) }}" alt="Logo 1" style="height: 60px; margin-right: 10px;">
                                    @endif
                                    @if ($contactInfo->logo2)
                                        <img src="{{ asset('storage/' . $contactInfo->logo2) }}" alt="Logo 2" style="height: 60px; margin-right: 10px;">
                                    @endif
                                    @if ($contactInfo->logo3)
                                        <img src="{{ asset('storage/' . $contactInfo->logo3) }}" alt="Logo 3" style="height: 60px; margin-right: 10px;">
                                    @endif
                                    @if ($contactInfo->logo4)
                                        <img src="{{ asset('storage/' . $contactInfo->logo4) }}" alt="Logo 4" style="height: 60px;">
                                    @endif
                                </div>
                            @else
                                <!-- Fallback if no logos are available -->
                                <img src="{{ asset('assets/img/default-logo.png') }}" alt="Default Logo" style="height: 60px;">
                            @endif
                        </td>
                        <td><strong>Contact Us</strong></td>
                        <td><i class="bi bi-geo-alt-fill"></i> {{ $contactInfo->address ?? 'Address not available' }}</td>
                        <td><i class="bi bi-envelope"></i> <a href="mailto:{{ $contactInfo->email ?? 'Email not available' }}">{{ $contactInfo->email ?? 'Email not available' }}</a></td>
                        <td><i class="bi bi-telephone"></i> {{ $contactInfo->phone ?? 'Phone not available' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Follow Us</strong></td>
                        <td><a href="https://www.facebook.com/iloilopdrrmo" class="text-dark"><i class="bi bi-facebook" style="color: #1877F2"></i> PDRRMO Iloilo</a></td>
                        <td><a href="https://www.facebook.com/profile.php?id=61570456584511" class="text-dark"><i class="bi bi-facebook" style="color: #1877F2"></i> Operation Center PDRRMO Iloilo</a></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <div class="d-md-none text-center">
                <div class="mb-3">
                    <!-- Check if images exist for mobile view -->
                    @if ($contactInfo)
                        <div class="logo-images">
                            @if ($contactInfo->logo1)
                                <img src="{{ asset('storage/' . $contactInfo->logo1) }}" alt="Logo 1" style="height: 50px; margin-right: 10px;">
                            @endif
                            @if ($contactInfo->logo2)
                                <img src="{{ asset('storage/' . $contactInfo->logo2) }}" alt="Logo 2" style="height: 50px; margin-right: 10px;">
                            @endif
                            @if ($contactInfo->logo3)
                                <img src="{{ asset('storage/' . $contactInfo->logo3) }}" alt="Logo 3" style="height: 50px; margin-right: 10px;">
                            @endif
                            @if ($contactInfo->logo4)
                                <img src="{{ asset('storage/' . $contactInfo->logo4) }}" alt="Logo 4" style="height: 50px;">
                            @endif
                        </div>
                    @else
                        <img src="{{ asset('assets/img/default-logo.png') }}" alt="Default Logo" style="height: 50px;">
                    @endif
                </div>
                <p><strong>Contact Us</strong></p>
                <p><i class="bi bi-geo-alt-fill"></i> {{ $contactInfo->address ?? 'Address not available' }}</p>
                <p><i class="bi bi-envelope"></i> <a href="mailto:{{ $contactInfo->email ?? 'Email not available' }}">{{ $contactInfo->email ?? 'Email not available' }}</a></p>
                <p><i class="bi bi-telephone"></i> {{ $contactInfo->phone ?? 'Phone not available' }}</p>
                <p><strong>Follow Us</strong></p>
                <p>
                    <a href="https://www.facebook.com/iloilopdrrmo" class="text-dark"><i class="bi bi-facebook" style="color: #1877F2"></i> PDRRMO Iloilo</a><br>
                    <a href="https://www.facebook.com/profile.php?id=61570456584511" class="text-dark"><i class="bi bi-facebook" style="color: #1877F2"></i> Operation Center PDRRMO Iloilo</a>
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <table class="table table-borderless d-none d-md-table">
            <colgroup>
                <col style="width: 34%;">
                <col style="width: 35%;">
                <col style="width: 32%;">
            </colgroup>
            <tbody>
                <tr>
                    <td class="text-start">Provincial Disaster Risk Reduction & Management Office (PDRRMO)</td>
                    <td class="text-center">© 2025 All Rights Reserved</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div class="d-md-none text-center">
            <p>Provincial Disaster Risk Reduction & Management Office (PDRRMO)</p>
            <p>© 2025 All Rights Reserved</p>
        </div>
    </div>
</footer>

<!-- Add Contact Modal -->
<div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addContactModalLabel">Add Contact Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Contact Form -->
                <form id="addContactForm" action="{{ route('contact-info.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>

                    <!-- Image Uploads -->
                    <div class="mb-3">
                        <label for="logo1" class="form-label">Logo 1</label>
                        <input type="file" class="form-control" id="logo1" name="logo1" required>
                    </div>
                    <div class="mb-3">
                        <label for="logo2" class="form-label">Logo 2</label>
                        <input type="file" class="form-control" id="logo2" name="logo2" required>
                    </div>
                    <div class="mb-3">
                        <label for="logo3" class="form-label">Logo 3</label>
                        <input type="file" class="form-control" id="logo3" name="logo3" required>
                    </div>
                    <div class="mb-3">
                        <label for="logo4" class="form-label">Logo 4</label>
                        <input type="file" class="form-control" id="logo4" name="logo4" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Contact Info</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Contact Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit Form -->
                <form action="{{ isset($contactInfo) ? route('contact-info.update', $contactInfo->id) : '#' }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ $contactInfo->address ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $contactInfo->email ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $contactInfo->phone ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="logo1" class="form-label">Logo 1</label>
                        <input type="file" class="form-control" id="logo1" name="logo1">
                    </div>
                    <div class="mb-3">
                        <label for="logo2" class="form-label">Logo 2</label>
                        <input type="file" class="form-control" id="logo2" name="logo2">
                    </div>
                    <div class="mb-3">
                        <label for="logo3" class="form-label">Logo 3</label>
                        <input type="file" class="form-control" id="logo3" name="logo3">
                    </div>
                    <div class="mb-3">
                        <label for="logo4" class="form-label">Logo 4</label>
                        <input type="file" class="form-control" id="logo4" name="logo4">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
