<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MDT Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="../../public/script.js"></script> 
    <link rel="stylesheet" href="../../public/style.css">
</head>
<body class="bg-gray-200">

    <!-- STICKY NAVBAR -->
    <nav class="bg-blue-600 shadow-lg px-6 py-3 flex justify-between items-center sticky top-0 z-50">
        <!-- burgir toggle -->
        <button id="sidebarToggle" class="flex flex-col justify-center space-y-1">
            <span class="block w-6 h-0.5 bg-white"></span>
            <span class="block w-6 h-0.5 bg-white"></span>
            <span class="block w-6 h-0.5 bg-white"></span>
        </button>
        <!-- Left: Dashboard link with burger icon -->
        <a href="dashboard.php" class="flex items-center gap-2 text-white font-bold hover:text-gray-200 transition">
            <span>Dashboard</span>
        </a>

        <!-- Right: Logout -->
        <a href="../../public/index.php" class="flex items-center gap-2 text-white font-bold hover:text-gray-200 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5" />
            </svg>
            <span>Logout</span>
        </a>
    </nav>
    

    <div class="flex flex-col md:flex-row">
        <!-- sidebar -->
        <div id="sidebar" class="bg-white w-56 h-screen shadow-2xl p-6 hidden md:block fixed top-0 left-0">
            <h2 class="text-2xl font-bold mb-6">Menu</h2>
            <ul class="space-y-4">
                <li>
                    <button onclick="window.location.href='vehicle.php'" class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
                        Vehicle Lookup
                    </button>
                </li>
                <li>
                    <button onclick="window.location.href='license.php'" class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
                        License Lookup
                    </button>
                </li>
                <li>
                    <button onclick="window.location.href='settings.php'" class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
                        Settings
                    </button>
                </li>
            </ul>
        </div>
        

        <!-- MAIN CONTENT CENTERED -->
        <div class="flex flex-col items-center justify-start h-[calc(100vh-64px)] px-4 w-[calc(100vw-64px)] mt-32 md:mt-0 py-32">
            <!-- Titles -->
            <h1 class="text-3xl font-extrabold mb-2 text-center text-black">Quick Access</h1>
            <h2 class="text-xl font-normal mb-10 text-center text-black">
                Select a search type to retrieve civilian data
            </h2>

            <!-- Buttons -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                <!-- VEHICLE BOX -->
                <div class="bg-white p-10 rounded-2xl shadow-xl flex flex-col items-center w-80">
                    <img src="../../public/assets/car.png" class="w-24 h-24 mb-6 opacity-80">
                    <button onclick="window.location.href='vehicle.php'"
                        class="bg-blue-600 text-white px-6 py-3 rounded-xl text-lg font-bold hover:bg-red-700 transition">
                        Check Vehicle
                    </button>
                </div>

                <!-- LICENSE BOX -->
                <div class="bg-white p-10 rounded-2xl shadow-xl flex flex-col items-center w-80">
                    <img src="../../public/assets/id.png" class="w-24 h-24 mb-6 opacity-80">
                    <button onclick="window.location.href='license.php'"
                        class="bg-blue-600 text-white px-6 py-3 rounded-xl text-lg font-bold hover:bg-red-700 transition">
                        Check License
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
