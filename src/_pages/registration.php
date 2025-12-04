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

    <div class="bg-white p-10 rounded-2xl shadow-2xl w-96">

        <h1 class="text-3xl font-extrabold text-center mb-6">Register</h1>

        <p class="text-gray-600 text-center mb-6">
            Create a new civilian profile for the MDT system.
        </p>

        <!-- Registration Form -->
        <div class="space-y-4">

            <input id="fullname" type="text" placeholder="Full Name" class="w-full p-3 border rounded-lg">

            <input id="license" type="text" placeholder="License Number" class="w-full p-3 border rounded-lg">

            <label class="text-gray-700 text-sm font-semibold">Date of Birth</label>
            <input id="dob" type="date" class="w-full p-3 border rounded-lg">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-gray-700 text-sm font-semibold">Weight (kg)</label>
                    <input id="weight" type="number" placeholder="Weight" class="w-full p-3 border rounded-lg">
                </div>

                <div>
                    <label class="text-gray-700 text-sm font-semibold">Height (cm)</label>
                    <input id="height" type="number" placeholder="Height" class="w-full p-3 border rounded-lg">
                </div>
            </div>

            <label class="text-gray-700 text-sm font-semibold">Expiration Date</label>
            <input id="expdate" type="date" class="w-full p-3 border rounded-lg">

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