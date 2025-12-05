<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN SEARCH LICENSE</title>
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
  <strong>ADMIN SEARCH LICENSE</strong> <br> <br>
  <form action="AdminSearchLicenseResult.php" method="GET">
    <input type="hidden" name="action" value="SEARCH-LICENSE-NUMBER">

    <label for="search-license">Enter License Number:</label>
    <input type="text" id="search-license" name="license-number" placeholder="AXX-XX-XXXXXX">
    <input type="submit" value="Search" class="btn">
  </form>
</body>
</html>