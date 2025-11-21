<?php
require_once __DIR__ . '/../bootstrap.php';

header('Content-Type: application/json');

class LicenseAPI{

    private mysqli $conn;
    
    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function searchLicense(string $licenseNumber): array|string {
        $result = DriversLicense::searchLicenseNumber($this->conn, $licenseNumber);
       
        // If Vehicle::searchPlateNumber returns an error string
        if (is_string($result)) {
              return json_encode([
                  'status' => 'error',
                  'message' => $result
              ]);
          }

          $license = $result['license'];
          $licenseId = $result['license_id']; 

        return json_encode([
            'status' => 'success',
            'license' => [
                'id' => $licenseId,
                'licenseNumber' => $license->getLicenseNumber(),
                'status' => $license->getLicenseStatus()->value,
                'type' => $license->getLicenseType()->value,
                'issueDate' => $license->getIssueDate()->format('M-d-Y'),
                'expiryDate' => $license->getExpiryDate()->format('M-d-Y'),
                'dl_codes' => $license->getDLCodesToString(),
                'first_name' => $license->getFirstName(),
                'middle_name' => $license->getMiddleName(),
                'last_name' => $license->getLastName(),
                'date_of_birth' => $license->getDateOfBirth()->format('M-d-Y'),
                'gender' => $license->getGender()->value,
                'address' => $license->getAddress(),
            ]
        ]);
    }

    public function getAllLicenses(): string {
        if (!$this->conn) {
            http_response_code(500);
            return json_encode(['error' => 'Database connection failed.']);
        }
    
        $sql = "SELECT * FROM licenses";
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            http_response_code(500);
            return json_encode(['error' => 'Failed to fetch vehicles from database.']);
        }

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
        return json_encode(['licenses' => $licenses]);
    }
}

