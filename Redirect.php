<?php
session_start();

// List of allowed pages (for security purposes)
$allowed_pages = [
    'Dashboard.php', 
    'Employee_Management.php',
    'Payroll_Management.php',
    'Generate_Payslip.php',
    'submenu/sss_Report.php',
    'submenu/pag-ibig_Report.php',
    'submenu/philhealth_Report.php',
    'submenu/tax_Report.php',
    'submenu/top_Sheet.php',
    'submenu/journal_Entry.php'
];

// Get the target page from the query parameter
$page = isset($_GET['page']) ? $_GET['page'] : 'Dashboard.php';

// Validate the page to prevent unauthorized redirects (optional)
if (in_array($page, $allowed_pages)) {
    header("Location: $page");
    exit();  // Ensure no further code execution after the redirection
} else {
    // Redirect to a default page or show an error if the page is invalid
    header("Location: Dashboard.php");
    exit();
}

