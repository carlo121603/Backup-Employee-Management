<?php
include "db_Connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
        // PERSONAL INFORMATION
    $firstName = $_POST['firstName'];
    $middleName =  $_POST['middleName'];
    $lastName = $_POST['lastName'];


    $homeAddress =  $_POST['homeAddress'];
    $zipCodeEmployee = $_POST['zipCode'];
    
    $DOB =  $_POST['dob'];
    $Gender = $_POST['gender'];

    $Nationality =  $_POST['nationality'];
    $maritalStatus =  $_POST['maritalStatus'];


    // EMPLOYMENT DETAILS
    $Position = $_POST['position'];
    $employeeType =  $_POST['employeeType'];
    $bankAccount = $_POST['bankAccount'];


    $pagibigNumber =  $_POST['pagibigNumber'];
    $sssNumber = $_POST['sssNumber'];

    $tinNumber =  $_POST['tinNumber'];
    $philhealthNumber = $_POST['philhealthNumber'];

    $basicSalary =  $_POST['basicSalary'];
    $allowances =  $_POST['allowances'];
    $payrollType =  $_POST['payrollType'];

    $department =  $_POST['department'];
    $manager =  $_POST['manager'];


    // CONTACT INFORMATION TAB
    $contactNumber = $_POST['contactNumber'];
    $email =  $_POST['email'];

    $emergencyName = $_POST['emergencyName'];
    $emergencyContact =  $_POST['emergencyContact'];
    $emergencyRelationship = $_POST['emergencyRelationship'];



  // Insert into employees table
    $stmt = $conn->prepare("
        INSERT INTO employees (
            first_name, middle_name, last_name, home_address, zip_code,
            date_of_birth, gender, nationality, marital_status,
            position, employee_type, bank_account_number, pagibig_number,
            sss_number, tin_number, philhealth_number, basic_salary,
            allowances, payroll_type, department, manager,
            contact_number, email, emergency_name, emergency_contact, emergency_relationship
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
  $stmt -> bind_param("ssssssssssssssssssssssssss", $firstName, $middleName,  $lastName,  $homeAddress, $zipCodeEmployee,  $DOB,  $Gender, $Nationality, $maritalStatus, $Position, $employeeType, $bankAccount, $pagibigNumber, $sssNumber, $tinNumber, $philhealthNumber, $basicSalary, $allowances, $payrollType, $department, $manager, $contactNumber, $email, $emergencyName, $emergencyContact, $emergencyRelationship);
  
   if ($stmt->execute()) {
        echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Record inserted successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = 'Employee_Management.php'; // Optionally redirect
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Error inserting record.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
}
