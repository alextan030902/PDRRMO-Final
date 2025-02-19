@extends('layouts.app')

@section('content')
<div class="container mt-5 position-relative">
    <h1 class="text-center" style="color: #003489; margin-bottom: 1rem;">CONTACT DETAILS</h1>
    
    @auth
        <!-- Add Contact Button in Top Left Corner -->
        <button type="button" class="btn btn-primary position-absolute top-0 start-0 m-3" data-bs-toggle="modal" data-bs-target="#addRowModal">
            <i class="bi bi-person-plus"></i> Add Contact
        </button>

        <!-- Category Filter in Top Right Corner -->
        <div class="position-absolute top-0 end-0 m-3" style="right: 120px;">
            <form method="GET" action="{{ route('contact.index') }}">
                <div class="input-group">
                    <select name="category" class="form-select" id="categoryFilter">
                        <option value="">Select Category</option>
                        <option value="MDRRMO" {{ request()->category == 'MDRRMO' ? 'selected' : '' }}>MDRRMO</option>
                        <option value="HOSPITALS" {{ request()->category == 'HOSPITALS' ? 'selected' : '' }}>HOSPITALS</option>
                        <option value="IPPO" {{ request()->category == 'IPPO' ? 'selected' : '' }}>IPPO</option>
                        <option value="BFP" {{ request()->category == 'BFP' ? 'selected' : '' }}>BFP</option>
                    </select>
                    <button type="submit" class="btn btn-info">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    @endauth

    @php
        // If $contacts is null, make it an empty collection
        $contacts = $contacts ?? collect();

        // Apply category filter if selected
        if (request()->has('category') && request()->category != '') {
            $contacts = $contacts->where('category', request()->category);
        }

        // Group contacts by district and then sort them numerically
        $contactsByDistrict = $contacts->groupBy('district')->sortKeys();
    @endphp

    <!-- Table to display contacts -->
    <table class="table table-bordered border-info">
        <thead class="text-center">
            <tr>
                <th scope="col" class="d-none">Category</th>
                <th scope="col">District</th>
                <th scope="col">Municipality</th>
                <th scope="col">Focal Person</th>
                <th scope="col">Contact Number</th>
                <th scope="col">Email</th>
                <th scope="col">Response Team</th>
                @auth
                    <th scope="col">Actions</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @if($contacts->isEmpty())
                <tr>
                    <td colspan="{{ Auth::check() ? '7' : '6' }}" class="text-center">No contacts available</td>
                </tr>
            @else
                @foreach($contactsByDistrict as $district => $districtContacts)
                    <tr>
                        <td colspan="{{ Auth::check() ? '7' : '6' }}" class="text-center bg-light"><strong>{{ $district }}</strong></td>
                    </tr>
                    
                    @php
                        // Sort the municipalities alphabetically
                        $districtContacts = $districtContacts->sortBy('municipality');
                    @endphp
        
                    @foreach($districtContacts as $contact)
                        <tr class="text-center">
                            <td class="d-none">{{ $contact->category }}</td>
                            <td>{{ $contact->district }}</td>
                            <td>{{ $contact->municipality }}</td>
                            <td>{{ $contact->focal_person }}</td>
                            <td>{{ $contact->contact_number }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->response_team }}</td>
                            @auth
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editContactModal" data-id="{{ $contact->id }}">
                                        <i class="fa fa-pencil-alt"></i> Edit
                                    </a>
                                    <form action="{{ route('contact.destroy', $contact->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            @endauth
                        </tr>
                    @endforeach
                @endforeach
            @endif
        </tbody>
    </table>

   <!-- Modal for adding contact -->
   <div class="modal fade" id="addRowModal" tabindex="-1" aria-labelledby="addRowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRowModalLabel">Add New Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <label for="category" class="col-sm-4 col-form-label">Category</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="category" name="category" required>
                                <option value="" disabled selected>Select a category</option>
                                <option value="MDRRMO">MDRRMO</option>
                                <option value="HOSPITALS">HOSPITALS</option>
                                <option value="IPPO">IPPO</option>
                                <option value="BFP">BFP</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="district" class="col-sm-4 col-form-label">District</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="district" name="district" required>
                                <option value="" disabled selected>Select a district</option>
                                <option value="1st District">1st District</option>
                                <option value="2nd District">2nd District</option>
                                <option value="3rd District">3rd District</option>
                                <option value="4th District">4th District</option>
                                <option value="5th District">5th District</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="municipality" class="col-sm-4 col-form-label">Municipality</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="municipality" name="municipality" required>
                                <option value="" disabled selected>Select a municipality</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="focal_person" class="col-sm-4 col-form-label">DRRM Office/ Focal Person</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="focal_person" name="focal_person" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="contact_number" class="col-sm-4 col-form-label">Contact Number</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="response_team" class="col-sm-4 col-form-label">Local Response Team</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="response_team" name="response_team" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> 
                            <i class="bi bi-x-circle"></i> Close
                        </button>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editContactModal" tabindex="-1" aria-labelledby="editContactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editContactModalLabel">Edit Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('contact.update', 'contactId') }}" method="POST" id="editContactForm">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="editContactId" name="id">
                    
                    <div class="row mb-3">
                        <label for="edit_category" class="col-sm-4 col-form-label">Category</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="edit_category" name="category" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="edit_district" class="col-sm-4 col-form-label">District</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="edit_district" name="district" required>
                        </div>
                    </div>
                
                    <div class="row mb-3">
                        <label for="edit_municipality" class="col-sm-4 col-form-label">Municipality</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="edit_municipality" name="municipality" required>
                        </div>
                    </div>
                
                    <div class="row mb-3">
                        <label for="edit_focal_person" class="col-sm-4 col-form-label">Focal Person</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="edit_focal_person" name="focal_person" required>
                        </div>
                    </div>
                
                    <div class="row mb-3">
                        <label for="edit_contact_number" class="col-sm-4 col-form-label">Contact Number</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="edit_contact_number" name="contact_number" required>
                        </div>
                    </div>
                
                    <div class="row mb-3">
                        <label for="edit_email" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                    </div>
                
                    <div class="row mb-3">
                        <label for="edit_response_team" class="col-sm-4 col-form-label">Response Team</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="edit_response_team" name="response_team" required>
                        </div>
                    </div>
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


</div>

<script>
    const municipalities = {
    "1st District": ["Igbaras Iloilo", "Guimbal Iloilo", "Miag-ao Iloilo", "Oton Iloilo", "Tigbauan Iloilo", "Tubungan Iloilo", "San Joaquin Iloilo"],
    "2nd District": ["Alimodian Iloilo", "Leganes Iloilo", "Leon Iloilo", "New Lucena Iloilo", "Pavia Iloilo", "San Miguel Iloilo", "Sta. Barbara Iloilo", "Zarraga Iloilo"],
    "3rd District": ["Badiangan Iloilo", "Bingawan Iloilo", "Cabatuan Iloilo", "Calinog Iloilo", "Janiuay Iloilo", "Lambunao Iloilo", "Maasin Iloilo", "Mina Iloilo", "Pototan Iloilo"],
    "4th District": ["Anilao Iloilo", "Banate Iloilo", "Barotac Nuevo Iloilo", "Dingle Iloilo", "Duenas Iloilo", "Dumangas Iloilo", "Passi Iloilo", "San Enrique Iloilo"],
    "5th District": ["Ajuy Iloilo", "Balasan Iloilo", "Barotac Viejo Iloilo", "Batad Iloilo", "Carles Iloilo", "Concepcion Iloilo", "Estancia Iloilo", "Lemery Iloilo", "San Dionisio Iloilo", "San Rafael Iloilo", "Sara Iloilo"]
};

    document.getElementById("district").addEventListener("change", function() {
        const district = this.value;
        const municipalitySelect = document.getElementById("municipality");

        // Clear previous options
        municipalitySelect.innerHTML = '<option value="" disabled selected>Select a municipality</option>';

        // Populate new options
        if (municipalities[district]) {
            municipalities[district].forEach(municipality => {
                const option = document.createElement("option");
                option.value = municipality;
                option.textContent = municipality;
                municipalitySelect.appendChild(option);
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
    // Select all edit buttons
    const editButtons = document.querySelectorAll('.edit-btn');

    // Attach click event listener to each edit button
    editButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            // Get the contact ID from the data-id attribute
            const contactId = event.target.getAttribute('data-id');
            
            // Get the closest <tr> element to extract data for the fields
            const row = event.target.closest('tr');
            const category = row.querySelector('td:nth-child(1)').innerText; // Category
            const district = row.querySelector('td:nth-child(2)').innerText; // District
            const municipality = row.querySelector('td:nth-child(3)').innerText; // Municipality
            const focalPerson = row.querySelector('td:nth-child(4)').innerText; // Focal Person
            const contactNumber = row.querySelector('td:nth-child(5)').innerText; // Contact Number
            const email = row.querySelector('td:nth-child(6)').innerText; // Email
            const responseTeam = row.querySelector('td:nth-child(7)').innerText; // Response Team

            // Fill the modal form fields with this data
            document.getElementById('edit_category').value = category;
            document.getElementById('edit_district').value = district;
            document.getElementById('edit_municipality').value = municipality;
            document.getElementById('edit_focal_person').value = focalPerson;
            document.getElementById('edit_contact_number').value = contactNumber;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_response_team').value = responseTeam;
            document.getElementById('editContactId').value = contactId;

            // Update form action URL dynamically with the correct contact ID
            const form = document.getElementById('editContactForm');
            form.action = `/contact/update/${contactId}`;

        });
    });
});

</script>

@endsection
