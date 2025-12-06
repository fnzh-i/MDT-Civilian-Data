<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MDT Admin Search License</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="../../../public/admin_script.js"></script>
  <link rel="stylesheet" href="../../../public/style.css">
</head>

<body class="bg-gray-200">

  <!-- STICKY NAVBAR -->
  <nav class="bg-blue-600 shadow-lg px-6 py-3 relative flex justify-between items-center sticky top-0 z-50">
    <div class="flex items-center gap-3">
      <!-- burgir toggle -->
      <button id="sidebarToggle" class="flex flex-col justify-center space-y-1">
        <span class="block w-6 h-0.5 bg-white"></span>
        <span class="block w-6 h-0.5 bg-white"></span>
        <span class="block w-6 h-0.5 bg-white"></span>
      </button>
      <span class="text-white block font-semibold truncate max-w-xs">Administrator</span>
    </div>

    <!-- Title centered -->
    <div class="absolute left-1/2 transform -translate-x-1/2">
      <a href="../admin_dashboard.php"
        class="flex items-center gap-2 text-white font-bold hover:text-gray-200 transition">
        <span>MDT Admin (Search & Edit License)</span>
      </a>
    </div>

    <!-- Right: Logout -->
    <div>
      <a href="../../../public/index.php"
        class="flex items-center gap-2 text-white font-bold hover:text-gray-200 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5" />
        </svg>
        <span>Logout</span>
      </a>
    </div>
  </nav>

  <div class="flex flex-col md:flex-row">
    <!-- sidebar (Admin Version) -->
    <div id="sidebar" class="bg-white w-56 h-screen shadow-2xl p-6 hidden md:block fixed top-0 left-0">
      <ul class="space-y-4">

        <li>
          <span class="items-start w-full text-left text-gray-700 hover:text-blue-600 font-bold">
            <div class="flex items-center gap-3 mt-10">
              <span><img src="../../../public/assets/user.png" class="w-6 h-6 inline-block"></span>
              <div>
                <span class="block font-bold">Administrator</span>
                <span class="block font-semibold">MDT System</span>
              </div>
            </div>
          </span>
        </li>

        <li>
          <button onclick="window.location.href='../admin_dashboard.php'"
            class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
            Dashboard
          </button>
        </li>

        <li>
          <button onclick="window.location.href='../_license/AdminCreateLicense.php'"
            class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
            Create License
          </button>
        </li>

        <li>
          <button onclick="window.location.href='../_license/AdminSearchLicense.php'"
            class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
            Search & Edit License
          </button>
        </li>

        <li>
          <button onclick="window.location.href='../admin_settings.php'"
            class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
            Settings
          </button>
        </li>

      </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex flex-col items-center justify-start px-4 w-full mt-32 md:mt-0 py-32">
      <div class="bg-white p-8 rounded-2xl shadow-xl max-w-xl mx-auto">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Search License</h1>

        <form action="AdminSearchLicenseResult.php" method="GET" class="space-y-6">
          <input type="hidden" name="action" value="SEARCH-LICENSE-NUMBER">

          <div>
            <label class="font-semibold text-gray-700">Enter License Number</label>
            <input type="text" id="search-license" name="license-number" placeholder="AXX-XX-XXXXXX"
              class="w-full p-3 border rounded-lg">
          </div>

          <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-800 text-white py-3 rounded-xl font-bold transition">
            Search
          </button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>