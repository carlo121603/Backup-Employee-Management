<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="Styles/Login_Styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<div class="login-container">
    <img src="images/nlogo.jpg" alt="Neuralcore Logo" class="logo">

    <form action="Authentication.php" method="POST" onsubmit="return validateForm()">
      <div class="mb-3">
        <input type="text" class="form-control" name="username" id="username" placeholder="Email/Username">
      </div>

      <div class="mb-3">
        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
      </div>

      <button type="submit" class="btn btn-success w-100">Sign in</button>
    </form>

    <a href="#" class="d-block mt-2 text-center">Forgot Password?</a>
  </div>

  <script>
    function validateForm() {
      let username = document.getElementById("username").value.trim();
      let password = document.getElementById("password").value.trim();
      
      if (username === "" || password === "") {
        Swal.fire({
          icon: 'warning',
          title: 'Oops...',
          text: 'Please fill in all fields!'
        });
        return false;
      }
      return true;
    }

    // Show SweetAlert messages from `auth.php`
    <?php
    if (isset($_SESSION['error'])) {
      echo "Swal.fire({
              icon: 'error',
              title: 'Login Failed',
              text: '" . $_SESSION['error'] . "'
            });";
      unset($_SESSION['error']); // Remove error after showing
    }

    if (isset($_SESSION['success'])) {
      echo "Swal.fire({
              icon: 'success',
              title: 'Login Successful',
              text: 'Redirecting to homepage...',
              timer: 2000,
              showConfirmButton: false
            }).then(() => {
              window.location.href = 'http://localhost/PayrollSecure/index.php';
            });";
      unset($_SESSION['success']); // Remove success message after showing
    }
    ?>
  </script>
</body>
</html>