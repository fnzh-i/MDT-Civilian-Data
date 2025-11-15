<?php
  require_once "TicketViolation.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Ticket</title>
  <link rel="stylesheet" href="AdminStyle.css">
</head>
<body>
    <br>
    <a href="AdminSearchLicenseResult.php" class="btn">Back</a>
    <br>
    <br>
    <form action="Controller.php" method="POST" class="forms">
      <input type="hidden" name="action" value="ADD-VIOLATION">

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