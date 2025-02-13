<?php
include 'db_connection.php'; // Make sure your DB connection is included

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["firstName"];
    $middleName = $_POST["middleName"];
    $lastName = $_POST["lastName"];
    $homeAddress = $_POST["homeAddress"];
    $zipCode = $_POST["zipCode"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $nationality = $_POST["nationality"];
    $maritalStatus = $_POST["maritalStatus"];
    $position = $_POST["position"];
    $employeeType = $_POST["employeeType"];
    $bankAccount = $_POST["bankAccount"];
    $pagibigNumber = $_POST["pagibigNumber"];
    $sssNumber = $_POST["sssNumber"];
    $tinNumber = $_POST["tinNumber"];
    $philhealthNumber = $_POST["philhealthNumber"];
    $basicSalary = $_POST["basicSalary"];
    $allowances = $_POST["allowances"];
    $payrollType = $_POST["payrollType"];
    $department = $_POST["department"];
    $manager = $_POST["manager"];
    $contactNumber = $_POST["contactNumber"];
    $email = $_POST["email"];
    $emergencyName = $_POST["emergencyName"];
    $emergencyContact = $_POST["emergencyContact"];
    $emergencyRelationship = $_POST["emergencyRelationship"];

    // Insert into database
    $sql = "INSERT INTO employees (first_name, middle_name, last_name, home_address, zip_code, date_of_birth, gender, nationality, marital_status, position, employee_type, bank_account_number, pagibig_number, sss_number, tin_number, philhealth_number, basic_salary, allowances, payroll_type, department, manager, contact_number, email, emergency_name, emergency_contact, emergency_relationship)
            VALUES ('$firstName', '$middleName', '$lastName', '$homeAddress', '$zipCode', '$dob', '$gender', '$nationality', '$maritalStatus', '$position', '$employeeType', '$bankAccount', '$pagibigNumber', '$sssNumber', '$tinNumber', '$philhealthNumber', '$basicSalary', '$allowances', '$payrollType', '$department', '$manager', '$contactNumber', '$email', '$emergencyName', '$emergencyContact', '$emergencyRelationship')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . mysqli_error($conn)]);
    }

    mysqli_close($conn);
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>