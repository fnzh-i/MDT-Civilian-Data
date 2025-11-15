<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Vehicle</title>
  <link rel="stylesheet" href="AdminStyle.css">
</head>
<body>
  <br>
  <a href="Admin.php" class="btn">Back</a>
  <br>
  <br>
  <form action="Controller.php" method="POST" class="forms">
    <input type="hidden" name="action" value="SEARCH-PLATE-NUMBER">

    <label for="search-plate">Enter Plate Number:</label>
    <input type="text" id="search-plate" name="plate-number" placeholder="ABC 1234">
    <br> <br>

    <label for="search-mv">Enter MV File Number:</label>
    <input type="text" id="search-mv" name="mv-file-number" placeholder="1234-1234567">
    <br> <br>
    <input type="submit" value="Search" class="btn">
  </form>
</body>
</html>