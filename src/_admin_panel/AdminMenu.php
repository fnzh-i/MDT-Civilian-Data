

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Menu</title>
  <link rel="stylesheet" href="AdminStyle.css">
</head>
<body>
  <div class="layout">
    <a href="AdminSearchVehicle.php" class="button">Search Vehicle</a>
    <a href="AdminCreateLicense.php" class="button">Create License</a>
    <a href="AdminSearchLicense.php" class="button">Search License</a>
  </div>
</body>
<?php
  require dirname(__DIR__) . "/src/bootstrap.php";

if (isset($_GET['updateID'])) {
    $id = $_GET['updateID'];
    $firstname = $_GET['firstname'];
    $lastname = $_GET['lastname'];
    $address = $_GET['email'];
} else {
    $id = "";
    $firstname = "";
    $lastname = "";
    $address = "";
}
?>

<form action="AdminCreateUser.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $id;?>">
    <input type="text" name="email" value="<?php echo $email;?>" placeholder="Email"><br>
    <input type="text" name="password" value="<?php echo $password;?>" placeholder="Password"><br>
    
    <?php
        if ($id > 0) {
            echo "<input type='submit' name='update' value='UPDATE'>";
        } else {
            echo "<input type='submit' name='insert' value='INSERT'>";
        }
    ?>
    
    
</form>
</html>