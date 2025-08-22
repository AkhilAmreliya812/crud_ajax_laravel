<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajax CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Student List</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal">
            Add New Student
        </button>
    </div>
    <table class="table table-bordered">
        <thead class="table-light text-center">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="studentList" class="text-center">
            @if ($students->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-muted">No students found</td>
                </tr>
            @else
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->phone }}</td>
                        <td>{{ $student->country_name }}</td>
                        <td>{{ $student->state_name }}</td>
                        <td>{{ $student->city_name }}</td>
                        <td>{{ $student->address }}</td>
                        <td>
                            <button id="{{ $student->id }}" class="btn btn-info btn-sm viewBtn">View</button>
                            <button id="{{ $student->id }}" class="btn btn-primary btn-sm editBtn">Edit</button>
                            <button id="{{ $student->id }}" class="btn btn-danger btn-sm deleteBtn">Delete</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <!-- Add Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add Student</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="studentForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                        </div>

                        {{-- Country --}}
                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <select name="country" id="country" class="form-control" required>
                                <option value="" disabled selected>Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- state --}}
                        <div class="mb-3">
                            <label class="form-label">State</label>
                            <select name="state" id="state" class="form-control" required>
                                <option value="" disabled selected>Select State</option>
                            </select>
                        </div>

                        {{-- City --}}
                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <select name="city" id="city" class="form-control" required>
                                <option value="" disabled selected>Select City</option>
                            </select>
                        </div>
                        {{-- drop down end --}}

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" id="address" rows="3" class="form-control"></textarea>
                        </div>
                        <button id="addBtn" class="btn btn-primary w-100">Save Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Student Modal -->
    <div class="modal fade" id="viewStudentModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">View Student</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="view_name"></span></p>
                    <p><strong>Email:</strong> <span id="view_email"></span></p>
                    <p><strong>Phone:</strong> <span id="view_phone"></span></p>
                    <p><strong>Address:</strong> <span id="view_address"></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-light">Edit Student</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editStudentForm">
                        @csrf
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" id="edit_address" rows="3" class="form-control"></textarea>
                        </div>
                        <button id="updateBtn" class="btn btn-primary w-100">Update Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            function refreshStudentList() {
                $.ajax({
                    url: "{{ route('getStudents') }}", // Create a route to fetch all students
                    type: "GET",
                    success: function(response) {
                        let students = response.data;
                        $('#studentList').empty(); // Clear the table body

                        if (students.length === 0) {
                            $('#studentList').append(`
                    <tr>
                        <td colspan="5" class="text-center text-muted">No students found</td>
                    </tr>
                `);
                        } else {
                            $.each(students, function(index, student) {
                                $('#studentList').append(`
                        <tr>
                            <td>${student.name}</td>
                            <td>${student.email}</td>
                            <td>${student.phone}</td>
                            <td>${student.address}</td>
                            <td>
                                <button id="${student.id}" class="btn btn-info btn-sm viewBtn">View</button>
                                <button id="${student.id}" class="btn btn-primary btn-sm editBtn">Edit</button>
                                <button id="${student.id}" class="btn btn-danger btn-sm deleteBtn">Delete</button>
                            </td>
                        </tr>
                    `);
                            });
                        }
                    },
                    error: function() {
                        alert('Error fetching student list');
                    }
                });
            }

            // Add student
            $('#addBtn').on('click', function(event) {
                event.preventDefault();
                let dataObj = new FormData($("#studentForm")[0]);

                $.ajax({
                    url: "{{ route('addStudent') }}",
                    type: "POST",
                    data: dataObj,
                    contentType: false,
                    processData: false,
                    success: function() {
                        $("#studentForm")[0].reset();
                        $('#addStudentModal').modal('hide');
                        refreshStudentList();
                    }
                });
            });

            // delete student
            $("#studentList").on('click', '.deleteBtn', function() {
                let id = $(this).attr('id');

                $.ajax({
                    url: "{{ route('deleteStudent') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        refreshStudentList();
                    },

                });

            });

            // view Student
            $("#studentList").on('click', '.viewBtn', function() {
                let id = $(this).attr('id');

                $.ajax({
                    url: "{{ route('viewStudent') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        let student = response.data;
                        $('#view_name').text(student.name);
                        $('#view_email').text(student.email);
                        $('#view_phone').text(student.phone);
                        $('#view_address').text(student.address);
                        $('#viewStudentModal').modal('show');
                    },
                });
            });

            // Edit Student
            $("#studentList").on('click', '.editBtn', function() {

                let id = $(this).attr('id');

                $.ajax({
                    url: "{{ route('viewStudent') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        let student = response.data;
                        console.log(student);
                        $('#edit_id').val(student.id);
                        $('#edit_name').val(student.name);
                        $('#edit_email').val(student.email);
                        $('#edit_phone').val(student.phone);
                        $('#edit_address').val(student.address);
                        $('#editStudentModal').modal('show');
                    },
                });
            });

            // update student
            $('#updateBtn').on('click', function(event) {
                event.preventDefault();
                let dataObj = new FormData($("#editStudentForm")[0]);

                $.ajax({
                    url: "{{ route('updateStudent') }}",
                    type: "POST",
                    data: dataObj,
                    contentType: false,
                    processData: false,
                    success: function() {
                        $("#editStudentForm")[0].reset();
                        $('#editStudentModal').modal('hide');
                        refreshStudentList();
                    }
                });
            });

            // fetch states based on country

            $('#country').on('change', function() {
                let countryId = $(this).val();
                $.ajax({
                    url: "{{ route('getStates') }}",
                    type: "POST",
                    data: {
                        country_id: countryId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response.data);
                        let states = response.data;
                        $('#state').empty();
                        $('#state').append(
                            `<option value="" disabled selected>Select State</option>`
                        );
                        $.each(states, function(index, state) {
                            $('#state').append(
                                `<option value="${state.id}">${state.name}</option>`
                            );
                        });
                    },
                });
            });

            // fetch cities based on state
            $('#state').on('change', function() {
                let stateId = $(this).val();
                $.ajax({
                    url: "{{ route('getCities') }}",
                    type: "POST",
                    data: {
                        state_id: stateId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        let cities = response.data;
                        $('#city').empty();
                        $('#city').append(
                            `<option value="" disabled selected>Select City</option>`
                        );
                        $.each(cities, function(index, city) {
                            $('#city').append(
                                `<option value="${city.id}">${city.name}</option>`
                            );
                        });
                    }
                });
            });


        });
    </script>
</body>

</html>
