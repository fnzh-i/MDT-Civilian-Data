<?php
require_once __DIR__ . '/../bootstrap.php';

header('Content-Type: application/json');

$response = [];

if ($conn) {
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $users = [];

        while ($row = mysqli_fetch_assoc($result)) {
            
            $user = User::fromDatabase($row);

            $users[] = [
                'user_id' => $row['user_id'],
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                // 'first_name' => $license->getFirstName(),
                // 'middle_name' => $license->getMiddleName(),
                // 'last_name' => $license->getLastName(),
                // 'date_of_birth' => $license->getDateOfBirth()->format('M-d-Y'),
                // 'address' => $license->getAddress()
            ];
        }

        echo json_encode(['users' => $users], JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch users from database.']);
    }
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed.']);
}
