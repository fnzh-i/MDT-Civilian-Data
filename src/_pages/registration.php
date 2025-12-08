<?php
declare(strict_types=1);
require_once __DIR__ . '/../bootstrap.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MDT System - Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="../../public/script.js"></script>
    <link rel="stylesheet" href="../../public/style.css">
</head>

<body class="bg-gray-200 h-screen flex flex-col items-center justify-center">

    <div class="bg-white p-10 rounded-2xl shadow-2xl w-[40rem] max-w-full">

        <h1 class="text-3xl font-extrabold text-center mb-6">Register</h1>

        <p class="text-gray-600 text-center mb-6">
            Create a new civilian profile for the MDT system.
        </p>

        <!-- Registration Form -->
        <div class="space-y-6 max-h-[60vh] overflow-y-auto pr-2">

            <!-- PERSONAL INFO -->
            <div class="space-y-4">
                <!-- First, Middle, Last Name -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-gray-700 text-sm font-semibold">First Name</label>
                        <input id="first_name" type="text" placeholder="Tarub" class="w-full p-3 border rounded-lg">
                    </div>
                    <div>
                        <label class="text-gray-700 text-sm font-semibold">Middle Name</label>
                        <input id="middle_name" type="text" placeholder="Optional" class="w-full p-3 border rounded-lg">
                    </div>
                    <div>
                        <label class="text-gray-700 text-sm font-semibold">Last Name</label>
                        <input id="last_name" type="text" placeholder="Salsalini" class="w-full p-3 border rounded-lg">
                    </div>
                </div>

                <!-- License Number -->
                <div>
                    <label class="text-gray-700 text-sm font-semibold">License Number</label>
                    <input id="license" type="text" placeholder="N69-21-173867" class="w-full p-3 border rounded-lg">
                </div>

                <!-- Date of Birth -->
                <div>
                    <label class="text-gray-700 text-sm font-semibold">Date of Birth</label>
                    <input id="dob" type="date" class="w-full p-3 border rounded-lg">
                </div>

                <!-- Weight & Height -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-700 text-sm font-semibold">Weight (kg)</label>
                        <input id="weight" type="number" placeholder="45" class="w-full p-3 border rounded-lg">
                    </div>

                    <div>
                        <label class="text-gray-700 text-sm font-semibold">Height (m)</label>
                        <input id="height" type="number" placeholder="1.70" class="w-full p-3 border rounded-lg">
                    </div>
                </div>

                <!-- Expiration Date -->
                <div>
                    <label class="text-gray-700 text-sm font-semibold">Expiration Date</label>
                    <input id="expdate" type="date" class="w-full p-3 border rounded-lg">
                </div>

            </div>


            <!-- DIVIDER -->
            <hr class="border-gray-300 my-4">

            <!-- ACCOUNT INFO -->
            <div class="space-y-4">
                <div>
                    <label class="text-gray-700 text-sm font-semibold">Email</label>
                    <input id="email" type="email" placeholder="example@example.com"
                        class="w-full p-3 border rounded-lg">
                </div>

                <div>
                    <label class="text-gray-700 text-sm font-semibold">Password</label>
                    <input id="password" type="password" placeholder="********" class="w-full p-3 border rounded-lg">
                </div>
            </div>

        </div>


        <div class="mt-6">
            <button onclick="registerUser()"
                class="w-full bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-900 transition font-bold">
                Register
            </button>

            <p id="registerError" class="text-red-500 text-center mt-3 hidden">
                Please fill in all fields.
            </p>
        </div>

        <div class="mt-6 text-center text-sm text-gray-600">
            Already have an account?
            <a href="login.php" class="underline hover:text-blue-700">Back to Login</a>
        </div>

    </div>
</body>

</html>