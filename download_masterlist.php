<?php
require 'db_Connection.php';

// Load PHPExcel library (install via Composer if not installed)
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set column headings
$sheet->setCellValue('A1', 'Employee Number');
$sheet->setCellValue('B1', 'Full Name');
$sheet->setCellValue('C1', 'Position');
$sheet->setCellValue('D1', 'Email');
$sheet->setCellValue('E1', 'Number');
$sheet->setCellValue('F1', 'Manager');
$sheet->setCellValue('G1', 'Department');
$sheet->setCellValue('H1', 'Status');

// Fetch employee records
$sql = "SELECT id, first_name, middle_name, last_name, position, email, contact_number, manager, department FROM employees WHERE is_active = '1'";
$result = $conn->query($sql);

$rowNumber = 2; // Start from the second row
while ($row = $result->fetch_assoc()) {
    $fullName = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
    
    $sheet->setCellValue('A' . $rowNumber, $row['id']);
    $sheet->setCellValue('B' . $rowNumber, $fullName);
    $sheet->setCellValue('C' . $rowNumber, $row['position']);
    $sheet->setCellValue('D' . $rowNumber, $row['email']);
    $sheet->setCellValue('E' . $rowNumber, $row['contact_number']);
    $sheet->setCellValue('F' . $rowNumber, $row['manager']);
    $sheet->setCellValue('G' . $rowNumber, $row['department']);
    $sheet->setCellValue('H' . $rowNumber, 'Employed');

    $rowNumber++;
}

// Set headers to force download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Employee_Masterlist.xlsx"');
header('Cache-Control: max-age=0');

// Save the spreadsheet to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

exit;
?>
