<?php
require_once __DIR__ . '/../bootstrap.php';

header('Content-Type: application/json');

$response = [];

if ($conn) {
    $sql = "SELECT * FROM licenses";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $licenses = [];

        while ($row = mysqli_fetch_assoc($result)) {
            
            $license = DriversLicense::fromDatabase($row);

            $licenses[] = [
                'license_id' => $row['license_id'],
                'license_number' => $license->getLicenseNumber(),
                'license_status' => $license->getLicenseStatus()->value,
                'license_type' => $license->getLicenseType()->value,
                'issue_date' => $license->getIssueDate()->format('M-d-Y'),
                'expiry_date' => $license->getExpiryDate()->format('M-d-Y'),
                'dl_codes' => $license->getDLCodesToString(),
                'first_name' => $license->getFirstName(),
                'middle_name' => $license->getMiddleName(),
                'last_name' => $license->getLastName(),
                'date_of_birth' => $license->getDateOfBirth()->format('M-d-Y'),
                'gender' => $license->getGender()->value,
                'address' => $license->getAddress()
            ];
        }

        echo json_encode(['licenses' => $licenses], JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch licenses from database.']);
    }
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed.']);
}
