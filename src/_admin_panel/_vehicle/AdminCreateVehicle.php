<?php
session_start();
$role = $_SESSION['role'] ?? 'OFFICER'; // fallback if session not set
$name = ($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? 'MDT-BOT'); // you store name

require_once __DIR__ . '/../../bootstrap.php';
$plateNumber = $_GET['plate-number'] ?? '';
$vehicleId = $_GET['vehicle-id'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MDT Admin Create Vehicle</title>
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
      <span class="text-white block font-semibold truncate max-w-xs" id="userNameNav">Administrator</span>
    </div>

    <!-- Title centered -->
    <div class="absolute left-1/2 transform -translate-x-1/2">
      <a href="../admin_dashboard.php" class="flex items-center gap-2 text-white font-bold hover:text-gray-200 transition">
        <span>MDT Admin Dashboard</span>
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

  <div class="flex flex-col md:flex-row"> <!-- sidebar (Admin Version) -->
    <div id="sidebar" class="bg-white w-56 h-screen shadow-2xl p-6 hidden md:block fixed top-0 left-0">
      <ul class="space-y-4">

        <li>
          <span class="items-start w-full text-left text-gray-700 hover:text-blue-600 font-bold">
            <div class="flex items-center gap-3 mt-10">
              <span><img src="../../../public/assets/user.png" class="w-6 h-6 inline-block"></span>
              <div>
                <span class="block font-bold" id="userRoleDisplay">Administrator</span>
                <span class="block font-semibold" id="userNameSidebar">MDT System</span>
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
          <button onclick="window.location.href='../_user/adminCreateUser.php'"
            class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
            Create User
          </button>
        </li>

        <li>
          <button onclick="window.location.href='../_license/adminCreateLicense.php'"
            class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
            Create License
          </button>
        </li>

        <li>
          <button onclick="window.location.href='../_vehicle/adminCreateVehicle.php'"
            class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
            Create Vehicle
          </button>
        </li>

        <li>
          <button onclick="window.location.href='../_license/adminSearchLicense.php'"
            class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
            Search & Edit License
          </button>
        </li>

        <li>
          <button onclick="window.location.href='../_vehicle/adminSearchVehicle.php'"
            class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
            Search & Edit Vehicle
          </button>
        </li>

        <li>
          <button onclick="window.location.href='../_user/adminUser.php'"
            class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
            Search & Edit User
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
      <div class="bg-white p-8 rounded-2xl shadow-xl max-w-4xl mx-auto w-full h-[85vh] overflow-y-auto">

        <h1 class="text-3xl font-extrabold text-gray-800 mb-6">
          <?= $vehicleId ? "Update Vehicle" : "Create New Vehicle" ?>
        </h1>

        <form action="../../_modules/Controller.php" method="POST" class="space-y-6">
          <input type="hidden" name="action" value="CREATE-VEHICLE">
          <input type="hidden" name="vehicle-id" id="vehicle-id" value="<?= htmlspecialchars($vehicleId); ?>">

          <!-- LICENSE NUMBER -->
          <div>
            <label class="font-semibold text-gray-700">License Number</label>
            <input type="text" id="license-number" name="license-number" placeholder="AXX-XX-XXXX"
              class="w-full p-3 border rounded-lg">
          </div>

          <!-- PLATE NUMBER -->
          <div>
            <label class="font-semibold text-gray-700">Plate Number</label>
            <input type="text" id="plate-number" name="plate-number" value="<?= htmlspecialchars($plateNumber) ?>"
              class="w-full p-3 border rounded-lg">
          </div>

          <!-- MV FILE NUMBER -->
          <div>
            <label class="font-semibold text-gray-700">MV File Number</label>
            <input type="text" id="mv-file-number" name="mv-file-number" class="w-full p-3 border rounded-lg">
          </div>

          <!-- VIN -->
          <div>
            <label class="font-semibold text-gray-700">VIN</label>
            <input type="text" id="vin" name="vin" class="w-full p-3 border rounded-lg">
          </div>

          <!-- ISSUE DATE -->
          <div>
            <label class="font-semibold text-gray-700">Issue Date</label>
            <input type="date" id="issue-date" name="issue-date" class="w-full p-3 border rounded-lg">
          </div>

          <!-- REGISTRATION STATUS -->
          <div>
            <label class="font-semibold text-gray-700">Registration Status</label>
            <div class="flex flex-wrap gap-6 mt-1">
              <?php foreach (["REGISTERED", "UNREGISTERED", "EXPIRED"] as $s): ?>
                <label class="flex items-center gap-2">
                  <input type="radio" name="registration-status" value="<?= $s ?>">
                  <span><?= $s ?></span>
                </label>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- VEHICLE INFO -->
          <h2 class="text-xl font-bold text-gray-700 border-b pb-2">Vehicle Details</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" id="brand-name" name="brand-name" placeholder="Brand Name (Make)"
              class="w-full p-3 border rounded-lg">
            <input type="text" id="model-name" name="model-name" placeholder="Model Name"
              class="w-full p-3 border rounded-lg">
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="number" id="model-year" name="model-year" placeholder="Model Year"
              class="w-full p-3 border rounded-lg">
            <input type="text" id="model-color" name="model-color" placeholder="Color"
              class="w-full p-3 border rounded-lg">
          </div>

          <!-- SUBMIT -->
          <button type="submit"
            class="bg-blue-600 text-white py-3 px-6 rounded-xl font-bold hover:bg-blue-800 transition w-full">
            Submit
          </button>

        </form>

      </div>
    </div>

  </div>

  <!-- UPDATE / EDIT SCRIPT -->
  <script>
    window.pagePlateNumber = "<?= $plateNumber ?>";
    window.pageVehicleId = "<?= $vehicleId ?>";
    window.pageMode = "vehicle-edit-create";

    window.userRole = "<?= $role ?>";
    window.userFName = "<?= $name ?>";
    window.userLName = "<?= $name ?>";

    document.addEventListener('DOMContentLoaded', () => {
      const roleEl = document.getElementById('userRoleDisplay');
      const navNameEl = document.getElementById('userNameNav');
      const sidebarNameEl = document.getElementById('userNameSidebar');

      if (roleEl) {
        roleEl.textContent = window.userRole;
        switch (window.userRole) {
          case 'ADMIN': roleEl.classList.add('text-red-600'); break;
          default: roleEl.classList.add('text-blue-600'); break;
        }
      }

      if (navNameEl) {
        navNameEl.textContent = window.userFName;
      }
      if (sidebarNameEl) {
        sidebarNameEl.textContent = window.userLName;
      }
    });
  </script>
</body>

</html>