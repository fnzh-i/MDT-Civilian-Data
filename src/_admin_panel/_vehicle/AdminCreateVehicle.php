<?php
  require_once __DIR__ . '/../../bootstrap.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN CREATE VEHICLE</title>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 18px;
    }
    button, input {
      font: inherit;
    }
  </style>
</head>
<body>
    <strong>ADMIN CREATE VEHICLE</strong>
    <br>
    <br>

    <form action="../../_modules/Controller.php" method="POST" class="forms">
      <input type="hidden" name="action" value="CREATE-VEHICLE">

      <label for="license-id">License ID:</label>
      <input type="number" id="license-id" name="license-id" placeholder="FOR FOREIGN KEY">
      <br> <br>

      <label for="plate-number">Plate Number:</label>
      <input type="text" id="plate-number" name="plate-number">
      <br> <br>

      <label for="mv-file-number">MV File Number:</label>
      <input type="text" id="mv-file-number" name="mv-file-number">
      <br> <br>

      <label for="vin">VIN:</label>
      <input type="text" id="vin" name="vin">
      <br> <br>

      <label for="issue-date">Issue Date:</label>
      <input type="date" id="issue-date" name="issue-date">
      <br> <br>

      Registration Status:
      <input type="radio" id="registered" name="registration-status" value="REGISTERED">
      <label for="pro">REGISTERED</label>

      <input type="radio" id="unregistered" name="registration-status" value="UNREGISTERED">
      <label for="nonpro">UNREGISTERED</label>

      <input type="radio" id="expired" name="registration-status" value="EXPIRED">
      <label for="student">EXPIRED</label>
      <br> <br>

      <label for="brand-name">Brand Name (Make):</label>
      <input type="text" id="brand-name" name="brand-name">
      <br> <br>

      <label for="model-name">Model Name:</label>
      <input type="text" id="model-name" name="model-name">
      <br> <br>

      <label for="model-year">Model Year:</label>
      <input type="number" id="model-year" name="model-year">
      <br> <br>

      <label for="model-color">Model Color:</label>
      <input type="text" id="model-color" name="model-color">
      <br> <br>

      <input type="submit" value="submit" name="submit" class="btn">
    </form>
</body>
</html>