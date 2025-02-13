@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h1 class="text-center" style="color: #003489; margin-bottom: 1rem;">MDRRMO CONTACT DETAILS</h1>

    <!-- 1st District Table -->
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="fw-bold" style="color: #003489; margin-top: 2rem;">1st District</h5>
        <div>
            <button class="btn btn-primary d-none" id="add-first-district" onclick="openAddModal('first-district')" style="background-color: #003489; border-color: #003489;">Add Row</button>
            <button class="btn btn-danger d-none" id="delete-first-district" onclick="deleteRow('first-district')">Delete</button>
            <button class="btn btn-primary" id="edit-first-district" style="background-color: #003489; border-color: #003489;" onclick="toggleEdit('first-district')">Edit</button>
        </div>
    </div>
    <table class="table table-bordered fixed-table" style="border-color: #003489;">
        <thead style="background-color: #003489; color: white;">
            <tr>
                <th>Municipality</th>
                <th>DRRM Office/ Focal Person</th>
                <th>Contact Number</th>
                <th>Local Response Team</th>
                <th class="d-none select-column">Select</th>
            </tr>
        </thead>
        <tbody id="first-district">
            <tr>
                <td>Anilao</td>
                <td>Juan Dela Cruz</td>
                <td>09101234567</td>
                <td>Anilao Emergency Response Team</td>
                <td class="d-none select-column"><input type="checkbox" class="row-select"></td>
            </tr>
        </tbody>
    </table>

    <!-- 2nd District Table -->
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="fw-bold" style="color: #003489; margin-top: 2rem;">2nd District</h5>
        <div>
            <button class="btn btn-primary d-none" id="add-second-district" onclick="openAddModal('second-district')" style="background-color: #003489; border-color: #003489;">Add Row</button>
            <button class="btn btn-danger d-none" id="delete-second-district" onclick="deleteRow('second-district')">Delete</button>
            <button class="btn btn-primary" id="edit-second-district" style="background-color: #003489; border-color: #003489;" onclick="toggleEdit('second-district')">Edit</button>
        </div>
    </div>
    <table class="table table-bordered fixed-table" style="border-color: #003489;">
        <thead style="background-color: #003489; color: white;">
            <tr>
                <th>Municipality</th>
                <th>DRRM Office/ Focal Person</th>
                <th>Contact Number</th>
                <th>Local Response Team</th>
                <th class="d-none select-column">Select<input type="checkbox" class="row-select"></th>
            </tr>
        </thead>
        <tbody id="second-district">
            <tr>
                <td>Alimodian</td>
                <td>Emilio Aguinaldo</td>
                <td>09101112222</td>
                <td>Alimodian Rescue Unit</td>
                <td class="d-none select-column"><input type="checkbox" class="row-select"></td>
            </tr>
        </tbody>
    </table>
</div>

<style>
    .fixed-table th, .fixed-table td {
        width: 25%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    hr {
        border: 1px solid #003489;
        width: 80%;
        margin: 0 auto 2rem auto;
    }
</style>

<!-- Modal for adding a row -->
<div class="modal fade" id="addRowModal" tabindex="-1" aria-labelledby="addRowModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRowModalLabel">Add New Row</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="error-message" class="text-danger mb-3"></div>
                <input type="hidden" id="currentDistrict">
                <div class="mb-3">
                    <label for="municipality" class="form-label">Municipality</label>
                    <input type="text" class="form-control" id="municipality">
                </div>
                <div class="mb-3">
                    <label for="focalPerson" class="form-label">DRRM Office/ Focal Person</label>
                    <input type="text" class="form-control" id="focalPerson">
                </div>
                <div class="mb-3">
                    <label for="contactNumber" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="contactNumber">
                </div>
                <div class="mb-3">
                    <label for="responseTeam" class="form-label">Local Response Team</label>
                    <input type="text" class="form-control" id="responseTeam">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveRow()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleEdit(district) {
        const rows = document.querySelectorAll(#${district} tr);
        const editButton = document.getElementById(edit-${district});
        const addButton = document.getElementById(add-${district});
        const deleteButton = document.getElementById(delete-${district});
        const selectColumns = document.querySelectorAll('.select-column');

        if (editButton.innerText === 'Edit') {
            rows.forEach(row => {
                row.querySelectorAll('td:not(:last-child)').forEach(cell => {
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.value = cell.innerText;
                    input.classList.add('form-control');
                    cell.innerHTML = '';
                    cell.appendChild(input);
                });
            });
            editButton.innerText = 'Save';
            addButton.classList.remove('d-none');
            deleteButton.classList.remove('d-none');
            selectColumns.forEach(col => col.classList.remove('d-none'));
        } else {
            rows.forEach(row => {
                row.querySelectorAll('td:not(:last-child)').forEach(cell => {
                    const input = cell.querySelector('input');
                    if (input) {
                        cell.innerText = input.value;
                    }
                });
            });
            editButton.innerText = 'Edit';
            addButton.classList.add('d-none');
            deleteButton.classList.add('d-none');
            selectColumns.forEach(col => col.classList.add('d-none'));
        }
    }

    function openAddModal(district) {
        document.getElementById("currentDistrict").value = district;
        document.getElementById("municipality").value = "";
        document.getElementById("focalPerson").value = "";
        document.getElementById("contactNumber").value = "";
        document.getElementById("responseTeam").value = "";
        document.getElementById("error-message").innerText = "";

        var modal = new bootstrap.Modal(document.getElementById('addRowModal'));
        modal.show();
    }

    function saveRow() {
        const district = document.getElementById("currentDistrict").value;
        const tableBody = document.getElementById(district);
        
        const municipality = document.getElementById("municipality").value.trim();
        const focalPerson = document.getElementById("focalPerson").value.trim();
        const contactNumber = document.getElementById("contactNumber").value.trim();
        const responseTeam = document.getElementById("responseTeam").value.trim();

        if (!municipality || !focalPerson || !contactNumber || !responseTeam) {
            document.getElementById("error-message").innerText = "All fields are required!";
            return;
        }

        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td>${municipality}</td>
            <td>${focalPerson}</td>
            <td>${contactNumber}</td>
            <td>${responseTeam}</td>
            <td class="d-none select-column"><input type="checkbox" class="row-select"></td>
        `;
        tableBody.appendChild(newRow);
        bootstrap.Modal.getInstance(document.getElementById('addRowModal')).hide();
    }

    function deleteRow(district) {
        const tableBody = document.getElementById(district);
        const selectedRows = tableBody.querySelectorAll('input.row-select:checked');

        selectedRows.forEach(checkbox => {
            checkbox.closest('tr').remove();
        });
    }
</script>

@endsection