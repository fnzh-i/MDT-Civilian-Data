<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link rel="stylesheet" href="AdminStyle.css">
</head>
<body>
  <form action="Controller.php" method="POST" class="forms">
    <input type="hidden" name="action" value="USER-LOGIN">

    <label for="email">Email:</label>
    <input type="text" id="email" name="email">
    <br> <br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <br> <br>

    <input type="submit" value="Login" class="btn">
  </form>
</body>
</html>