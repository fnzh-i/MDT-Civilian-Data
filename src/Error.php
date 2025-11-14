<?php
  require_once "DBConnect.php";
  require_once "User.php";
  require_once "Vehicle.php";
  require_once "DriversLicense.php";
  require_once "TicketViolation.php";

  session_start();

  $error = $_SESSION['error-message'] ?? "An unknown error occurred.";
  unset($_SESSION['error-message'])
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error Page</title>
  <link rel="stylesheet" href="AdminStyle.css">
</head>
<body>
  <div>
    <?= $error ?>
  </div>
</body>
</html>