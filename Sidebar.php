<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: Login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="Styles/Style.css">
</head>
  <body>
    
    <div class="header">
        <div class="logo">
          <button class="toggle-btn" id="toggle-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="24" height="24">
              <path fill="#000000" d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
            </svg>
          </button>
          <a href="index.php"><img class="d-sm-none d-md-block" src="images/logo.png" alt="Neuralcore Logo"></a>
        </div>
        <div class="user-welcome">Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</div>
      </div>
  
      <!-- SIDEBARS -->
      <div class="sidebar" id="sidebar">
          <p class="green-spacer"></p>

          <a class="mt-1" href="redirect.php?page=Dashboard.php">
              <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
          </a>

          <a class="mt-1" href="redirect.php?page=Employee_Management.php">
              <i class="fas fa-users"></i> <span>Employee Management</span>
          </a>

          <a class="mt-1" href="redirect.php?page=Payroll%20Management.php">
              <i class="fas fa-money-check-alt"></i> <span>Payroll Management</span>
          </a>

          <a class="mt-1 menu-item" href="#" id="payrollReports" onclick="toggleSubMenu(event)">
              <i class="fas fa-file-invoice-dollar"></i>
              <span>Payroll Reports</span>
              <i id="toggleIcon" class="fas fa-chevron-right"></i>
          </a>

          <!-- Collapsible Submenu -->
          <div class="mt-1 submenu" id="payrollSubMenu" style="display: none;">
              <a href="redirect.php?page=submenu/sss_Report.php" class="submenu-item mt-1">SSS Report</a>
              <a href="redirect.php?page=submenu/pag-ibig_Report.php" class="submenu-item mt-1">Pag-IBIG Report</a>
              <a href="redirect.php?page=submenu/philhealth_Report.php" class="submenu-item mt-1">PhilHealth Report</a>
              <a href="redirect.php?page=submenu/tax_Report.php" class="submenu-item mt-1">Tax Report</a>
              <a href="redirect.php?page=submenu/top_Sheet.php" class="submenu-item mt-1">Top Sheet</a>
              <a href="redirect.php?page=submenu/journal_Entry.php" class="submenu-item mt-1">Journal Entry</a>
          </div>

          <a class="mt-1" href="redirect.php?page=Generate%20Payslip.php">
              <i class="fas fa-receipt"></i> <span>Generate Payslip</span>
          </a>

          <a class="mt-1" href="#" onclick="confirmLogout()">
              <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
          </a>
      </div>


      <script src="Scripts/toggle-Btn.js"></script>
    </body>
</html>