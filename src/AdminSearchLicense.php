<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search License</title>
  <link rel="stylesheet" href="AdminStyle.css">
</head>
<body>
  <br>
  <a href="Admin.php" class="btn">Back</a>
  <br>
  <br>
  <form action="Controller.php" method="POST" class="forms">
    <input type="hidden" name="action" value="SEARCH-LICENSE-NUMBER">
    <label for="search-license">Enter License Number:</label>
    <input type="text" id="search-license" name="license-number" placeholder="AXX-XX-XXXXXX">
    <input type="submit" value="Search" class="btn">
  </form>
</body>
</html>