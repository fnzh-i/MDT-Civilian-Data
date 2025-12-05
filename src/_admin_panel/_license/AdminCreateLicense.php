<?php
require_once __DIR__ . '/../../bootstrap.php';
$licenseNumber = $_GET['license-number'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>MDT Admin Create License</title>
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
    <div class="absolute left-1/2 transform -translate-x-1/2">
      <a href="admin_dashboard.php" class="flex items-center gap-2 text-white font-bold hover:text-gray-200 transition">
        <span>MDT Admin Panel (Create License)</span>
      </a>
    </div>
    <div>
      <!-- Right: Logout -->
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
    <!-- sidebar -->
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
          <button onclick="window.location.href='adminCreateLicense.php'"
            class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
            Create License
          </button>
        </li>

        <li>
          <button onclick="window.location.href='adminSearchLicense.php'"
            class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
            Edit License
          </button>
        </li>

        <li>
          <button onclick="window.location.href='admin_settings.php'"
            class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
            Settings
          </button>
        </li>

      </ul>
    </div>
  </div>

  <!-- MAIN CONTENT -->
  <div
    class="flex flex-col items-center justify-start h-[calc(100vh-64px)] px-4 w-[calc(101vw-64px)] mt-32 md:mt-0 py-32">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-4xl mx-auto h-[85vh] overflow-y-auto">

      <h1 class="text-3xl font-extrabold text-gray-800 mb-6">
        <?= $licenseNumber ? "Update License" : "Create New License" ?>
      </h1>

      <form action="../../_modules/Controller.php" method="POST" class="forms space-y-6">

        <input type="hidden" name="action" value="CREATE-LICENSE">

        <!-- SECTION: LICENSE INFO -->
        <h2 class="text-xl font-bold text-gray-700 border-b pb-2">License Information</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="font-semibold text-gray-700">License Number</label>
            <input type="text" id="license-number" name="license-number" class="w-full p-3 border rounded-lg">
          </div>

          <div>
            <label class="font-semibold text-gray-700">Issue Date</label>
            <input type="date" id="issue-date" name="issue-date" class="w-full p-3 border rounded-lg">
          </div>
        </div>

        <div class="space-y-4">
          <div>
            <label class="font-semibold text-gray-700">License Status</label>
            <div class="flex flex-wrap gap-4 mt-1">
              <?php
              $statuses = ["REGISTERED", "UNREGISTERED", "EXPIRED", "REVOKED"];
              foreach ($statuses as $s): ?>
                <label class="flex items-center gap-2">
                  <input type="radio" name="license-status" value="<?= $s ?>">
                  <span><?= $s ?></span>
                </label>
              <?php endforeach; ?>
            </div>
          </div>

          <div>
            <label class="font-semibold text-gray-700">License Type</label>
            <div class="flex flex-wrap gap-4 mt-1">
              <?php
              $types = ["PROFESSIONAL", "NON-PROFESSIONAL", "STUDENT PERMIT"];
              foreach ($types as $t): ?>
                <label class="flex items-center gap-2">
                  <input type="radio" name="license-type" value="<?= $t ?>">
                  <span><?= $t ?></span>
                </label>
              <?php endforeach; ?>
            </div>
          </div>

          <div>
            <label class="font-semibold text-gray-700">Expiry Option</label>
            <div class="flex gap-4 mt-1">
              <label class="flex items-center gap-2"><input type="radio" name="expiry-option" value="5"> <span>5
                  Years</span></label>
              <label class="flex items-center gap-2"><input type="radio" name="expiry-option" value="10"> <span>10
                  Years</span></label>
            </div>
          </div>

          <div>
            <label class="font-semibold text-gray-700">DL Codes</label>
            <div class="flex flex-wrap gap-3 mt-2">
              <?php foreach (["A", "A1", "B", "B1", "C", "D"] as $code): ?>
                <label class="flex items-center gap-2">
                  <input type="checkbox" name="dl-codes[]" value="<?= $code ?>">
                  <span><?= $code ?></span>
                </label>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <!-- SECTION: PERSONAL INFO -->
        <h2 class="text-xl font-bold text-gray-700 border-b pb-2">Personal Information</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <input id="first-name" name="first-name" placeholder="First Name" class="w-full p-3 border rounded-lg">
          <input id="middle-name" name="middle-name" placeholder="Middle Name" class="w-full p-3 border rounded-lg">
          <input id="last-name" name="last-name" placeholder="Last Name" class="w-full p-3 border rounded-lg">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input type="date" id="date-of-birth" name="date-of-birth" class="w-full p-3 border rounded-lg">
          <div class="flex items-center gap-6">
            <label class="flex items-center gap-2"><input type="radio" name="sex" value="Male"> Male</label>
            <label class="flex items-center gap-2"><input type="radio" name="sex" value="Female"> Female</label>
          </div>
        </div>

        <input id="address" name="address" placeholder="Address" class="w-full p-3 border rounded-lg">
        <input id="nationality" name="nationality" placeholder="Nationality" class="w-full p-3 border rounded-lg">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <input id="Height" name="height" placeholder="Height (cm)" class="w-full p-3 border rounded-lg">
          <input id="weight" name="weight" placeholder="Weight (kg)" class="w-full p-3 border rounded-lg">
          <input id="eye-color" name="eye-color" placeholder="Eye Color" class="w-full p-3 border rounded-lg">
        </div>

        <input id="blood-type" name="blood-type" placeholder="Blood Type" class="w-full p-3 border rounded-lg">

        <button type="submit"
          class="bg-blue-600 text-white py-3 px-6 rounded-xl font-bold hover:bg-blue-900 transition w-full">
          Submit
        </button>
      </form>
    </div>
  </div>
  </div>
</body>

</html>