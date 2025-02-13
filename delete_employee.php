<?php
include "db_Connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeId = $_POST['id'];

    // Update the status to 'inactive'
    $stmt = $conn->prepare("UPDATE employees SET is_active='0' WHERE id=?");
    $stmt->bind_param("i", $employeeId);

    if ($stmt->execute()) {
        echo "Employee marked as inactive";
    } else {
        echo "Error marking employee as inactive";
    }
}
