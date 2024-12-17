<?php 
$conn=mysqli_connect("localhost","u357634566_library","Ghost@8972134437","u357634566_college");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Update record with today's date when "paid" parameter is passed
if (isset($_GET['paid_id'])) {
    $paid_id = $_GET['paid_id'];
    $today_date = date('Y-m-d');
    $update_query = "UPDATE issued_books SET return_date = '$today_date' WHERE id = $paid_id";
    mysqli_query($conn, $update_query);
    header("Location: manage-issue-books.php"); // Redirect to avoid resubmission
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
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

    

    .activei{
    background: #e0e0e058;
}

    /* Add responsive design for mobile devices */
   
  </style>
</head>
<body>
  
  <?php include('layout.php'); ?>
    
  <div class="container mx-auto px-4 py-8">
    <h1 class="header-title">Manage Issue Books</h1>
      
    <div>
      <button onclick="window.location.href='issue-book.php'" class="add-book-btn">Issue Book</button>
    </div>

    <div class="book-container">
      <table class="book-table">
        <thead>
          <tr>
            <th>Student Id</th>
            <th>Student Name</th>
            <th>Book Name</th>
            <th>Book Id</th>
            <th>Issued Date</th>
            <th>Return Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Table rows will be dynamically added here -->
           <?php
          // Fetch all issued books from the database
          $query = "SELECT * FROM issued_books ORDER BY return_date IS NOT NULL, return_date";
          $result = mysqli_query($conn, $query);

          if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['book_name']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['book_id']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['issued_date']) . "</td>";
                  echo "<td>" . (isset($row['return_date']) ? htmlspecialchars($row['return_date']) : 'N/A') . "</td>";
                  
                  // Show "Paid" button only if the return_date is NULL
                  if (is_null($row['return_date'])) {
                      echo "<td>
                              <a href='manage-issue-books.php?paid_id=" . $row['id'] . "' onclick='return confirm(\"Mark this book as returned?\");' class='paid-btn'>Paid</a>
                            </td>";
                  } else {
                      echo "<td>Returned</td>";
                  }
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='7'>No records found</td></tr>";
          }

          mysqli_close($conn);
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>

