<?php
  require_once __DIR__ . '/../../bootstrap.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN CREATE TICKET</title>
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
    <strong>ADMIN CREATE TICKET</strong>
    <br> <br>

    <form action="../../_modules/Controller.php" method="POST" class="forms">
      <input type="hidden" name="action" value="CREATE-TICKET">

      <label for="license-id">License ID:</label>
      <input type="number" id="license-id" name="license_id" placeholder="FOR FOREIGN KEY">
      <br> <br>

      <label for="violation">Violation:</label>
      <input type="text" id="violation" name="violation" list="violations-list">
      
      <datalist id="violations-list">
        <?php
          foreach (Violation::cases() as $violation) {
            echo "<option value=\"{$violation->value}\">";;
          }
        ?>
      </datalist>

      <br> <br>

      <label for="date-of-incident">Date Of Incident:</label>
      <input type="date" id="date-of-incident" name="date-of-incident"> 
      <br> <br>

      <label for="place-of-incident">Place Of Incident:</label>
      <input type="text" id="place-of-incident" name="place-of-incident">
      <br> <br>

      <label for="note">Note:</label>
      <input type="text" id="note" name="note">
      <br> <br>

      <input type="submit" value="Submit" class="btn">
    </form>
</body>
</html>