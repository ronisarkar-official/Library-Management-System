<?php
include('../connect.php');
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../default.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fname'])) {
    $name = $_POST['fname'];
    $mail = $_POST['email'];
    $phone = $_POST['phone'];
    $class = $_POST['class'];
    $id = $_POST['id'];

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO student (first_name, email, student_id, phone_number, class_roll) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $mail, $id, $phone, $class);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href = window.location.href;</script>";
        exit;
    } else {
        echo "<script>alert('Registration failed. Please try again.');</script>";
    }
}



// Pagination setup
$recordsPerPage = 4;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Books</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<?php include('layout.php'); ?>
<body class="bg-gray-100 text-gray-800">

  <div class="w-full px-4 py-8">
    <h1 class="text-4xl leading-9 font-bold text-center text-blue-600 mb-8">Registered Students List</h1>

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
      <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full transition-transform transform hover:scale-105" id="openModalBtn" ...>Add New Student</button>

      

      <form method="GET" action="" class="ml-auto flex gap-2">
        <input
          name="search"
          value="<?= htmlspecialchars($search) ?>"
          class="px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500"
          type="search"
          placeholder="Search students..."
        />
        <input type="hidden" name="page" value="1" />
        <button class="hidden" type="submit"></button>
      </form>
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow-md">
      <table class="min-w-full border-t border-gray-200">
        <thead>
          <tr class="bg-gray-100 text-gray-700 text-sm uppercase tracking-wider">
            <th class="py-4 px-4 text-center">Name</th>
            <th class="py-4 px-4 text-center">Email</th>
            <th class="py-4 px-4 text-center">Student Id</th>
            <th class="py-4 px-4 text-center">Phone</th>
            <th class="py-4 px-4 text-center">Class Roll</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if (!empty($search)) {
                $searchParam = "%$search%";
                $stmt = $conn->prepare("SELECT * FROM student WHERE 
                    first_name LIKE ? OR 
                    email LIKE ? OR 
                    student_id LIKE ? OR 
                    phone_number LIKE ? OR 
                    class_roll LIKE ?
                    LIMIT ?, ?");
                $stmt->bind_param("sssssss", $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $offset, $recordsPerPage);
            } else {
                $stmt = $conn->prepare("SELECT * FROM student ORDER BY id DESC LIMIT ?, ?");

                $stmt->bind_param("ii", $offset, $recordsPerPage);
            }
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='even:bg-gray-50'>
                            <td class='py-3 px-4 text-center bg-white'>" . htmlspecialchars($row['first_name']) . "</td>
                            <td class='py-3 px-4 text-center bg-white'>" . htmlspecialchars($row['email']) . "</td>
                            <td class='py-3 px-4 text-center bg-white'>" . htmlspecialchars($row['student_id']) . "</td>
                            <td class='py-3 px-4 text-center bg-white'>" . htmlspecialchars($row['phone_number']) . "</td>
                            <td class='py-3 px-4 text-center bg-white'>" . htmlspecialchars($row['class_roll']) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='py-4 px-4 text-center text-red-500'>No students found.</td></tr>";
            }
          ?>
        </tbody>
      </table>
    </div>

<!-- Modal Background -->
<div id="studentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <!-- Modal Content -->
  <div class="bg-white rounded-lg shadow-lg p-8 max-w-lg w-full relative">
    <button id="closeModalBtn" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl font-bold">&times;</button>
    <h2 class="text-2xl mb-6 font-semibold text-indigo-600">Student Registration</h2>

    <form id="studentForm" method="POST" class="space-y-4">
      <input type="text" name="fname" placeholder="Full Name" required
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-indigo-500" />
      <input type="email" name="email" placeholder="Email" required
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-indigo-500" />
      <input type="text" name="phone" placeholder="Phone No" required
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-indigo-500" />
      <input type="text" name="class" placeholder="Class Roll" required
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-indigo-500" />
      <input type="text" name="id" placeholder="Student ID" required
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-indigo-500" />

      <button type="submit"
        class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">Register</button>
    </form>
  </div>
</div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-center items-center gap-2">
      <?php
        // Count total records
      if (!empty($search)) {
    $searchParam = "%$search%";
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM student WHERE 
        first_name LIKE ? OR 
        email LIKE ? OR 
        student_id LIKE ? OR 
        phone_number LIKE ? OR 
        class_roll LIKE ?");
    $stmt->bind_param("sssss", $searchParam, $searchParam, $searchParam, $searchParam, $searchParam);
} else {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM student");
}
$stmt->execute();
$countResult = $stmt->get_result();
$totalRecords = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

        // Render buttons
        if ($totalPages > 1) {
            if ($page > 1) {
                echo '<a href="?search=' . urlencode($search) . '&page=' . ($page - 1) . '" class="px-3 py-2 bg-gray-200 rounded hover:bg-gray-300">Previous</a>';
            }

            for ($i = 1; $i <= $totalPages; $i++) {
                $active = $i == $page ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300';
                echo '<a href="?search=' . urlencode($search) . '&page=' . $i . '" class="px-3 py-2 rounded ' . $active . '">' . $i . '</a>';
            }

            if ($page < $totalPages) {
                echo '<a href="?search=' . urlencode($search) . '&page=' . ($page + 1) . '" class="px-3 py-2 bg-gray-200 rounded hover:bg-gray-300">Next</a>';
            }
        }
      ?>
    </div>
  </div>
</body>
<script>
  const openBtn = document.getElementById('openModalBtn');
  const closeBtn = document.getElementById('closeModalBtn');
  const modal = document.getElementById('studentModal');

  openBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
  });

  closeBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
  });

  // Optional: close modal on click outside the modal content
  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.classList.add('hidden');
    }
  });
</script>

</html>
