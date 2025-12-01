<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MDT System - Landing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-200 min-h-screen flex flex-col items-center">
    
    <!-- Top content -->
    <div class="flex flex-col items-center pt-16 pb-10">
        <img src="/MDT-CIVILIAN-DATA/public/assets/shield.png" class="w-32 h-32 mb-6" alt="MDT Logo">

        <h1 class="text-5xl font-extrabold text-black mb-6 text-center">Instant Vehicle &amp; License Data</h1>
        <p class="text-xl text-black mb-6 text-center">Smarter MDT. Faster civil processes.</p>

        <a href="/MDT-CIVILIAN-DATA/src/_pages/login.php" class="bg-blue-600 text-white font-bold px-10 py-4 rounded-xl shadow-lg hover:bg-blue-900 transition text-xl">
            Get Started
        </a>
    </div>

        <!-- Feature cards (new) -->
    <section class="w-full max-w-6xl px-6 pb-20">
        <div class="mx-auto">
            <div class="grid gap-8 grid-cols-1 md:grid-cols-3 items-stretch">
                <!-- Card 1 -->
                <div class="bg-blue-600 backdrop-blur-sm rounded-2xl p-8 flex flex-col items-center text-center shadow-lg">
                    <div class="w-24 h-24 rounded-full bg-blue-600 flex items-center justify-center mb-4 shadow-sm">
                        <img src="assets/ticket_9479752.png" alt="Smart Ticketing" class="w-12 h-12">
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Smart Ticketing</h3>
                    <p class="text-sm text-white">Easily create, view, and update traffic violation tickets.</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-blue-600 backdrop-blur-sm rounded-2xl p-8 flex flex-col items-center text-center shadow-lg">
                    <div class="w-24 h-24 rounded-full bg-blue-600 flex items-center justify-center mb-4 shadow-sm">
                        <img src="assets/check_16321395.png" alt="User-Friendly Dashboard" class="w-12 h-12">
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">User-Friendly Dashboard</h3>
                    <p class="text-sm text-white">Navigate between vehicle and driver tabs seamlessly.</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-blue-600 backdrop-blur-sm rounded-2xl p-8 flex flex-col items-center text-center shadow-lg">
                    <div class="w-24 h-24 rounded-full bg-blue-600 flex items-center justify-center mb-4 shadow-sm">
                        <img src="assets/responsive-design_18502815.png" alt="Responsive Interface" class="w-12 h-12">
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Responsive Interface</h3>
                    <p class="text-sm text-white">Access the system from desktop or mobile securely.</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
