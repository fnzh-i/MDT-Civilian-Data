<?php
session_start();
$role = $_SESSION['role'] ?? 'OFFICER'; // fallback if session not set
$name = ($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? 'MDT-BOT'); // you store name
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Check License</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="../../../public/script.js"></script>
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
            <span class="text-white block font-semibold truncate max-w-xs" id="userNameNav">Tarub Salsalini</span>
        </div>
        <div class="absolute left-1/2 transform -translate-x-1/2">
            <a href="officer_dashboard.php"
                class="flex items-center gap-2 text-white font-bold hover:text-gray-200 transition">
                <span>Mobile Data Terminal</span>
            </a>
        </div>
        <div>
            <!-- Right: Logout -->
            <a href="../../../public/index.php"
                class="flex items-center gap-2 text-white font-bold hover:text-gray-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
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
                                <span class="block font-bold" id="userRoleDisplay">LTO MDT</span>
                                <span class="block font-semibold" id="userNameSidebar">Tarub Salsalini</span>
                            </div>
                        </div>
                    </span>
                </li>
                <li>
                    <button onclick="window.location.href='officer_dashboard.php'"
                        class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
                        Dashboard
                    </button>
                </li>
                <li>
                    <button onclick="window.location.href='officer_vehicle.php'"
                        class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
                        Vehicle Lookup
                    </button>
                </li>
                <li>
                    <button onclick="window.location.href='officer_license.php'"
                        class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
                        License Lookup
                    </button>
                </li>
                <li>
                    <button onclick="window.location.href='officer_settings.php'"
                        class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
                        Settings
                    </button>
                </li>
            </ul>
        </div>

        <!-- MAIN CONTENT -->
        <div
            class="flex flex-col items-center justify-start h-[calc(100vh-64px)] px-4 w-[calc(100vw-64px)] mt-32 md:mt-0 py-32">
            <!-- Titles -->
            <h1 class="text-3xl font-extrabold mb-5 text-center text-black">Driver's License Lookup</h1>

            <!-- Input and Search Button -->
            <div class="mb-4 flex flex-col sm:flex-row gap-2 justify-center w-full max-w-md mx-auto">
                <input id="licenseInput" type="text" placeholder="Enter License Number"
                    class="p-3 border rounded-lg w-full sm:w-80">
                <button onclick="lookupLicense()"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition font-bold">
                    Search
                </button>
            </div>

            <!-- Error Message -->
            <p id="error" class="text-red-600 font-semibold mb-4 text-center hidden">
                Driver's License Information doesn't exist. Please check your input details.
            </p>

            <!-- License Info Box -->
            <div id="infoBox"
                class="flex flex-col justify-center hidden max-w-4xl w-full bg-white p-6 rounded-2xl shadow-lg text-gray-800 mx-auto">
                <!-- Content will be injected by script.js -->
            </div>
        </div>

        <!-- EDIT VIOLATION MODAL (hidden by default) -->
        <div id="addViolationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg max-w-md w-full shadow-xl">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <h2 id="modalTitle" class="text-xl font-semibold">Add New Ticket Violation</h2>
                        <button onclick="closeAddViolationModal()"
                            class="text-gray-500 hover:text-gray-800">&times;</button>
                    </div>

                    <div id="modalError" class="text-red-600 text-sm mb-3 hidden"></div>

                    <div class="mb-3">
                        <label class="font-semibold">Status:</label>
                        <select id="modal_v_status" class="border p-2 rounded w-full">
                            <option value="UNSETTLED">Unsettled</option>
                            <option value="SETTLED">Settled</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-2 mt-4">
                        <button onclick="closeAddViolationModal()" class="px-4 py-2 rounded-md border">Cancel</button>
                        <button id="modalSubmitBtn" onclick="updateViolationStatus()"
                            class="px-4 py-2 rounded-md bg-blue-600 text-white">Update Violation</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
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
                        case 'SUPERVISOR': roleEl.classList.add('text-yellow-600'); break;
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