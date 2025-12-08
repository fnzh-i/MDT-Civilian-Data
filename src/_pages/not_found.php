<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="../../public/style.css">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-24 w-24 text-red-600 mb-4" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v2m0 4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
        </svg>

        <h1 class="text-9xl font-extrabold text-red-600 mb-4">404</h1>
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Page Not Found</h2>
        <p class="text-gray-600 mb-6">Sorry, the page you are looking for does not exist.</p>

        <a href="user_dashboard.php"
            class="inline-flex items-center gap-2 bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Go Back Home
        </a>
    </div>

</body>

</html>