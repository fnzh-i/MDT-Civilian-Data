<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PageTwo</title>
</head>
<body>
  
</body>
</html>

<?php
  require_once "DBConnect.php";
  require_once "Person.php";

  if (isset($_POST['submit'])) {
    $person = new Person(
      $_POST['first-name'],
      !empty($_POST['middle-name']) ? $_POST['middle-name'] : null,
      $_POST['last-name'],
      new DateTime($_POST['date-of-birth']),
      Gender::from($_POST['sex']),
      $_POST['address']
    );

    if ($person->save($conn)) {
      echo "Person saved to persons table.";
    } else {
      echo "Failed saving to persons table: {$conn->error}";
    }
  }
?>