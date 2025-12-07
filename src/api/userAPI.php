<?php
require_once __DIR__ . '/../bootstrap.php';

header('Content-Type: application/json');

class UserAPI{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function registerUser(): string
    {
        // Get POST data
        $firstName = trim($_POST['first_name'] ?? '');
        $middleName = trim($_POST['middle_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');

        // Validate required fields
        if (!$firstName || !$lastName) {
            return json_encode([
                'status' => 'error',
                'message' => 'Please fill in at least first name and last name.'
            ]);
        }

        // Save personal info to users table
        $stmt = $this->conn->prepare("
            INSERT INTO users (first_name, middle_name, last_name)
            VALUES (?, ?, ?)
        ");
        $stmt->bind_param("sss", $firstName, $middleName, $lastName);

        if ($stmt->execute()) {
            $stmt->close();
            return json_encode([
                'status' => 'success',
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'last_name' => $lastName
            ]);
        } else {
            $stmt->close();
            return json_encode([
                'status' => 'error',
                'message' => 'Failed to save user.'
            ]);
        }
    }
}
?>