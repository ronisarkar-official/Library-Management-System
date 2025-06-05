<?php
include('loader.php');
?>
<?php 
include('connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mcet landing page with login</title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">
    <link rel="stylesheet" href="style.css">
    <header>
       <h2 class="logo">MCET</h2> 
       <nav class="nav">
        <a href="index.php">Home</a>
        <a href="about-us.php">About Us</a>
        <a href="contact.php">Contact Us</a>
        <button class="btnlogin-popup">Login</button>
        </nav>
    </header>
    <div class="wrapper">
        <span class="icon-close"><ion-icon 
            name="close"></ion-icon></span>
        <div class="form-box login">
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <div class="input-box">
                    <span class="icon"><i class="fa-light fa-envelope"></i></span>
                    <input type="email" name="email" required >
                    <label>Email</label>            
                </div>
                <div class="input-box">
                    <span class="icon"><i class="fa-light fa-lock"></i></span>
                    <input type="password" name="password" required>
                    <label>password</label>            
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">
                    Remember me</label>
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit" class="btn" name="submit" >Login</button>
                <div class="login-register">
                    <p>Don't have an account?<a href="#" 
                        class="register-link">Register</a></p>
                </div>
            </form>
        </div> 
        <div class="form-box register">
            <h2>Registration</h2>
            <form action="#" method="POST">
                <div class="input-box">
                    <span class="icon"><ion-icon
                    name="person"></ion-icon></span>
                    <input type="text" name="username" required>
                    <label>Username</label>            
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon
                    name="mail"></ion-icon></span>
                    <input type="email" name="email" required>
                    <label>Email</label>            
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon
                    name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" required>
                    <label>password</label>            
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">
                    I agree to the terms & conditions</label>
                </div>
                <input type="submit" value="Register" class="btn" name="register">
                <div class="login-register">
                    <p>Already have an account?<a href="#" 
                        class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>



<?php
if (isset($_POST['register'])) {
    $name = $_POST['username'];
    $mail = $_POST['email'];
    $pass = $_POST['password'];
    
    // Assuming you have the connection to the database set up
    $query = "INSERT INTO admin (username, email, password) VALUES ('$name', '$mail', '$pass')"; 
    
    $data = mysqli_query($conn, $query);
    
    // Check if the query was successful
    if ($data) {
        // Show success alert
        echo "<script>alert('Registration successful!');</script>";
    } else {
        // Show failure alert
        echo "<script>alert('Registration failed. Please try again.');</script>";
    }
}
?>

