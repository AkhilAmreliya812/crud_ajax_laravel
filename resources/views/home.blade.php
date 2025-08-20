<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student CRUD</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Student List</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal">
            + Add New Student
        </button>
    </div>

    <!-- Student Table -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="studentList"></tbody>
        <tr id="noData" style="display: none;">
            <td colspan="5" class="text-center text-muted">No students found</td>
        </tr>
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
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                        <button id="updateBtn" class="btn btn-warning w-100">Update Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            fetchData();

            // Fetch student data
            function fetchData() {
                $.ajax({
                    url: "{{ route('getStudents') }}",
                    type: "GET",
                    success: function(response) {
                        let students = response.data;
                        let studentList = $('#studentList');
                        studentList.empty();

                        if (!students || students.length === 0) {
                            $('#noData').show();
                            return;
                        }

                        $('#noData').hide();
                        $.each(students, function(index, student) {
                            studentList.append(
                                `<tr>
                  <td>${student.name}</td>
                  <td>${student.email}</td>
                  <td>${student.phone}</td>
                  <td>${student.address}</td>
                  <td>
                    <button id="${student.id}" class="btn btn-warning btn-sm editBtn">Edit</button>
                    <button id="${student.id}" class="btn btn-danger btn-sm deleteBtn">Delete</button>
                    <button id="${student.id}" class="btn btn-info btn-sm viewBtn">View</button>
                  </td>
                </tr>`
                            );
                        });
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
                        fetchData();
                    }
                });
            });

            
            $("#studentList").on('click', '.deleteBtn', function() {
                let id = $(this).attr('id');
                
                $.ajax({
                    url: "{{ route('deleteStudent') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        fetchData();
                        alert(response.message);
                    },
                    error: function() {
                        
                    }
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
                        $('#edit_phone').text(student.phone);
                        $('#view_address').text(student.address);
                        $('#viewStudentModal').modal('show');
                    },
                    error: function() {
                        
                    }
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
                    error: function() {
                        
                    }
                });
            });

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
                        fetchData();
                    }
                });
            });
        });
    </script>

</body>

</html>
