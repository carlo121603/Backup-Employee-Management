<?php
include "db_Connection.php";  // Include database connection

// Handle form submission (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data from the form
    $id = $_POST['id'];  // Employee ID
    $firstName = $_POST['first_name'];  // First name from form
    $middleName = $_POST['middle_name'];  // Middle name from form
    $lastName = $_POST['last_name'];  // Last name from form
    $position = $_POST['position'];  // Position from form
    $email = $_POST['email'];  // Email from form
    $number = $_POST['number'];  // Contact number from form
    $manager = $_POST['manager'];  // Manager from form
    $department = $_POST['department'];  // Department from form
    $status = $_POST['status'];  // Status from form

    // Check if the status has changed
    $currentStatus = $employee['status'];  // Current status from database
    $statusChanged = ($status !== $currentStatus);

    // Update query to save the changes in the database
    $sql = "UPDATE employees SET first_name = ?, middle_name = ?, last_name = ?, position = ?, email = ?, contact_number = ?, manager = ?, department = ? ";
    if ($statusChanged) {
        $sql .= ", status = ?";  // Only add status to update if it has changed
    }
    $sql .= " WHERE id = ?";

    // Prepare the SQL query
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters dynamically based on whether the status is being updated
        if ($statusChanged) {
            $stmt->bind_param("sssssssssi", $firstName, $middleName, $lastName, $position, $email, $number, $manager, $department, $status, $id);
        } else {
            $stmt->bind_param("ssssssssi", $firstName, $middleName, $lastName, $position, $email, $number, $manager, $department, $id);
        }

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Employee record updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.href = 'Employee_Management.php'; // Redirect after success
                    });
                </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error updating record: " . $stmt->error . "',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Error preparing the statement: " . $conn->error . "',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
}

// Fetch employee data for the given ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM employees WHERE id = $id");
    $employee = $result->fetch_assoc();
} else {
    // Redirect if no employee ID is provided
    header("Location: Employee_Management.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 pt-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Employee</h5>
            </div>
            <div class="card-body">
                <form action="edit_employee.php" method="POST" onsubmit="return confirmEdit(event, this)">
                    <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">

                    <!-- First Name Field -->
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $employee['first_name']; ?>" required>
                    </div>

                    <!-- Middle Name Field -->
                    <div class="mb-3">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo $employee['middle_name']; ?>">
                    </div>

                    <!-- Last Name Field -->
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $employee['last_name']; ?>" >
                    </div>

                    <!-- Position Field -->
                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" class="form-control" id="position" name="position" value="<?php echo $employee['position']; ?>" required>
                    </div>

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $employee['email']; ?>" required>
                    </div>

                    <!-- Number Field -->
                    <div class="mb-3">
                        <label for="number" class="form-label">Number</label>
                        <input type="tel" class="form-control" id="number" name="number" value="<?php echo $employee['contact_number']; ?>" required>
                    </div>

                    <!-- Manager Field -->
                    <div class="mb-3">
                        <label for="manager" class="form-label">Manager</label>
                        <input type="text" class="form-control" id="manager" name="manager" value="<?php echo $employee['manager']; ?>" required>
                    </div>

                    <!-- Department Field -->
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" class="form-control" id="department" name="department" value="<?php echo $employee['department']; ?>" required>
                    </div>

                    <!-- Status Field -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Employed" <?php echo ($employee['status'] == 'Employed') ? 'selected' : ''; ?>>Employed</option>
                            <option value="Terminated" <?php echo ($employee['status'] == 'Terminated') ? 'selected' : ''; ?>>Terminated</option>
                            
                            <option value="AWOL" <?php echo ($employee['status'] == 'AWOL') ? 'selected' : ''; ?>>AWOL</option>

                            <option value="Suspended" <?php echo ($employee['status'] == 'Suspended') ? 'selected' : ''; ?>>Suspended</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="http://localhost/PayrollSecure/Employee_Management.php" class="btn btn-secondary">Cancel</a>
                     </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Function to handle form submission
    async function confirmEdit(event, form) {
        event.preventDefault(); // Prevent default form submission

        // Show confirmation alert
        const result = await Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to save the changes?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save changes!',
            cancelButtonText: 'Cancel'
        });

        // If user confirms, submit the form via AJAX
        if (result.isConfirmed) {
            let formData = new FormData(form); // Collect form data

            // Send form data using fetch API
            fetch(form.action, {
                method: "POST",
                body: formData
            })
            .then(response => response.text()) 
            .then(data => {
                // If PHP execution was successful, trigger success pop-up
                Swal.fire({
                    title: 'Success!',
                    text: 'Employee record updated successfully.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'Employee_Management.php'; // Redirect after alert
                });
            })
            .catch(error => {
                // Show error if fetch request fails
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }
    }
</script>
</body>
</html>

