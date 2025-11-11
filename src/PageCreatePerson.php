<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <style>
      a {
        text-decoration: none;
        background-color: grey;
        color: white;
        padding: 10px 14px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 18px;
      }
      a:hover {
        opacity: 0.7;
      }
    </style>
  </head>
  <body>
    <a href="index.php">Back</a>
    <br> <br> <br>

    <form action="PagePersonResult.php" method="POST">
      <label for="first-name">First name:</label>
      <input type="text" id="first-name" name="first-name">
      <br> <br>

      <label for="middle-name">Middle name:</label>
      <input type="text" id="middle-name" name="middle-name">
      <br> <br>

      <label for="last-name">Last name:</label>
      <input type="text" id="last-name" name="last-name">
      <br> <br>

      <label for="date-of-birth">Date of birth:</label>
      <input type="date" id="date-of-birth" name="date-of-birth">
      <br> <br>

      Sex:
      <input type="radio" id="male" name="sex" value="Male">
      <label for="male">Male</label>


      <input type="radio" id="female" name="sex" value="Female">
      <label for="female">Female</label>
      <br> <br>

      <label for="address">Address:</label>
      <input type="text" id="address" name="address">
      <br> <br>

      <input type="submit" value="submit" name="submit">
    </form>
  </body>
</html>