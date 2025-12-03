<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings | MDT Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="../../public/script.js"></script> 
    <link rel="stylesheet" href="../../public/style.css">
</head>
<body class="bg-gray-200">

    <!-- STICKY NAVBAR -->
    <nav class="bg-blue-600 shadow-lg px-6 py-3 relative flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <!-- burger toggle -->
            <button id="sidebarToggle" class="flex flex-col justify-center space-y-1">
                <span class="block w-6 h-0.5 bg-white"></span>
                <span class="block w-6 h-0.5 bg-white"></span>
                <span class="block w-6 h-0.5 bg-white"></span>
            </button>
            <span class="text-white block font-semibold truncate max-w-xs">Tarub Salsalini</span>
        </div>
        <div class="absolute left-1/2 transform -translate-x-1/2">
            <a href="officer_dashboard.php" class="flex items-center gap-2 text-white font-bold hover:text-gray-200 transition">
                <span>Mobile Data Terminal</span>
            </a>    
        </div>
        <div>
            <!-- Right: Logout -->
            <a href="../../public/index.php" class="flex items-center gap-2 text-white font-bold hover:text-gray-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5" />
                </svg>
                <span>Logout</span>
            </a>
        </div>
    </nav>

    <div class="flex flex-col md:flex-row">
        <!-- SIDEBAR -->
        <div id="sidebar" class="bg-white w-56 h-screen shadow-2xl p-6 hidden md:block fixed top-0 left-0 transform transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0">
            <ul class="space-y-4">
                <li>
                    <div class="flex items-center gap-3 mt-10">
                        <img src="../../public/assets/user.png" class="w-6 h-6">
                        <div>
                            <span class="block font-bold">LTO Officer</span>
                            <span class="block font-semibold">Tarub Salsalini</span>
                        </div>
                    </div>
                </li>
                <li><button onclick="window.location.href='officer_dashboard.php'" class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">Dashboard</button></li>
                <li><button onclick="window.location.href='officer_vehicle.php'" class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">Vehicle Lookup</button></li>
                <li><button onclick="window.location.href='officer_license.php'" class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">License Lookup</button></li>
                <li><button onclick="window.location.href='settings.php'" class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">Settings</button></li>
            </ul>
        </div>

        <!-- MAIN CONTENT -->
        <div class="flex flex-col md:ml-56 w-full px-6 py-10">

            <h1 class="text-4xl font-extrabold mb-2 text-gray-800">Settings</h1>
            <p class="text-lg text-gray-600 mb-8">Manage your account and preferences</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <!-- Account Settings -->
                <div class="bg-white rounded-2xl shadow-xl p-6 flex flex-col items-center">
                    <img src="../../public/assets/user.png" class="w-16 h-16 mb-4 opacity-80">
                    <h2 class="text-xl font-bold mb-2">Account Settings</h2>
                    <p class="text-gray-600 text-center mb-4">Update your personal information, username, and email.</p>
                    <button onclick="window.location.href='account_settings.php'" class="bg-blue-600 text-white px-6 py-2 rounded-xl font-semibold hover:bg-blue-700 transition">Edit</button>
                </div>

                <!-- Security Settings -->
                <div class="bg-white rounded-2xl shadow-xl p-6 flex flex-col items-center">
                    <img src="../../public/assets/lock.png" class="w-16 h-16 mb-4 opacity-80">
                    <h2 class="text-xl font-bold mb-2">Security Settings</h2>
                    <p class="text-gray-600 text-center mb-4">Change your password, enable 2FA, and manage security options.</p>
                    <button onclick="window.location.href='security_settings.php'" class="bg-blue-600 text-white px-6 py-2 rounded-xl font-semibold hover:bg-blue-700 transition">Edit</button>
                </div>

                <!-- Support -->
                <div class="bg-white rounded-2xl shadow-xl p-6 flex flex-col items-center">
                    <img src="../../public/assets/support.png" class="w-16 h-16 mb-4 opacity-80">
                    <h2 class="text-xl font-bold mb-2">Support</h2>
                    <p class="text-gray-600 text-center mb-4">Contact support or report a problem.</p>
                    <button onclick="window.location.href='support.php'" class="bg-blue-600 text-white px-6 py-2 rounded-xl font-semibold hover:bg-blue-700 transition">Contact</button>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
