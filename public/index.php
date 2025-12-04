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
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
            class="w-32 h-32 text-black mb-6">
            <path fill-rule="evenodd"
                d="M12.516 2.17a.75.75 0 0 0-1.032 0 11.209 11.209 0 0 1-7.877 3.08.75.75 0 0 0-.722.515A12.74 12.74 0 0 0 2.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 0 0 .374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 0 0-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08Zm3.094 8.016a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                clip-rule="evenodd" />
        </svg>


        <h1 class="text-5xl font-extrabold text-black mb-6 text-center">Instant Vehicle &amp; License Data</h1>
        <p class="text-xl text-black mb-6 text-center">Smarter MDT. Faster civil processes.</p>

        <a href="/MDT-CIVILIAN-DATA/src/_pages/login.php"
            class="bg-blue-600 text-white font-bold px-10 py-4 rounded-xl shadow-lg hover:bg-blue-900 transition text-xl">
            Get Started
        </a>
    </div>

    <!-- Feature cards (new) -->
    <section class="w-full max-w-6xl px-6 pb-20">
        <div class="mx-auto">
            <div class="grid gap-8 grid-cols-1 md:grid-cols-3 items-stretch">
                <!-- Card 1 -->
                <div
                    class="bg-blue-600 backdrop-blur-sm rounded-2xl p-8 flex flex-col items-center text-center shadow-lg">
                    <!-- SVG ICON -->
                    <div class="w-24 h-24 rounded-full bg-blue-600 flex items-center justify-center mb-4 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-12 h-12 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                        </svg>
                    </div>

                    <h3 class="text-lg font-semibold text-white mb-2">Smart Ticketing</h3>
                    <p class="text-sm text-white">Easily create, view, and update traffic violation tickets.</p>
                </div>


                <!-- Card 2 -->
                <div
                    class="bg-blue-600 backdrop-blur-sm rounded-2xl p-8 flex flex-col items-center text-center shadow-lg">
                    <div class="w-24 h-24 rounded-full bg-blue-600 flex items-center justify-center mb-4 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-12 h-12 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">User-Friendly Dashboard</h3>
                    <p class="text-sm text-white">Navigate between vehicle and driver tabs seamlessly.</p>
                </div>

                <!-- Card 3 -->
                <div
                    class="bg-blue-600 backdrop-blur-sm rounded-2xl p-8 flex flex-col items-center text-center shadow-lg">
                    <div class="w-24 h-24 rounded-full bg-blue-600 flex items-center justify-center mb-4 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-12 h-12 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Responsive Interface</h3>
                    <p class="text-sm text-white">Access the system from desktop or mobile securely.</p>
                </div>
            </div>
        </div>
    </section>
</body>

</html>