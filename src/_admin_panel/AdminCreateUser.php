<?php
require dirname(__DIR__) . "../bootstrap.php";

if (isset($_GET['updateID'])) {
    $id = $_GET['updateID'];
    $email = $_GET['email'];
    $password = $_GET['password'];

} else {
    $id = "";
    $email = "";
    $password = "";
}
?>

<form action="AdminUser.php" method="POST">
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