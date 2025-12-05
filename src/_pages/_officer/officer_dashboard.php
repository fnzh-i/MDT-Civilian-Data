<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MDT Dashboard</title>
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
            <span class="text-white block font-semibold truncate max-w-xs">Tarub Salsalini</span>
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
                                <span class="block font-bold">LTO Officer</span>
                                <span class="block font-semibold">Tarub Salsalini</span>
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


        <!-- MAIN CONTENT CENTERED -->
        <div
            class="flex flex-col items-center justify-start h-[calc(100vh-64px)] px-4 w-[calc(101vw-64px)] mt-32 md:mt-0 py-32">
            <!-- Titles -->
            <h1 class="text-4xl font-extrabold mb-2 text-gray-800">Officer Dashboard</h1>
            <p class="text-lg text-gray-600 mb-8">Select a search type to retrieve civilian data</p>

            <!-- Buttons -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 px-4 sm:px-6 md:px-10">
                <!-- VEHICLE BOX -->
                <div class="bg-white p-10 rounded-2xl shadow-xl flex flex-col items-center w-80 mx-auto">
                    <img src="../../../public/assets/car.png" class="w-24 h-24 mb-6 opacity-80">
                    <button onclick="window.location.href='officer_vehicle.php'"
                        class="bg-blue-600 text-white px-6 py-3 rounded-xl text-lg font-bold hover:bg-red-700 transition">
                        Check Vehicle
                    </button>
                </div>

                <!-- LICENSE BOX -->
                <div class="bg-white p-10 rounded-2xl shadow-xl flex flex-col items-center w-80 mx-auto">
                    <img src="../../../public/assets/id.png" class="w-24 h-24 mb-6 opacity-80">
                    <button onclick="window.location.href='officer_license.php'"
                        class="bg-blue-600 text-white px-6 py-3 rounded-xl text-lg font-bold hover:bg-red-700 transition">
                        Check License
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>