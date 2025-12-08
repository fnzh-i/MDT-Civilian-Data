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
        $firstName = trim($_POST['first_name'] ?? '');
        $middleName = trim($_POST['middle_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $licenseNumber = trim($_POST['license_number'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // validate required fields
        if (!$firstName || !$lastName || !$email || !$password) {
            return json_encode([
                'status' => 'error',
                'message' => 'First name, last name, email, and password are required.'
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
        $userObj = User::createForRegistration(
            $firstName,
            $lastName,
            $email,
            $password,
            $middleName,
            false,); // auto-hashes password
        $success = $userObj->save($this->conn, $licenseId);

        if ($success) {
            return json_encode([
                'status' => 'success',
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'last_name' => $lastName,
                'email' => $email,
                'license_id' => $licenseId
            ]);
        }

        return json_encode([
            'status' => 'error',
            'message' => 'Database error: failed to save user.'
        ]);
    }

    public function registerAdmin(): string
    {
        $firstName = trim($_POST['first_name'] ?? '');
        $middleName = trim($_POST['middle_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $roleId = trim($_POST['role_id'] ?? '');

        if (!$firstName || !$lastName || !$email || !$password || !$roleId) {
            return json_encode([
                'status' => 'error',
                'message' => 'All fields including role_id are required for admin creation.'
            ]);
        }

        require_once __DIR__ . '/../_modules/User.php';
        require_once __DIR__ . '/../_modules/Roles.php';

        $roles = Roles::loadById($roleId);

        $userObj = User::createByAdmin(
            $roles,
            $firstName,
            $lastName,
            $email,
            $password,
            $middleName,
        );

        $success = $userObj->save($this->conn, null);

        if ($success) {
            return json_encode([
                'status' => 'success',
                'admin_created' => true,
                'email' => $email
            ]);
        }

        return json_encode([
            'status' => 'error',
            'message' => 'Failed to save admin user.'
        ]);
    }

}
?>