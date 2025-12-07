<?php
require_once __DIR__ . '/../bootstrap.php';

header('Content-Type: application/json');

class UserAPI
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function registerUser(): string
    {
        // collect POST data
        $role = Roles::from($_POST['role']);
        $firstName = trim($_POST['first_name'] ?? '');
        $middleName = trim($_POST['middle_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $licenseNumber = trim($_POST['license_number'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // validate required fields
        if (!$role || !$firstName || !$lastName || !$email || !$password) {
            return json_encode([
                'status' => 'error',
                'message' => 'Role, first name, last name, email, and password are required.'
            ]);
        }

        // look up license_id from license_number (if provided)
        $licenseId = null;

        if ($licenseNumber !== '') {
            $stmt = $this->conn->prepare("SELECT license_id FROM licenses WHERE license_number = ?");
            $stmt->bind_param("s", $licenseNumber);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $stmt->close();
                return json_encode([
                    'status' => 'error',
                    'message' => "License number '{$licenseNumber}' does not exist."
                ]);
            }

            $licenseId = (int) $result->fetch_assoc()['license_id'];
            $stmt->close();
        }

        // create User object to hash password
        require_once __DIR__ . '/../_modules/User.php';
        $userObj = new User(
            $role,

            $firstName,
            $middleName,
            $lastName,
            
            $email,
            $password,
            
            false,); // auto-hashes password
        $hashedPassword = $userObj->getPassword();
        
        $result = $userObj->save($this->conn);
        if ($result) {
            return "Successful.";
        } else {
            return "Error: {$this->conn->error}";
        }

        // insert full user data
    //     $stmt = $this->conn->prepare("
    //     INSERT INTO users (first_name, middle_name, last_name, email, password, license_id)
    //     VALUES (?, ?, ?, ?, ?, ?)
    // ");

    //     $stmt->bind_param(
    //         "sssssi",
    //         $firstName,
    //         $middleName,
    //         $lastName,
    //         $email,
    //         $hashedPassword,
    //         $licenseId
    //     );

    //     if ($stmt->execute()) {
    //         $stmt->close();
    //         return json_encode([
    //             'status' => 'success',
    //             'first_name' => $firstName,
    //             'middle_name' => $middleName,
    //             'last_name' => $lastName,
    //             'email' => $email,
    //             'license_id' => $licenseId
    //         ]);
    //     }

    //     $stmt->close();
    //     return json_encode([
    //         'status' => 'error',
    //         'message' => 'Database error: failed to save user.'
    //     ]);
    }

}
?>