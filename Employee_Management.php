<?php
include "db_Connection.php";

// Query to fetch employee records
$sql = "SELECT id, first_name, middle_name, last_name, position, email, contact_number, date_of_birth, manager, department, status
    FROM employees WHERE is_active = '1'";

$result = $conn->query($sql);
?>
<?php
function toPascalCase($string) {
    // Convert the string to lowercase and capitalize the first letter of each word
    $string = ucwords(strtolower($string));
    return $string; // No need to remove spaces now
}
function formatDepartment($department) {
    // Check if the department is one of the specified values and convert it to uppercase
    $validDepartments = ['HR', 'IT', 'Finance'];
    if (in_array(strtoupper($department), $validDepartments)) {
        return strtoupper($department); // Return the department in uppercase if valid
    }
    return $department; // Return the original department if not in the valid list
}
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <!-- Button to trigger the modal -->
                <form action="upload_excel.php" method="POST" enctype="multipart/form-data">
                    <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#uploadExcelModal">
                        <i class="fas fa-upload"></i> Upload Masterlist
                    </button>
                </form>
                <button class="btn btn-purple btn-sm" onclick="window.location.href='download_masterlist.php'">
                    <i class="fas fa-download"></i> Download Masterlist
                </button>
            </div>
    </div>

        <!-- Modal for uploading Excel file -->
    <div class="modal fade" id="uploadExcelModal" tabindex="-1" aria-labelledby="uploadExcelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadExcelModalLabel">Upload Excel File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="upload_excel.php" method="POST" enctype="multipart/form-data" id="uploadExcelForm">
                        <div class="mb-3">
                            <label for="excelFile" class="form-label">Choose Excel File</label>
                            <input type="file" class="form-control" name="excelFile" id="excelFile" accept=".xlsx,.xls" required>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


        <!-- Include Modal Form PHP File -->
        <?php include 'Add Employee.php'; ?>

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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <?php
                        // Concatenate the full name
                        $fullName = toPascalCase($row["first_name"]) . " " . toPascalCase($row["middle_name"]) . " " . toPascalCase($row["last_name"]);
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($fullName); ?></td>
                            <td><?php echo htmlspecialchars(toPascalCase($row['position'])); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                            <td><?php echo htmlspecialchars(toPascalCase($row['manager'])); ?></td>
                            <td><?php echo htmlspecialchars(formatDepartment($row['department'])); ?></td>
                            <td>
                                <?php 
                                    if ($row['status'] === 'Employed') {
                                        echo '<span class="badge bg-success text-white p-2">Employed</span>';
                                    } elseif ($row['status'] === 'Terminated') {
                                        echo '<span class="badge bg-danger text-white p-2">Terminated</span>';
                                    } elseif ($row['status'] === 'AWOL') {
                                        echo '<span class="badge bg-secondary text-white p-2">AWOL</span>';
                                    } elseif ($row['status'] === 'Suspended') {
                                        echo '<span class="badge bg-warning text-dark p-2">Suspended</span>';
                                    } else {
                                        echo '<span class="badge bg-dark text-white p-2">Unknown</span>';
                                    }                                    
                                ?>
                            </td>
                            <td class="text-nowrap">
                                <a href="edit_employee.php?id=<?php echo $row['id']; ?>" class="btn btn-xs btn-primary me-1 px-2 py-1" style="font-size: 12px;">
                                    <i class="fas fa-edit" style="font-size: 9px;"></i> Edit
                                </a>
                                <button class="btn btn-xs btn-danger px-2 py-1" style="font-size: 12px;" data-id="<?php echo $row['id']; ?>">
                                    <i class="fas fa-trash" style="font-size: 9px;"></i> Delete
                                </button>
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

        // Handle the form submission
        $('#editForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize(); // Get form data

            $.ajax({
                url: 'update_employee.php', // PHP script to update employee data
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Show success message with SweetAlert
                    Swal.fire('Success', 'Employee details updated', 'success');
                    $('#editModal').modal('hide'); // Close the modal
                    location.reload(); // Reload the page to reflect changes
                },
                error: function() {
                    Swal.fire('Error', 'Failed to update employee details', 'error');
                }
            });
        });
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
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Employee has been deleted.',
                            icon: 'success',
                            timer: 1000, 
                            showConfirmButton: false
                        }).then(() => {
                            location.reload(); // Reload after the alert disappears
                        });
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
    <script>
    $(document).ready(function() {
        // Handle the Upload Masterlist button click
        $('form[action="upload_excel.php"]').submit(function(event) {
            event.preventDefault(); // Prevent the form from submitting immediately

            // Show SweetAlert before form submission
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to upload the masterlist?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, upload it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    $(this).unbind('submit').submit();
                    Swal.fire('Uploading...', 'Your masterlist is being uploaded.', 'success');
                } else {
                    Swal.fire('Cancelled', 'The upload has been cancelled.', 'error');
                }
            });
        });
    });
</script>
</body>
</html>