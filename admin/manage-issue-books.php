<?php
include('../connect.php');
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../default.php");
    exit();
}

// Pagination setup
$limit = 4;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Handle form submission for issuing book (unchanged)
if (isset($_POST['register'])) {
    $student_name = $_POST['fname'];
    $book_name = $_POST['book_name'];
    $book_id = $_POST['book_id'];
    $issued_date = $_POST['issued_date'];
    $student_id = $_POST['id'];

    $stmt = $conn->prepare("SELECT * FROM student WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        echo "<script>alert('Error: Student not found.');</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO issued_books (student_id, student_name, book_name, book_id, issued_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $student_id, $student_name, $book_name, $book_id, $issued_date);
        if ($stmt->execute()) {
            echo "<script>alert('Book issued successfully!');</script>";
        } else {
            echo "<script>alert('Insert failed: " . $stmt->error . "');</script>";
        }
    }
}

// Handle return book
if (isset($_GET['paid_id'])) {
    $paid_id = (int)$_GET['paid_id'];
    $today = date('Y-m-d');
    $stmt = $conn->prepare("UPDATE issued_books SET return_date = ? WHERE id = ?");
    $stmt->bind_param("si", $today, $paid_id);
    $stmt->execute();
    header("Location: manage-issue-books.php");
    exit();
}

// Get search term from GET
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
// Prepare search parameter
$search_param = "%$search%";

if ($search !== '') {
    $stmt = $conn->prepare("SELECT * FROM issued_books 
                            WHERE student_name LIKE ? 
                               OR book_name LIKE ? 
                               OR book_id LIKE ? 
                               OR student_id LIKE ?
                            ORDER BY return_date IS NULL DESC, return_date DESC, issued_date DESC 
                            LIMIT ? OFFSET ?");
    // Now 4 strings + 2 integers in bind_param
    $stmt->bind_param("ssssii", $search_param, $search_param, $search_param, $search_param, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    // Count total filtered records for pagination
    $count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM issued_books 
                                  WHERE student_name LIKE ? 
                                     OR book_name LIKE ? 
                                     OR book_id LIKE ? 
                                     OR student_id LIKE ?");
    $count_stmt->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $total_row = $count_result->fetch_assoc();
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);
} else {
    // No search: normal query with pagination
    $query = "SELECT * FROM issued_books 
              ORDER BY return_date IS NULL DESC, return_date DESC, issued_date DESC 
              LIMIT $limit OFFSET $offset";
    $result = mysqli_query($conn, $query);

    $total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM issued_books");
    $total_row = mysqli_fetch_assoc($total_result);
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);
}

// Fetch students list (unchanged)
$students_result = mysqli_query($conn, "SELECT student_id, first_name FROM student");
$students = [];
if ($students_result) {
    while ($row = mysqli_fetch_assoc($students_result)) {
        $students[] = $row;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  
  <script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
 @keyframes fade-in {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  .animate-fade-in {
    animation: fade-in 0.3s ease-out;
  }
  </style>
</head>
<body>
  
  <?php include('layout.php'); ?>
    
  <div class="container mx-auto px-4 py-8">
    <h1 class="header-title">Manage Issue Books</h1>
      
   <!-- Tailwind CSS CDN -->


<!-- ✅ Issue Book Button (unchanged) -->
<div class="flex items-center justify-between flex-wrap gap-4 my-4">
  <!-- Issue Book button on the left -->
  <button onclick="openIssueBookModal()" 
          class="add-book-btn bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition">
    Issue Book
  </button>

  <!-- Search form on the right -->
  <form method="GET" action="" class="ml-auto">
    <input 
      name="search"
      value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
      class="px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" 
      type="search" 
      placeholder="Search students..." 
      aria-label="Search books"
    />
  </form>
</div>




<!-- ✅ Modal -->
<div id="issueBookModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden flex items-center justify-center">
  <div class="bg-white w-full max-w-4xl p-6 rounded-lg shadow-lg relative animate-fade-in">

    <!-- ❌ Close Icon inside Form -->
    <span onclick="closeIssueBookModal()" 
          class="absolute right-4 top-4 text-3xl text-gray-500 hover:text-red-600 cursor-pointer select-none">
      &times;
    </span>

    <!-- 🎯 Form -->
    <div class="w-full max-w-3xl m-auto">
      <form  method="POST" class="space-y-6">
        <h1 class="text-3xl font-medium text-center text-indigo-600 mb-6">Book Issue Details</h1>

        <div class="flex flex-wrap -mx-2">
          <!-- Student ID -->
          <div class="w-full md:w-1/2 px-2 mb-4 relative">
            <input type="text" id="student_id" name="id" placeholder="STUDENT ID" required
              class="w-full border border-gray-400 pl-10 pr-3 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            <i class="fa-regular fa-id-card absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
          </div>

          <!-- Student Name -->
          <div class="w-full md:w-1/2 px-2 mb-4 relative">
            <input type="text" id="student_name" name="fname" placeholder="STUDENT NAME" readonly
              class="w-full border border-gray-400 pl-10 pr-3 py-3 rounded-md bg-gray-100 text-sm">
            <i class="fa-regular fa-user absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
          </div>

          <!-- Book Name -->
          <div class="w-full md:w-1/2 px-2 mb-4 relative">
            <input type="text" name="book_name" placeholder="BOOK NAME" required
              class="w-full border border-gray-400 pl-10 pr-3 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            <i class="fa-regular fa-book absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
          </div>

          <!-- Book ID -->
          <div class="w-full md:w-1/2 px-2 mb-4 relative">
            <input type="text" name="book_id" placeholder="BOOK ID" required
              class="w-full border border-gray-400 pl-10 pr-3 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            <i class="fa-regular fa-book-bookmark absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
          </div>

          <!-- Issued Date -->
          <div class="w-full md:w-1/2 px-2 mb-4 relative">
            <input type="date" name="issued_date" placeholder="ISSUED DATE" required
              class="w-full border border-gray-400 pl-10 pr-3 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            <i class="fa-regular fa-calendar absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
          </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" name="register"
          class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-md transition duration-200">
          Issue Book
        </button>
      </form>
    </div>
  </div>
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
  <?php
  if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
          echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
          echo "<td>" . htmlspecialchars($row['book_name']) . "</td>";
          echo "<td>" . htmlspecialchars($row['book_id']) . "</td>";
          echo "<td>" . htmlspecialchars($row['issued_date']) . "</td>";
          echo "<td>" . (isset($row['return_date']) ? htmlspecialchars($row['return_date']) : 'N/A') . "</td>";
          
          if (is_null($row['return_date'])) {
              echo "<td>
                      <a href='manage-issue-books.php?paid_id=" . $row['id'] . "' onclick='return confirm(\"Mark this book as returned?\");' class='paid-btn inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-full shadow-md transition duration-200'>Paid</a>
                    </td>";
          } else {
              echo "<td>Returned</td>";
          }
          echo "</tr>";
      }
  } else {
      echo "<tr><td colspan='7'>No records found</td></tr>";
  }
  ?>
</tbody>


      </table>
      

    </div>
    <?php 
$query_params = [];
if ($search !== '') {
    $query_params['search'] = urlencode($search);
}
?>

<div class="flex justify-center mt-4 space-x-2">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>&<?= http_build_query($query_params) ?>" class="px-4 py-2 bg-white-200 rounded hover:bg-gray-300">&laquo; Prev</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?= $i ?>&<?= http_build_query($query_params) ?>" class="px-4 py-2 rounded <?= $i === $page ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?= $page + 1 ?>&<?= http_build_query($query_params) ?>" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Next &raquo;</a>
    <?php endif; ?>
</div>

  </div>
  <script>
  function openIssueBookModal() {
    document.getElementById("issueBookModal").classList.remove("hidden");
  }

  function closeIssueBookModal() {
    document.getElementById("issueBookModal").classList.add("hidden");
  }


   $(document).on('input', '#student_id', function() {
    var studentId = $(this).val();
    if (studentId) {
        $.ajax({
            url: 'fetch_student_name.php',
            method: 'POST',
            data: { student_id: studentId },
            success: function(response) {
                if (response.trim() === "Student Not Found") {
                    $('#student_name').val('');
                    alert("Student Not Found"); // or display a toast/message inline
                } else {
                    $('#student_name').val(response);
                }
            }
        });
    } else {
        $('#student_name').val('');
    }
});

</script>
</body>

</html>