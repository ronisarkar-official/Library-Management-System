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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
    <link rel="stylesheet" href="style.css">
    
   <style>
   .bd {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            
        }
   
        .register {
  width: 750px;
  background-color: #ffffff;
  border-radius: 10px;
  color: #000000;
  padding: 40px 35px 55px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.register h1 {
  font-size: 36px;
  text-align: center;
  margin-bottom: 20px;
  color: rgb(79 70 229 );
  font-weight: 500;
}

 
        .register .input-box {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  background-color: #ffff;
  
}
.input-box .input-field {
    position: relative;
    width: 48%;
    background-color: chartreusen;
    margin: 13px 0;
    height: 50px;
    box-shadow: #000000;
}

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

.input-box .input-field input::placeholder {
    color: #000000;

}

.input-box .input-field i{
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 21px;


}
.register .button{
    width: 100%;
    height: 45px;
    background-color: #4f46e5;
    border: none;
    outline: none;
    border-radius: 6px;
    box-shadow:0 0 10px rgba(0, 0, 0, .1);
    cursor: pointer;
    font-size: 16px;
    color: #ffffff;
    font-weight: 600;


}
    </style>
</head>
<body>
  
  <?php include('layout.php');
  
  
  ?>
  
    <div class="bd">
<div class="register">
    
    
    
   <form action="#" method="POST">
    
   <h1>ADD NEW BOOKS</h1>
<div class="input-box">
    <div class="input-field">
        <input type="text" name="title" class="Fname" placeholder="Book Title" required>
        <i class="fa-light fa-book"></i>
    </div>
    
    <div class="input-field">
        <input type="text" name="name" class="Fname" placeholder="Author Name" required> 
        <i class="fa-solid fa-book-open-reader"></i>
    </div>
    
    
   <div class="input-field">
    <input type="text" name="genre" class="Fname" placeholder="Catagory" required>
    <i class="fa-solid fa-layer-group"></i>
   </div>
    
    
   <div class="input-field">
    <input type="number" name="copies" class="Fname" placeholder="Total Copies" required>
    <i class="fa-regular fa-book-copy"></i>
   </div>
   
    
    
  
    
</div> 
<input type="submit" value="Add Book" class="button" name="register">
    </div>
</form>
</div>


        </div>
    </div>
  </div>
  
</body>
</html>


<?php
// Checking if the registration form was submitted
if (isset($_POST['register'])) {
    // Get the title, author, genre, and total copies from the form input
    $title = $_POST['title'];
    $name = $_POST['name'];
    $genre = $_POST['genre'];
    $copies = $_POST['copies'];
    
    // Insert the new book data into the books table in the database
    $query = "INSERT INTO books (title, author, genre, total_copies) 
              VALUES ('$title', '$name', '$genre', $copies)"; 
    
    // Execute the query and insert data into the database
    $data = mysqli_query($conn, $query);
    
    // If the query was successful, show a success alert
    if ($data) {
        echo "<script>alert('Book added successfully!');</script>";
    } else {
        // If the query failed, show an error alert
        echo "<script>alert('Book addition failed. Please try again.');</script>";
    }
}
?>