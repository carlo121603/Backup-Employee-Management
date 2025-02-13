<?php
include "db_Connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeId = $_POST['id']; // Employee ID
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    // Get other form fields here...

    $stmt = $conn->prepare("UPDATE employees SET first_name=?, last_name=? WHERE id=?");
    // Bind other fields as necessary
    $stmt->bind_param("ssi", $firstName, $lastName, $employeeId);

    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record";
    }
}
?>
