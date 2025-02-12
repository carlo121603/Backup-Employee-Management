<?php
    include "db_Connection.php";

    // Query to fetch employee records
    $sql = "SELECT id, first_name, middle_name, last_name, position, email, contact_number, date_of_birth, manager, department 
        FROM employees WHERE is_active = '1'";


    // $sql = "SELECT id, first_name, middle_name, last_name, position, email, contact_number, date_of_birth, manager, department, employee_type FROM employees";
    $result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payroll</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="Style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

  <style>
        body{
            background-color: #F5FFFA !important;
        }
        .filters .btn {
            background-color: #f4f4f4;
            border: solid #000 1px;
            transition: background-color 0.4s ease; /* Smooth transition */
        }

        .filters .btn:hover {
            background-color: lightgray;
            border: solid #000 1px;
        }
        .employee-table{
            margin-top:30px;
            width: 100%;
            
        }
        .employee-table table {
    width: 100%;
    table-layout: auto;
}

        .table.table-striped {
            font-size:14px;
        }
        .btn-purple {
            background-color: #6f42c1 !important; 
            color: #FFFFFF !important;
        }
    </style>
</head>
  <body>
    <?php 
      include 'Sidebar.php';
    ?>
      <div class="main-content" id="main-content">
      <!-- Action Buttons -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="m-0">Employee Masterlist</h1>
            <div class="d-flex gap-2">
                <button class="btn btn-primary  btn-sm" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                    <i class="fas fa-user-plus"></i> Add Employee
                </button>
                <button class="btn btn-success  btn-sm"><i class="fas fa-upload"></i> Upload Masterlist</button>
                <button class="btn btn-purple  btn-sm"><i class="fas fa-download"></i> Download Masterlist</button>
            </div>
       </div>
        <!-- Include Modal Form PHP File -->
        <?php include 'Add Employee.php'; ?>
         <!-- Filter Buttons -->
        <!-- <div class="filters">
            <button class="btn">Show All</button>
            <button class="btn">Onboarding</button>
            <button class="btn">Offboarding</button>
        </div> -->

        <!-- Employee Table -->
        <div class="employee-table">
            <table id="employeeTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Employee Number</th>
                        <th>Full Name</th>
                        <th>Position</th>
                        <th>Email</th>
                        <th>Number</th>
                        <th>Manager</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PASTE HERE -->
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <?php
                        // Concatenate the full name
                        $fullName = $row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"];
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($fullName); ?></td>
                            <td><?php echo htmlspecialchars($row['position']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['manager']); ?></td>
                            <td><?php echo htmlspecialchars($row['department']); ?></td>
                            <td><span class="badge bg-success text-white">Employed</span></td>
                            <td><i class="fas fa-file-alt"></i></td>
                            <td class="text-nowrap">
                                <!-- Direct the user to the edit page with the employee ID -->
                                <a href="edit_employee.php?id=<?php echo $row['id']; ?>" class="btn btn-xs btn-primary me-1 px-2 py-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button class="btn btn-xs btn-danger px-2 py-1" data-id="<?php echo $row['id']; ?>"><i class="fas fa-trash"></i> Delete</button>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

  

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // When the edit button is clicked
    $('#employeeTable').on('click', '.btn-primary', function() {
        var employeeId = $(this).data('id');
        // Fetch employee data using AJAX and populate the form
        $.ajax({
            url: 'get_employee.php', // PHP script to fetch employee data
            type: 'GET',
            data: { id: employeeId },
            success: function(response) {
                var employee = JSON.parse(response);
                $('#editFirstName').val(employee.first_name);
                $('#editLastName').val(employee.last_name);
                // Populate other fields here...
            }
        });
    });

    // // Handle the form submission
    // $('#editForm').submit(function(event) {
    //     event.preventDefault();
    //     var formData = $(this).serialize(); // Get form data

    //     $.ajax({
    //         url: 'update_employee.php', // PHP script to update employee data
    //         type: 'POST',
    //         data: formData,
    //         success: function(response) {
    //             // Show success message with SweetAlert
    //             Swal.fire('Success', 'Employee details updated', 'success');
    //             $('#editModal').modal('hide'); // Close the modal
    //             location.reload(); // Reload the page to reflect changes
    //         },
    //         error: function() {
    //             Swal.fire('Error', 'Failed to update employee details', 'error');
    //         }
    //     });
    // });
});
</script>
<script>
$('#employeeTable').on('click', '.btn-danger', function() {
    var employeeId = $(this).data('id');
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'delete_employee.php', // PHP script to mark the record as inactive
                type: 'POST',
                data: { id: employeeId },
                success: function(response) {
                    Swal.fire('Deleted!', 'Employee has been deleted.', 'success');
                    location.reload(); // Reload to hide the deleted employee
                },
                error: function() {
                    Swal.fire('Error!', 'Failed to delete employee.', 'error');
                }
            });
        }
    });
});
</script>

        <!-- Bootstrap JS (Ensure that Bootstrap JS and jQuery are loaded) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#employeeTable').DataTable();
    });
    </script>
    

  </body>
</html>