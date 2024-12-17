<?php 
$conn=mysqli_connect("localhost","u357634566_library","Ghost@8972134437","u357634566_college");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character encoding and responsive design -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Title of the page displayed in the browser tab -->
    <title>Admin dashboard</title>
    
    <!-- Linking the external CSS file for styling -->
    <link rel="stylesheet" href="style.css">

    <!-- Inline CSS for specific styles of the registration form -->
    <style>
        /* Style to center the registration form in the page */
        .bd {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Styling the registration form container */
        .register {
            width: 750px;
            background-color: #fefefe;
            border-radius: 10px;
            color: #000000;
            padding: 40px 35px 55px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Style for the registration form header */
        .register h1 {
            font-size: 36px;
            text-align: center;
            margin-bottom: 20px;
            color: rgb(79 70 229);
            font-weight: 500;
        }

        /* Input box style */
        .register .input-box {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        /* Style for individual input fields */
        .input-box .input-field {
            position: relative;
            width: 48%;
            margin: 13px 0;
            height: 50px;
        }

        /* Style for input elements */
        .input-box .input-field input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: 2px solid #747070;
            outline: none;
            font-size: 16px;
            color: #020202;
            border-radius: 6px;
            padding: 15px 15px 15px 40px;
        }

        /* Style for input placeholders */
        .input-box .input-field input::placeholder {
            color: #000000;
        }

        /* Style for icons inside input fields */
        .input-box .input-field i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 21px;
        }

        /* Styling the submit button */
        .register .button {
            width: 100%;
            height: 45px;
            background-color: #4f46e5;
            border: none;
            outline: none;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            cursor: pointer;
            font-size: 16px;
            color: #ffffff;
            font-weight: 600;
        }
    </style>
</head>
<body>

  <!-- Including layout.php to load the layout for the admin page -->
  <?php include('layout.php'); ?>

    <div class="bd">
        <!-- Registration form container -->
        <div class="register">
            <form action="#" method="POST">
                <!-- Registration form header -->
                <h1>STUDENT REGISTRATION</h1>

                <div class="input-box">
                    <!-- Input field for full name -->
                    <div class="input-field">
                        <input type="text" name="fname" class="Fname" placeholder="FULL NAME" required>
                        <i class="fa-light fa-user"></i>
                    </div>

                    <!-- Input field for email -->
                    <div class="input-field">
                        <input type="email" name="email" class="Fname" placeholder="EMAIL" required>
                        <i class="fa-light fa-envelope"></i>
                    </div>

                    <!-- Input field for phone number -->
                    <div class="input-field">
                        <input type="text" name="phone" class="Fname" placeholder="PHONE NO" required>
                        <i class="fa-light fa-phone"></i>
                    </div>

                    <!-- Input field for class roll number -->
                    <div class="input-field">
                        <input type="text" name="class" class="Fname" placeholder="CLASS ROLL" required>
                        <i class="fa-light fa-clipboard-user"></i>
                    </div>

                    <!-- Input field for student ID -->
                    <div class="input-field">
                        <input type="text" name="id" class="Fname" placeholder="STUDENT ID" required>
                        <i class="fa-light fa-id-card"></i>
                    </div>
                </div>

                <!-- Submit button to register the student -->
                <input type="submit" value="Register" class="button" name="register">
            </form>
        </div>
    </div>
</body>
</html>

<?php
// Checking if the registration form was submitted
if (isset($_POST['register'])) {
    // Get the username, email, and password from the form input
    $name = $_POST['fname'];
    $mail = $_POST['email'];
    $phone = $_POST['phone'];
    $class = $_POST['class'];
    $id = $_POST['id'];
    
    // Insert the new user data into the admin table in the database
    $query = "INSERT INTO student (first_name, email, student_id, phone_number, class_roll) 
    VALUES ('$name', '$mail', '$id', '$phone', '$class')"; 
    
    // Execute the query and insert data into the database
    $data = mysqli_query($conn, $query);
    
    // If the query was successful, show a success alert
    if ($data) {
        echo "<script>alert('Registration successful!');</script>";
    } else {
        // If the query failed, show an error alert
        echo "<script>alert('Registration failed. Please try again.');</script>";
    }
}
?>