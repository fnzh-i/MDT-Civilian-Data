<?php
session_start();
$role = $_SESSION['role'] ?? 'OFFICER'; // fallback if session not set
$name = ($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? 'MDT-BOT'); // you store name

require_once __DIR__ . '/../../bootstrap.php';

$message = ""; // To store insert/update/delete feedback

// INSERT COMMAND
if (isset($_POST['insert'])) {

    // Check duplicate email
    $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $check->bind_param("s", $_POST['email']);
    $check->execute();
    $checkResult = $check->get_result();

    if ($checkResult->num_rows > 0) {
        $message = "<div class='text-red-600 font-bold mb-4'>DUPLICATE ENTRY</div>";
    } else {
        // Convert form data
        $role = Roles::from($_POST['role']);
        $first = $_POST['first_name'];
        $middle = $_POST['middle_name'] ?? null;
        $last = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // CREATE USER
        $user = User::createByAdmin($role, $first, $last, $email, $password, $middle);
        $result = $user->save($conn, null);

        $message = $result
            ? "<div class='text-green-600 font-bold mb-4'>Insert Successful</div>"
            : "<div class='text-red-600 font-bold mb-4'>Insert Unsuccessful: {$conn->error}</div>";
    }
}

// UPDATE COMMAND
if (isset($_POST['update'])) {
    $userId = $_POST['id'];
    $role = Roles::from($_POST['role']);
    $first = $_POST['first_name'];
    $middle = $_POST['middle_name'] ?? null;
    $last = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $existing = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$existing) {
        $message = "<div class='text-red-600 font-bold mb-4'>User not found</div>";
    } else {
        $user = User::createByAdmin($role, $first, $last, $email, $password, $middle);

        $query = "
            UPDATE users SET 
                role = ?, 
                first_name = ?, 
                middle_name = ?, 
                last_name = ?, 
                email = ?, 
                password = ?
            WHERE user_id = ?
        ";

        $stmt = $conn->prepare($query);
        $hashedPassword = $user->getPassword();
        $roleValue = $role->value;

        $stmt->bind_param(
            "ssssssi",
            $roleValue,
            $first,
            $middle,
            $last,
            $email,
            $hashedPassword,
            $userId
        );

        $message = $stmt->execute()
            ? "<div class='text-green-600 font-bold mb-4'>Update Successful</div>"
            : "<div class='text-red-600 font-bold mb-4'>Update Unsuccessful: {$conn->error}</div>";

        $stmt->close();
    }
}

// DELETE COMMAND
if (isset($_GET['deleteID'])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $_GET['deleteID']);
    $message = $stmt->execute()
        ? "<div class='text-green-600 font-bold mb-4'>Delete Successful</div>"
        : "<div class='text-red-600 font-bold mb-4'>Delete Unsuccessful</div>";
    $stmt->close();
}

// SELECT COMMAND
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDT Admin User Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDT Admin Create License</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="../../../public/admin_script.js"></script>
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
            <span class="text-white block font-semibold truncate max-w-xs" id="userNameNav">Administrator</span>
        </div>

        <!-- Title centered -->
        <div class="absolute left-1/2 transform -translate-x-1/2">
            <a href="../admin_dashboard.php"
                class="flex items-center gap-2 text-white font-bold hover:text-gray-200 transition">
                <span>MDT Admin (Create License)</span>
            </a>
        </div>

        <!-- Right: Logout -->
        <div>
            <a href="../../public/index.php"
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

    <div class="flex flex-col md:flex-row"> <!-- sidebar (Admin Version) -->
        <div id="sidebar" class="bg-white w-56 h-screen shadow-2xl p-6 hidden md:block fixed top-0 left-0">
            <ul class="space-y-4">

                <li>
                    <span class="items-start w-full text-left text-gray-700 hover:text-blue-600 font-bold">
                        <div class="flex items-center gap-3 mt-10">
                            <span><img src="../../../public/assets/user.png" class="w-6 h-6 inline-block"></span>
                            <div>
                                <span class="block font-bold" id="userRoleDisplay">Administrator</span>
                                <span class="block font-semibold" id="userNameSidebar">MDT System</span>
                            </div>
                        </div>
                    </span>
                </li>

                <li>
                    <button onclick="window.location.href='../admin_dashboard.php'"
                        class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
                        Dashboard
                    </button>
                </li>

                <li>
                    <button onclick="window.location.href='../_user/adminCreateUser.php'"
                        class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
                        Create User
                    </button>
                </li>

                <li>
                    <button onclick="window.location.href='../_license/adminCreateLicense.php'"
                        class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
                        Create License
                    </button>
                </li>

                <li>
                    <button onclick="window.location.href='../_vehicle/adminCreateVehicle.php'"
                        class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
                        Create Vehicle
                    </button>
                </li>

                <li>
                    <button onclick="window.location.href='../_license/adminSearchLicense.php'"
                        class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
                        Search & Edit License
                    </button>
                </li>

                <li>
                    <button onclick="window.location.href='../_vehicle/adminSearchVehicle.php'"
                        class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
                        Search & Edit Vehicle
                    </button>
                </li>

                <li>
                    <button onclick="window.location.href='../admin_settings.php'"
                        class="w-full text-left text-gray-700 hover:text-blue-600 font-semibold">
                        Settings
                    </button>
                </li>

            </ul>
        </div>

        <!-- MAIN CONTENT -->
        <div class="flex flex-col items-center justify-start px-4 w-full mt-32 md:mt-0 py-32">
            <div class="flex flex-col items-center justify-start px-4 w-full py-32">
                <div class="max-w-7xl mx-auto bg-white p-6 rounded-2xl shadow-xl">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6">User Management</h1>
                    <div class="overflow-x-auto">
                        <!-- FEEDBACK MESSAGE -->
                        <?= $message ?>
                        <table class="min-w-full border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border-b">User ID</th>
                                    <th class="px-4 py-2 border-b">Role</th>
                                    <th class="px-4 py-2 border-b">First Name</th>
                                    <th class="px-4 py-2 border-b">Middle Name</th>
                                    <th class="px-4 py-2 border-b">Last Name</th>
                                    <th class="px-4 py-2 border-b">Email</th>
                                    <th class="px-4 py-2 border-b">Password</th>
                                    <th class="px-4 py-2 border-b">Update</th>
                                    <th class="px-4 py-2 border-b">Delete</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <?php if ($result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 border-b"><?= $row['user_id'] ?></td>
                                            <td class="px-4 py-2 border-b"><?= $row['role'] ?></td>
                                            <td class="px-4 py-2 border-b"><?= $row['first_name'] ?></td>
                                            <td class="px-4 py-2 border-b"><?= $row['middle_name'] ?></td>
                                            <td class="px-4 py-2 border-b"><?= $row['last_name'] ?></td>
                                            <td class="px-4 py-2 border-b"><?= $row['email'] ?></td>
                                            <td class="px-4 py-2 border-b"><?= $row['password'] ?></td>
                                            <td class="px-4 py-2 border-b">
                                                <a href="AdminCreateUser.php?updateID=<?= $row['user_id'] ?>&role=<?= $row['role'] ?>&first_name=<?= $row['first_name'] ?>&middle_name=<?= $row['middle_name'] ?>&last_name=<?= $row['last_name'] ?>&email=<?= $row['email'] ?>&default_password=<?= $row['default_password'] ?>"
                                                    class="text-blue-600 hover:underline">Update</a>
                                            </td>
                                            <td class="px-4 py-2 border-b">
                                                <a href="AdminUser.php?deleteID=<?= $row['user_id'] ?>"
                                                    class="text-red-600 hover:underline">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-gray-500">No Data</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="my-6 flex gap-6">
                            <a href="AdminCreateUser.php"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">Create
                                User</a>
                        </div>
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