<?php
session_start();
session_destroy();
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</head>
<body>
    <script>
        Swal.fire({
            title: 'Logout Successful!',
            text: 'Redirecting to login page...',
            icon: 'success',
            timer: 1000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = 'http://localhost/PayrollSecure/login.php';
        });
    </script>
</body>
</html>";
?>