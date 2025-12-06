<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Settings | MDT Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="../../../public/script.js"></script>
    <link rel="stylesheet" href="../../../public/style.css">
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
        <!-- SIDEBAR -->
        <div id="sidebar"
            class="bg-white w-56 h-screen shadow-2xl p-6 hidden md:block fixed top-0 left-0 transform transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0">
            <ul class="space-y-4">
                <li>
                    <div class="flex items-center gap-3 mt-10">
                        <img src="../../../public/assets/user.png" class="w-6 h-6">
                        <div>
                            <span class="block font-bold">LTO Officer</span>
                            <span class="block font-semibold">Tarub Salsalini</span>
                        </div>
                    </div>
                </li>
                <li><button onclick="window.location.href='officer_dashboard.php'"
                        class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">Dashboard</button></li>
                <li><button onclick="window.location.href='officer_vehicle.php'"
                        class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">Vehicle Lookup</button>
                </li>
                <li><button onclick="window.location.href='officer_license.php'"
                        class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">License Lookup</button>
                </li>
                <li><button onclick="window.location.href='officer_settings.php'"
                        class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">Settings</button></li>
            </ul>
        </div>

        <!-- MAIN CONTENT -->
        <div class="flex flex-col md:ml-56 w-full px-6 py-10">

            <h1 class="text-4xl font-extrabold mb-2 text-gray-800">Settings</h1>
            <p class="text-lg text-gray-600 mb-8">
                Submit a ticket for account-related changes or to contact support.
            </p>

            <!-- SUPPORT FORM CARD -->
            <div class="bg-white rounded-2xl shadow-xl p-8 max-w-2xl">

                <h2 class="text-2xl font-bold text-gray-800 mb-6">Support Ticket Form</h2>

                <p class="text-gray-600 mb-6">
                    Administrators must manually approve account changes.
                    Use this form to request:
                </p>

                <ul class="text-gray-700 text-sm mb-8 space-y-2 ml-2">
                    <li>• Password change or reset</li>
                    <li>• Update to account name or officer details</li>
                    <li>• Recovery for forgotten password</li>
                    <li>• Report account or login issues</li>
                    <li>• Contact administrative support</li>
                </ul>

                <!-- FORM -->
                <form action="support_submit.php" method="POST" class="space-y-6">

                    <!-- Category -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Support Category</label>
                        <select name="category"
                            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required>
                            <option value="">Select a category</option>
                            <option value="password-change">Password Change</option>
                            <option value="password-reset">Forgot Password / Reset</option>
                            <option value="account-update">Account Name / Details Update</option>
                            <option value="account-issue">Account or Login Issue</option>
                            <option value="other">Other Request</option>
                        </select>
                    </div>

                    <!-- Message -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Describe Your Issue</label>
                        <textarea name="message" rows="5"
                            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Explain what you need help with..." required></textarea>
                    </div>

                    <!-- Submit -->
                    <button
                        class="bg-blue-600 w-full text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                        Submit Ticket
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>