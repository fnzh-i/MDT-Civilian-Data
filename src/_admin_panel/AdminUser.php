<?php
require dirname(__DIR__) . "../bootstrap.php";

// INSERT COMMAND
if (isset($_POST['insert'])) {

    // Check for duplicate email
    $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $check->bind_param("s", $_POST['email']);
    $check->execute();
    $checkResult = $check->get_result();

    if ($checkResult->num_rows > 0) {
        echo "DUPLICATE ENTRY";
        return;
    }

    // CREATE USER OBJECT FIRST BEFORE SAVING TO DATABASE
    $role = Roles::from($_POST['role']);
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'] ?? null;
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User(
        $role,
        $firstName,
        $middleName,
        $lastName,
        $email,
        $password,
        false // auto-hash password
    );

    $result = $user->save($conn);

    if ($result) {
        echo "Insert Successful";
    } else {
        echo "Insert Unsuccessful: " . $conn->error;
    }
}

// UPDATE COMMAND
if (isset($_POST['update'])) {

    $userId = $_POST['id'];
    $role = Roles::from($_POST['role']);
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'] ?? null;
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch existing user from DB
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if (!$row) {
        echo "User not found";
        return;
    }

    // Create User object from DB to preserve hashed password if unchanged
    $user = User::fromDatabase($row);

    // Update fields
    $user = new User(
        $role,
        $firstName,
        $middleName,
        $lastName,
        $email,
        $password,
        false // hash new password
    );

    // Update manually using prepared statement
    $stmt = $conn->prepare("
        UPDATE users 
        SET role = ?, first_name = ?, middle_name = ?, last_name = ?, email = ?, password = ? 
        WHERE user_id = ?
    ");
    $hashedPassword = $user->getPassword();
    $role = $role->value;
    $stmt->bind_param(
        "ssssssi",
        $role,
        $firstName,
        $middleName,
        $lastName,
        $email,
        $hashedPassword,
        $userId
    );

    if ($stmt->execute()) {
        echo "Update Successful";
    } else {
        echo "Update Unsuccessful: " . $conn->error;
    }
    $stmt->close();
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
    $stmt->close();
}

// SELECT COMMAND
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

echo "<table border=1>";
echo "<tr>
        <th>USER ID</th>
        <th>ROLE</th>
        <th>FIRST NAME</th>
        <th>MIDDLE NAME</th>
        <th>LAST NAME</th>
        <th>EMAIL</th>
        <th>PASSWORD</th>
        <th>UPDATE action</th>
        <th>DELETE action</th>
      </tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['user_id']."</td>";
        echo "<td>".$row['role']."</td>";
        echo "<td>".$row['first_name']."</td>";
        echo "<td>".$row['middle_name']."</td>";
        echo "<td>".$row['last_name']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['password']."</td>";

        echo "<td>
            <a href='AdminCreateUser.php?updateID=".urlencode($row['user_id']).
            "&role=".urlencode($row['role']).
            "&first_name=".urlencode($row['first_name']).
            "&middle_name=".urlencode($row['middle_name']).
            "&last_name=".urlencode($row['last_name']).
            "&email=".urlencode($row['email']).
            "&default_password=".urlencode($row['default_password'])."'>UPDATE</a>
        </td>";

        echo "<td>
                <a href='AdminUser.php?deleteID=".$row['user_id']."'>DELETE</a>
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
