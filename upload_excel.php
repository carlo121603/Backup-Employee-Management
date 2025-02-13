<?php
require 'vendor/autoload.php';
include "db_Connection.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

$message = ''; // Stores success or error message
$alertType = ''; // Determines SweetAlert type (success/error)
$redirectURL = 'http://localhost/PayrollSecure/Employee_Management.php'; // Redirection link

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excelFile'])) {
    $file = $_FILES['excelFile']['tmp_name'];

    try {
        // Load the Excel file
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();

        // Array to store results
        $results = [
            'success' => [],
            'errors' => []
        ];

        // Iterate through the rows and insert data into the database
        foreach ($sheet->getRowIterator(2) as $row) { // Start from row 2 (assuming row 1 is the header)
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);

            $data = [];
            foreach ($cellIterator as $cell) {
                $data[] = trim($cell->getValue()); // Trim whitespace
            }

            // Ensure the row has the expected number of columns
            if (count($data) < 8) { // 8 columns expected: ID, Full Name, Position, Email, Number, Manager, Department, Status
                $results['errors'][] = "Row has missing data: " . implode(', ', $data);
                continue;
            }

            // Get ID from Excel file
            $id = intval($data[0]); // ID is in the first column

            // Check if the ID already exists in the database
            $stmt = $conn->prepare("SELECT id FROM employees WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $results['errors'][] = "ID $id already exists. Please change the ID.";
                continue;
            }

            // Ensure the Full Name is correctly split
            $fullName = preg_split('/\s+/', trim($data[1]), 3);
            $firstName = $fullName[0] ?? '';
            $middleName = $fullName[1] ?? '';
            $lastName = $fullName[2] ?? '';

            $position = $data[2] ?? '';
            $email = $data[3] ?? '';
            $contactNumber = $data[4] ?? '';
            $manager = $data[5] ?? '';
            $department = $data[6] ?? '';
            $status = $data[7] ?? '';

            // Insert data into the database
            $sql = "INSERT INTO employees (id, first_name, middle_name, last_name, position, email, contact_number, manager, department, status, is_active)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '1')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssssssss", $id, $firstName, $middleName, $lastName, $position, $email, $contactNumber, $manager, $department, $status);

            if ($stmt->execute()) {
                $results['success'][] = "ID $id: $firstName $lastName added successfully.";
            } else {
                $results['errors'][] = "ID $id: Failed to add $firstName $lastName. Error: " . $stmt->error;
            }
        }

       // Prepare the SweetAlert message
            if (!empty($results['errors'])) {
                $alertType = 'warning';
                $message = "ID already exists"; // Simplified message
            } elseif (!empty($results['success'])) {
                $alertType = 'success';
                $message = "Upload successful! The following entries were added:";
            }
                } catch (Exception $e) {
                    $alertType = 'error';
                    $message = 'Error processing file: ' . $e->getMessage();
                }

    // Output the SweetAlert script
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: '" . ucfirst($alertType) . "',
                text:`" . nl2br(htmlspecialchars($message)) . "`,
                icon: '" . $alertType . "'
            }).then(() => {
                window.location.href = '$redirectURL';
            });
        });
    </script>";
    exit; // Ensure no extra content is sent after the alert
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="excelFile" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>