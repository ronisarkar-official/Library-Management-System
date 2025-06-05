<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css" />
<!-- Google Font: Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

<!-- Custom Tailwind Config for Poppins -->
<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: {
          poppins: ['Poppins', 'sans-serif'],
        },
      },
    },
  };
</script>

<body class="flex font-poppins">

  <!-- Sidebar -->
  <div class="sticky top-0 left-0 bottom-0 h-screen w-[55px] hover:w-[230px] transition-all duration-500 bg-gradient-to-b from-[#8c52ff] to-[#5ce1e6] text-white overflow-hidden">
    <div class="h-8 p-4"></div>
    <ul class="relative h-[88%] list-none p-0">
      <li class="p-4 my-2 rounded-lg transition-all duration-300 hover:bg-[#e0e0e058]">
        <a href="dashboard.php" class="flex items-center gap-5 text-sm text-white no-underline">
          <i class="fa-light fa-house text-[1.2rem]"></i>
          <span class="overflow-hidden">Dashboard</span>
        </a>
      </li>
      <li class="p-4 my-2 rounded-lg transition-all duration-300 hover:bg-[#e0e0e058]">
        <a href="manage-books.php" class="flex items-center gap-5 text-sm text-white no-underline">
          <i class="fa-light fa-book text-[1.2rem]"></i>
          <span class="overflow-hidden">Books</span>
        </a>
      </li>
      <li class="p-4 my-2 rounded-lg transition-all duration-300 hover:bg-[#e0e0e058]">
        <a href="student.php" class="flex items-center gap-5 text-sm text-white no-underline">
          <i class="fa-light fa-user-graduate text-[1.2rem]"></i>
          <span class="overflow-hidden">Student</span>
        </a>
      </li>
      <li class="p-4 my-2 rounded-lg transition-all duration-300 hover:bg-[#e0e0e058]">
        <a href="manage-issue-books.php" class="flex items-center gap-5 text-sm text-white no-underline">
          <i class="fa-light fa-book-arrow-right text-[1.2rem]"></i>
          <span class="overflow-hidden">Issue Books</span>
        </a>
      </li>
      <li class="absolute bottom-0 left-0 w-full p-4 rounded-lg transition-all duration-300 hover:bg-[#e0e0e058]">
        <a href="logout.php" class="flex items-center gap-5 text-sm text-white no-underline">
          <i class="fa-light fa-right-from-bracket text-[1.2rem]"></i>
          <span class="overflow-hidden">Logout</span>
        </a>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="relative w-full bg-[#dceef8] p-4">
    <div class="flex justify-between items-center flex-wrap bg-white shadow-md rounded-xl px-8 py-2 mb-2">
      <div class="header--title">
        <span >Admin</span>
        <h2 class="text-blue-500 font-bold text-lg">Dashboard</h2>
      </div>

      <div class="flex items-center gap-2">
        <abbr title="Profile"><i class="fa-light fa-circle-user fa-2xl cursor-pointer"></i></abbr>
        <div class="ml-5">
          <abbr title="Logout">
            <a href="logout.php">
              <i class="fa-light fa-right-from-bracket fa-xl text-[#e21d45]"></i>
            </a>
          </abbr>
        </div>
      </div>
      </div>
