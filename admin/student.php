<?php 
$conn=mysqli_connect("localhost","u357634566_library","Ghost@8972134437","u357634566_college");
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
      background-color: #fefefe;
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

    

   .actives{
    background: #e0e0e058;
}
   
  </style>
</head>
<body>
  
  <?php include('layout.php'); ?>
    
  <div class="container mx-auto px-4 py-8">
    <h1 class="header-title">Registered Students List</h1>
      
    <div>
      <button onclick="window.location.href='add-student.php'" class="add-book-btn">Add New Student</button>
    </div>

    <div class="book-container">
      <table class="book-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Student Id</th>
            <th>Phone</th>
            <th>Class Roll</th>
          </tr>
        </thead>
        <tbody>
          <!-- Table rows will be dynamically added here -->
           <?php
// Query to fetch all students
$sql = "SELECT first_name, email, student_id, phone_number, class_roll FROM student";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Output each row of data
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['first_name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['student_id']) . "</td>
                <td>" . htmlspecialchars($row['phone_number']) . "</td>
                <td>" . htmlspecialchars($row['class_roll']) . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No students found.</td></tr>";
}
?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
