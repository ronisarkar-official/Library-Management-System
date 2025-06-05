<?php
include('../connect.php');

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['student_id']) && !empty(trim($_POST['student_id']))) {
    $student_id = trim($_POST['student_id']);

    // Prepare and bind safely
    $stmt = $conn->prepare("SELECT first_name FROM student WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Set content type (optional, for better AJAX compatibility)
    header('Content-Type: text/html; charset=UTF-8');

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo htmlspecialchars($row['first_name']);
    } else {
        echo'No student found';
    }

    $stmt->close();
}

$conn->close();
?>
