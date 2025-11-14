<?php
  require_once "DBConnect.php";
  require_once "Vehicle.php";

  session_start();

  $vehicle = $_SESSION['vehicle'];
  $vehicleId = $_SESSION['vehicle-id'];
  $plateNumber = $_SESSION['plate-number'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vehicle Search Result</title>
  <link rel="stylesheet" href="AdminStyle.css">
</head>
<body>
  <div>
    <p>Found vehicle with plate number <?= $plateNumber ?> and vehicle ID <?= $vehicleId ?></p>
    <br>
    <?= $vehicle->displayInfo() ?>
    <br>
  </div>
</body>
</html>