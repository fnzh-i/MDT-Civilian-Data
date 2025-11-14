<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create License Result</title>
  <link rel="stylesheet" href="AdminStyle.css">
</head>
<body>
  <br>
  <a href="Admin.php" class="btn">Back</a>
  <br>
  <br>
</body>
</html>

<?php
  require_once "DriversLicense.php";

  if (isset($_POST['submit'])) {
    $dlCodes = [];

    foreach ($_POST['dl-codes'] as $value) {
      $enumCase = DLCodes::from($value);
      $dlCodes[] = $enumCase;
    }

    $license = new DriverLicense(
      $_POST['license-name'],
      LicenseStatus::from($_POST['license-status']),
      LicenseType::from($_POST['license-type']),
      new DateTime($_POST['issue-date']),
      ExpiryOption::from((int)$_POST['expiry-option']),
      $dlCodes,
      $_POST['first-name'],
      $_POST['middle-name'],
      $_POST['last-name'],
      new DateTime($_POST['date-of-birth']),
      Gender::from($_POST['sex']),
      $_POST['address']
    );

    echo $license->displayInfo();
    echo "<br>";

    if ($license->save($conn)) {
      echo "License saved to licenses table.";
    } else {
      echo "Failed saving to license table: {$conn->error}"; 
    }
  }
?>