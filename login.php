<?php
// Starting the session
session_start();

// Including the database connection
include('connect.php');

// Checking if the login form was submitted
if (isset($_POST['submit'])) {
    // Trim whitespace from input values
    $mail = trim($_POST['email']);
    $pass = trim($_POST['password']);

    // Using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $mail); // Bind the email input
    $stmt->execute();
    $result = $stmt->get_result(); // Execute the query and get the result

    // Checking if the email exists in the database
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc(); // Fetch the row containing the user's info

        // Comparing the entered password with the stored password (should be hashed)
        if ($pass === $row['password']) { // **Note: Passwords should be hashed using `password_hash`**
            // Set session variables for authentication
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['id']; // Store user ID
            $_SESSION['email'] = $row['email']; // Store user email

            // Redirect to the admin dashboard
            header("Location: admin/dashboard.php");
            exit(); // Ensures the script stops after redirection
        } else {
            // Redirect to the home page with an alert if the password is incorrect
            echo "<script>
                alert('Login failed. Apnar email r password vhul !');
                window.location.href = 'default.php'; // Redirect to home page
                </script>";
        }
    } else {
        // Redirect to the home page with an alert if the email is not found
        echo "<script>
            alert('Login failed. Apnar email r password vhul !');
            window.location.href = 'default.php'; // Redirect to home page
            </script>";
    }

    // Close the statement and connection after use
    $stmt->close();
    $conn->close();
}
// Logout functionality (can be placed in a logout.p
?>
