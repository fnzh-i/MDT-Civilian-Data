<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN SEARCH VEHICLE</title>
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
  <strong>ADMIN SEARCH VEHICLE</strong> <br> <br>
  <form action="AdminSearchVehicleResult.php" method="GET" class="forms">
    <input type="hidden" name="action" value="SEARCH-PLATE-NUMBER">

    <label for="search-vehicle">Enter Plate or MV File Number:</label>
    <input type="text" id="search-vehicle" name="plate-number">

    <input type="submit" value="Search" class="btn">
  </form>
</body>
</html>