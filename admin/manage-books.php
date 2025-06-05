<?php
include('../connect.php');
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../default.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  
  <title>Books</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f7f7f7;
    }

    .container {
      
    padding-left: 1rem; /* 16px */
padding-right: 1rem;
padding-top: 2rem; /* 32px */
padding-bottom: 2rem;
width: 100%;
    }

    .header-title {
      margin-bottom: 2rem; 
font-size: 2.5rem;
line-height: 2.25rem; 
font-weight: 700; 
text-align: center; 
color: #2563EB; 
    }

    .add-book-btn {
      background-color: #2563eb;
      color: white;
      font-weight: bold;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      border: none;
      cursor: pointer;
      transition: transform 0.3s ease-in-out;
    }

    .add-book-btn:hover {
      background-color: #284eff;
      transform: scale(1.05);
    }

    .book-container {
      overflow: hidden;
      border-radius: 0.9rem;
      background-color: #fefefe;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      margin-top: 1.5rem;
      
    }

    .book-table {
      border-top-width: 1px; 
      border-color: #E5E7EB; 
      min-width: 100%;
      border: none;
    }

    .book-table th, .book-table td {
      padding: 1rem;
      text-align: center;
      justify-content: space-between;
      
    }

    .book-table th {
      background-color: #F5F5F5;
      color: #404040;
      font-size: 0.875rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .book-table tbody tr:nth-child(even) {
      background-color: #F9FAFB;
    }

    .book-table tbody td {
      background-color: #ffffff;
    }

    .action-buttons {
      display: flex;
      gap: 0.5rem;
    }

    .edit-btn {
      color: #4F46E5;
      background-color: transparent;
      border: none;
      cursor: pointer;
    }

    .edit-btn:hover {
      color: #3730A3;
    }

    .delete-btn {
      color: #E53E3E;
      background-color: transparent;
      border: none;
      cursor: pointer;
    }

    .delete-btn:hover {
      color: #C53030;
    }

    .activeb{
    background: #e0e0e058;
}

    /* Add responsive design for mobile devices */
   
  </style>
</head>
<body>
  
  <?php include('layout.php'); ?>
    
  <div class="container mx-auto px-4 py-8">
    <h1 class="header-title">Book Management System</h1>
      
    <div>
      <button onclick="window.location.href='add-books.php'" class="add-book-btn">Add New Book</button>
    </div>

    <div class="book-container">
      <table class="book-table">
        <thead>
          <tr>
            
            <th>Title</th>
            <th>Author</th>
            <th>category</th>
            <th>Total Copies</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Table rows will be dynamically added here -->
          <?php
// Database connection (update with your database details)
include('../connect.php');

// Check if the connection is successful
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve book data, now including the 'id' column
$sql = "SELECT id, title, author, genre, total_copies FROM books";
$result = $conn->query($sql);

// Loop through each row in the result set
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
    echo "<td>" . htmlspecialchars($row['author']) . "</td>";
    echo "<td>" . htmlspecialchars($row['genre']) . "</td>";
    echo "<td>" . htmlspecialchars($row['total_copies']) . "</td>";
    echo "<td class='action-buttons'>";
    echo "<a href='delete-book.php?id=" . $row['id'] . "' class='delete-btn' onclick=\"return confirm('Are you sure you want to delete this book?');\"><i class='fa fa-trash'></i></a>";
    echo "</td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='5'>No books found</td></tr>";
}

// Close the database connection
$conn->close();
?>

        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
