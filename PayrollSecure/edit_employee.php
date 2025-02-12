<?php
include "db_Connection.php";  // Include database connection

// Handle form submission (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data from the form
    $id = $_POST['id'];  // Employee ID
    $fullName = $_POST['full_name'];  // Full name from form
    $position = $_POST['position'];  // Position from form
    $email = $_POST['email'];  // Email from form
    $number = $_POST['number'];  // Contact number from form
    $manager = $_POST['manager'];  // Manager from form
    $department = $_POST['department'];  // Department from form
    $status = $_POST['status'];  // Status from form

    // Split the full name into first, middle, and last names
    $names = explode(' ', $fullName);
    $firstName = $names[0];  // First name
    $middleName = isset($names[1]) ? $names[1] : '';  // Middle name (optional)
    $lastName = isset($names[2]) ? $names[2] : '';  // Last name

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
            $stmt->bind_param("sssssssssi", $firstName, $middleName, $lastName, $position, $email, $number, $manager, $department, $id);
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
               <form action="edit_employee.php" method="POST" onsubmit="return confirmEdit()">

                    <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">

                    <!-- Full Name Field -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="full_name" value="<?php echo $employee['first_name'] . ' ' . $employee['middle_name'] . ' ' . $employee['last_name']; ?>" required>
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
                            <option value="Active" <?php echo ($employee['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                            <option value="Inactive" <?php echo ($employee['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
    // SweetAlert2 confirmation function
    async function confirmEdit(event) {
        event.preventDefault(); // Prevent the form from submitting immediately
        
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

        if (result.isConfirmed) {
            // If confirmed, submit the form
            event.target.submit();
        }
    }
</script>


</body>
</html>