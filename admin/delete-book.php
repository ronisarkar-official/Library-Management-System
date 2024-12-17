<?php
// Database connection (update with your database details)
$conn=mysqli_connect("localhost","u357634566_library","Ghost@8972134437","u357634566_college");

// Check if the connection is successful
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the 'id' is set in the URL
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

  // SQL to delete the book record
  $sql = "DELETE FROM books WHERE id = $id";

  if ($conn->query($sql) === TRUE) {
    echo "Book deleted successfully.";
  } else {
    echo "Error deleting book: " . $conn->error;
  }
}

// Close the database connection
$conn->close();

// Redirect back to the main page
header("Location: manage-books.php");
exit();
?>
