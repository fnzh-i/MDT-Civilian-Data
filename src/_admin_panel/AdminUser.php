<?php
require dirname(__DIR__) . "../bootstrap.php";
// INSERT COMMAND
if (isset($_POST['insert'])) {

    // PREPARED STATEMENT
    $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $check->bind_param("s", $_POST['email']);
    $check->execute();
    $checkResult = $check->get_result();

    if ($checkResult->num_rows > 0) {
        echo "DUPLICATE ENTRY";
        return;
    }

    // CREATE USER OBJECT FIRST BEFORE SAVING TO DATABASE
    $user = new User($_POST['email'], $_POST['password']);
    $result = $user->save($conn);

    if ($result) {
        echo "Insert Successful";
    } else {
        echo "Insert Unsuccessful";
    }
}

// UPDATE COMMAND
if (isset($_POST['update'])) {

    $stmt = $conn->prepare("UPDATE users SET email = ?, password = ?, email = ? WHERE user_id = ?");
    $stmt->bind_param("ssi",$_POST['id'], $_POST['email'], $_POST['password']);

    if ($stmt->execute()) {
        echo "Update Successful";
    } else {
        echo "Update Unsuccessful";
    }
}

// DELETE COMMAND
if (isset($_GET['deleteID'])) {

    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $_GET['deleteID']);

    if ($stmt->execute()) {
        echo "Delete Successful";
    } else {
        echo "Delete Unsuccessful";
    }
}

// SELECT COMMAND
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

echo "<table border=1>";
echo "<tr>
        <th>USER ID</th>
        <th>EMAIL</th>
        <th>PASSWORD</th>
        <th>UPDATE action</th>
        <th>DELETE action</th>
      </tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        echo "<tr>";
        echo "<td>".$row['user_id']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['password']."</td>";

        echo "<td>
                <a href='index.php?updateID=".$row['user_id'].
                "&email=".$row['email'].
                "&password=".$row['password'].
                "&email=".$row['email']."'>UPDATE</a>
              </td>";   

        echo "<td>
                <a href='AdminMenu.php?deleteID=".$row['user_id']."'>DELETE</a>
              </td>";

        echo "</tr>";
    }
} else {
    echo "No Data";
}

echo "</table>";
?>

<a href="AdminCreateUser.php">BACK</a>

<a href="report.php" target="_blank">REPORT</a>
