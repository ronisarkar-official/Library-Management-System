

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
  background-color: #fefefe;
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
.activer{
    background: #e0e0e058;
}
    </style>
</head>
<body>
  
  <?php include('layout.php');
  
  
  ?>
  
    <div class="bd">
<div class="register">
    
    
    
   <form action="#" method="POST">
    
   <h1>Book Issue Details</h1>
<div class="input-box">
    <div class="input-field">
        <input type="text" name="fname" class="Fname" placeholder="STUDENT NAME" required>
        <i class="fa-light fa-user"></i>
    </div>
    
    <div class="input-field">
        <input type="text" name="email" class="Fname" placeholder="BOOK NAME" required> 
        <i class="fa-light fa-book"></i>
    </div>
    
    
   <div class="input-field">
    <input type="text" name="phone" class="Fname" placeholder="BOOK ID" required>
    <i class="fa-light fa-book-bookmark"></i>
   </div>
    
    
   <div class="input-field">
    <input type="date" name="class" class="Fname" placeholder="ISSUED DATE" required>
    <i class="fa-light fa-calendar"></i>
   </div>
   
    
    <div class="input-field">
        <input type="text" name="id" class="Fname" placeholder="STUDENT ID" required>
        <i class="fa-light fa-id-card"></i>
    </div>
  
    
</div> 
<input type="submit" value="Issue Book" class="button" name="register">
    </div>
</form>
</div>


        </div>
    </div>
  </div>
  
</body>
</html>


<?php 
$conn=mysqli_connect("localhost","u357634566_library","Ghost@8972134437","u357634566_college");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['register'])) {
    $student_name = $_POST['fname'];
    $book_name = $_POST['email'];
    $book_id = $_POST['phone'];
    $issued_date = $_POST['class'];
    $student_id = $_POST['id'];

    // Insert issued book data into the database
    $sql = "INSERT INTO issued_books (student_id, student_name, book_name, book_id, issued_date) 
            VALUES ('$student_id', '$student_name', '$book_name', '$book_id', '$issued_date')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Book issued successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

mysqli_close($conn);
?>
