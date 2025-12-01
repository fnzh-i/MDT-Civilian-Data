<?php
  require_once __DIR__ . '/../../bootstrap.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create License</title>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 20px;
    }
    button, input {
      font: inherit;
    }
  </style>
</head>
<body>
    <br>
    <a href="Admin.php" class="btn">Back</a>
    <br>
    <br>
    <strong>CREATE LICENSE</strong>
    <br>
    <br>

    <form action="../../_modules/Controller.php" method="POST" class="forms">
      <input type="hidden" name="action" value="CREATE-LICENSE">

      <label for="license-number">License Number:</label>
      <input type="text" id="license-number" name="license-number">
      <br> <br>

      License Status:
      <input type="radio" id="registered" name="license-status" value="REGISTERED">
      <label for="registered">REGISTERED</label>

      <input type="radio" id="unregistered" name="license-status" value="UNREGISTERED">
      <label for="unregistered">UNREGISTERED</label>

      <input type="radio" id="expired" name="license-status" value="EXPIRED">
      <label for="expired">EXPIRED</label>

      <input type="radio" id="revoked" name="license-status" value="REVOKED">
      <label for="expired">REVOKED</label>
      <br> <br>

      License Type:
      <input type="radio" id="pro" name="license-type" value="PROFESSIONAL">
      <label for="pro">PROFESSIONAL</label>

      <input type="radio" id="nonpro" name="license-type" value="NON-PROFESSIONAL">
      <label for="nonpro">NON-PROFESSIONAL</label>

      <input type="radio" id="student" name="license-type" value="STUDENT PERMIT">
      <label for="student">STUDENT PERMIT</label>
      <br> <br>

      <label for="issue-date">Issue Date:</label>
      <input type="date" id="issue-date" name="issue-date">
      <br> <br>

      Expiry Option:
      <input type="radio" id="five" name="expiry-option" value="5">
      <label for="five">5 years</label>

      <input type="radio" id="ten" name="expiry-option" value="10">
      <label for="ten">10 years</label>
      <br> <br>

      DL Codes:
      <input type="checkbox" id="a" name="dl-codes[]" value="A">
      <label for="a">A</label>

      <input type="checkbox" id="a1" name="dl-codes[]" value="A1">
      <label for="a1">A1</label>

      <input type="checkbox" id="b" name="dl-codes[]" value="B">
      <label for="b">B</label>

      <input type="checkbox" id="b1" name="dl-codes[]" value="B1">
      <label for="b1">B1</label>

      <input type="checkbox" id="c" name="dl-codes[]" value="C">
      <label for="c">C</label>

      <input type="checkbox" id="d" name="dl-codes[]" value="D">
      <label for="d">D</label>
      <br> <br>

      <strong>PERSONAL INFORMATION</strong> <br> <br>

      <label for="first-name">First Name:</label>
      <input type="text" id="first-name" name="first-name">
      <br> <br>

      <label for="middle-name">Middle Name:</label>
      <input type="text" id="middle-name" name="middle-name">
      <br> <br>

      <label for="last-name">Last Name:</label>
      <input type="text" id="last-name" name="last-name">
      <br> <br>

      <label for="date-of-birth">Date Of Birth:</label>
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

      <label for="nationality">Nationality:</label>
      <input type="text" id="nationality" name="nationality">
      <br> <br>

      <label for="height">Height:</label>
      <input type="text" id="Height" name="height">
      <br> <br>

      <label for="weight">Weight:</label>
      <input type="text" id="weight" name="weight">
      <br> <br>

      <label for="eye-color">Eye Color:</label>
      <input type="text" id="eye-color" name="eye-color">
      <br> <br>

      <label for="blood-type">Blood Type:</label>
      <input type="text" id="blood-type" name="blood-type">
      <br> <br>

      <input type="submit" value="submit" name="submit" class="btn">
    </form>
</body>
</html>