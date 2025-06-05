<?php
include('../connect.php');
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../default.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-duotone-solid.css">
   <style>
    .actived{
    background: #e0e0e058;
}
/* Grid container for info cards */
.grid-container {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 2rem;
    margin-bottom: 30px;
    padding: 20px;
}

@media (min-width: 768px) {
    .grid-container {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .grid-container {
        grid-template-columns: repeat(4, 1fr);
    }
}

/* Info card styling */
.info-card {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    padding: 25px;
    text-align: center;
}

.info-card h2 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 10px;
}

.number {
    font-size: 2rem;
    font-weight: bold;
}

.blue {
    color: #3b82f6;
}

.green {
    color: #10b981;
}

.yellow {
    color: #fbbf24;
}

.red {
    color: #ef4444;
}

/* Activities section */
.activities {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    padding: 25px;
}

.activities h2 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 20px;
}

/* Activity list */
.activity-list {
    list-style: none;
    padding: 0;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

.icon {
    padding: 10px;
    border-radius: 50%;
}

.blue-bg {
    background-color: #dbeafe;
    color: #2563eb;
}

.green-bg {
    background-color: #d1fae5;
    color: #059669;
}

.yellow-bg {
    background-color: #fef3c7;
    color: #ca8a04;
}

.activity-title {
    font-weight: 600;
}

.activity-time {
    font-size: 0.875rem;
    color: #6b7280;
}

   </style>
</head>
<body>
  
    <?php include('layout.php');?>
    
    <div class="grid-container">
    <div class="info-card">
        <h2>Total Books</h2>
        <p class="number blue"><?php $query = "SELECT COUNT(*) AS total FROM books";
$result = mysqli_query($conn, $query);

// Fetch the result and display the row count
if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo $row['total'];
}?></p>
    </div>
    <div class="info-card">
        <h2>Registered Students</h2>
        <p class="number green"><?php $query = "SELECT COUNT(*) AS total FROM student";
$result = mysqli_query($conn, $query);

// Fetch the result and display the row count
if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo $row['total'];
}?></p>
    </div>
    <div class="info-card">
        <h2>Books Borrowed</h2>
        <p class="number yellow"><?php $query = "SELECT COUNT(*) AS total FROM issued_books";
$result = mysqli_query($conn, $query);

// Fetch the result and display the row count
if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo $row['total'];
}?></p>
    </div>
    <div class="info-card">
        <h2>Due Books</h2>
        <p class="number red"><?php $query = "SELECT COUNT(*) AS total FROM issued_books WHERE return_date is NULL";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            echo $row['total'];} ?></p>
    </div>
</div>

<div class="activities">
    <h2>Recent Activities</h2>
    <ul class="activity-list">
        <li class="activity-item">
            <div class="icon blue-bg">
            <i class="fa-sharp-duotone fa-solid fa-book"></i>
            </div>
            <div>
                <p class="activity-title">New book added: "<?php
                $sql = "SELECT title FROM books  ORDER BY id DESC LIMIT 1";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo   $row['title'] ;
                    }
                }
                ?>"</p>
                <p class="activity-time">2 hours ago</p>
            </div>
        </li>
        <li class="activity-item">
            <div class="icon green-bg">
                <i class="fas fa-user-plus"></i>
            </div>
            <div>
                <p class="activity-title">New student registered: "<?php
                $sql = "SELECT first_name FROM student  ORDER BY id DESC LIMIT 1";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo   $row['first_name'] ;
                    }
                }
                ?>"</p>
                <p class="activity-time">4 hours ago</p>
            </div>
        </li>
        <li class="activity-item">
            <div class="icon yellow-bg">
            <i class="fa-sharp-duotone fa-solid fa-book-arrow-right"></i>
            </div>
            <div>
                <p class="activity-title">Book borrowed: "<?php
                $sql = "SELECT book_name FROM issued_books  ORDER BY id DESC LIMIT 1";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo   $row['book_name'] ;
                    }
                }
                ?>"</p>
                <p class="activity-time">Yesterday</p>
            </div>
        </li>
    </ul>
</div>

        
        
  </div>
 
</body>
</html>
