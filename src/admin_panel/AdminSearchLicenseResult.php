<?php
  require_once "DBConnect.php";
  require_once "DriversLicense.php";

  session_start();

  $license = $_SESSION['license'];
  $licenseId = $_SESSION['license-id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>License Search Result</title>
  <link rel="stylesheet" href="AdminStyle.css">
</head>
<body>
  <div>
    <p>Found license with license number <?= $license->getLicenseNumber() ?> and license ID <?= $licenseId ?></p>
    <br>
    <?= $license->displayInfo() ?>
    <br>
    <a href="AdminCreateTicket.php" class="btn">Create Ticket</a>
  </div>
</body>
</html>
