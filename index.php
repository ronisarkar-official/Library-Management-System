
<?php
// Start the session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Redirect to the admin dashboard if already logged in
    header("Location: admin/dashboard.php");
    exit();
}

// If not logged in, display the landing page content
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mcet landing page with login</title>
    <style>
        body{
            background: url('images/BGIS.png') no-repeat center/cover;   
        }
    </style>
</head>
<body>
<?php include('layoutt.php');?>
</body>
</html>



