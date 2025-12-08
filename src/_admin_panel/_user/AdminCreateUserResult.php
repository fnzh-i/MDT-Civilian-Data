<?php
session_start();
$role = $_SESSION['role'] ?? 'OFFICER'; // fallback if session not set
$name = ($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? 'MDT-BOT'); // you store name

require dirname(__DIR__) . "../bootstrap.php";

// ETO YUNG DEFAULT VALUES
$id = "";
$role = "";
$firstName = "";
$middleName = "";
$lastName = "";
$email = "";
$password = "";

// IF MANGGAGALING SA VIA UPDATE
if (isset($_GET['updateID'])) {
    $id = $_GET['updateID'];
    $role = $_GET['role'] ?? "";
    $firstName = $_GET['first_name'] ?? "";
    $middleName = $_GET['middle_name'] ?? "";
    $lastName = $_GET['last_name'] ?? "";
    $email = $_GET['email'] ?? "";
    $password = isset($_GET['default_password']) ? (string) $_GET['default_password'] : "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN CREATE USER</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
        }

        input,
        button {
            font: inherit;
        }
    </style>
</head>

<body>
    <strong>ADMIN CREATE USER</strong>
    <br><br>
    <form action="AdminUser.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

        Role:
        <input type="radio" name="role" id="user" value="USER" <?php if ($role === 'USER')
            echo 'checked'; ?>>
        <label for="user">USER</label>

        <input type="radio" name="role" id="enforcer" value="ENFORCER" <?php if ($role === 'ENFORCER')
            echo 'checked'; ?>>
        <label for="enforcer">ENFORCER</label>

        <input type="radio" name="role" id="supervisor" value="SUPERVISOR" <?php if ($role === 'SUPERVISOR')
            echo 'checked'; ?>>
        <label for="supervisor">SUPERVISOR</label>

        <input type="radio" name="role" id="admin" value="ADMIN" <?php if ($role === 'ADMIN')
            echo 'checked'; ?>>
        <label for="admin">ADMIN</label>
        <br><br>

        <label for="first_name">First name:</label>
        <input type="text" name="first_name" id="firstname" value="<?php echo htmlspecialchars($firstName); ?>">
        <br><br>

        <label for="middle_name">Middle name:</label>
        <input type="text" name="middle_name" id="middlename" value="<?php echo htmlspecialchars($middleName); ?>">
        <br><br>

        <label for="last_name">Last name:</label>
        <input type="text" name="last_name" id="lastname" value="<?php echo htmlspecialchars($lastName); ?>">
        <br><br>

        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>">
        <br><br>

        <label for="password">Password:</label>
        <input type="<?php echo ($id > 0) ? 'text' : 'password'; ?>" name="password" id="password"
            value="<?php echo htmlspecialchars($password); ?>">
        <br><br>

        <?php
        if ($id > 0) {
            echo "<input type='submit' name='update' value='UPDATE'>";
        } else {
            echo "<input type='submit' name='insert' value='INSERT'>";
        }
        ?>
    </form>
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