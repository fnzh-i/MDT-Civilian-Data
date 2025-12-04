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

        // IF BLANK YUNG INPUT
        if (empty(trim($licenseNumber))) {
            $result = "Please enter a license number.";
            return json_encode([
                'status' => 'error',
                'message' => $result
            ]);
        }

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

                'nationality' => $license->getNationality(),
                'height' => $license->getHeight(),
                'weight' => $license->getWeight(),
                'eye_color' => $license->getEyeColor(),
                'blood_type' => $license->getBloodType()
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
                'address' => $license->getAddress(),

                'nationality' => $license->getNationality(),
                'height' => $license->getHeight(),
                'weight' => $license->getWeight(),
                'eye_color' => $license->getEyeColor(),
                'blood_type' => $license->getBloodType()
            ];
        }
        return json_encode(['licenses' => $licenses]);
    }

    // para sa Admin Panel: Create a License
    public function createLicense(): string {
        // yung mga DLCodes
        $dlCodes = [];
        if (!empty($_POST['dl-codes']) && is_array($_POST['dl-codes'])) {
            foreach ($_POST['dl-codes'] as $codeString) {
                $dlCodes[] = DLCodes::from($codeString); // from array of strings into array of DLCodes enum cases
            }
        }

        // magiging null if left blank
        $middleName = $_POST['middle-name'] ?? null;
        if ($middleName === '') $middleName = null;
        
        // magiging null if left blank
        $bloodType = $_POST['blood-type'] ?? null;
        if ($bloodType === '') $bloodType = null;

        // Checker if walang na pick na Expiry Option
        if (!isset($_POST['expiry-option'])) {
            return "Error: Expiry option not selected.";
        }

        $expiryOptionValue = (int) $_POST['expiry-option']; // string to int kasi int yung backed values ng ExpiryOption enum
        $expiryOptionEnum = ExpiryOption::from($expiryOptionValue);

        // gawa ng DriversLicense object
        $license = new DriversLicense(
            $_POST['license-number'],
            LicenseStatus::from($_POST['license-status']),
            LicenseType::from($_POST['license-type']),
            new DateTime($_POST['issue-date']),
            $expiryOptionEnum,
            $dlCodes,

            $_POST['first-name'],
            $middleName,
            $_POST['last-name'],
            new DateTime($_POST['date-of-birth']),
            Gender::from($_POST['sex']),
            $_POST['address'],
            $_POST['nationality'],
            $_POST['height'],
            $_POST['weight'],
            $_POST['eye-color'],
            $bloodType
            );

        // save sa database
        $result = $license->save($this->conn);
        return $result;
    }

    // PARA SA ADMIN UPDATE LICENSE
    public function updateLicense(): string|bool {
        // DLCodes (FROM ARRAY OF STRINGS TO ARRAY OF ENUM OBJECTS)
        $dlCodes = [];
        if (!empty($_POST['dl-codes']) && is_array($_POST['dl-codes'])) {
            foreach ($_POST['dl-codes'] as $codeString) {
                $dlCodes[] = DLCodes::from($codeString);
            }
        }

        // NULL HANDLING
        $middleName = $_POST['middle-name'] ?? null;
        if ($middleName === '') $middleName = null;

        $bloodType = $_POST['blood-type'] ?? null;
        if ($bloodType === '') $bloodType = null;

        // EXPIRY OPTION CHECK
        if (!isset($_POST['expiry-option'])) {
            return "Error: Expiry option not selected.";
        }

        $expiryOptionValue = (int) $_POST['expiry-option'];
        $expiryOptionEnum = ExpiryOption::from($expiryOptionValue);

        // DRIVERSLICENSE OBJECT
        $license = new DriversLicense(
            $_POST['license-number'],
            LicenseStatus::from($_POST['license-status']),
            LicenseType::from($_POST['license-type']),
            new DateTime($_POST['issue-date']),
            $expiryOptionEnum,
            $dlCodes,

            $_POST['first-name'],
            $middleName,
            $_POST['last-name'],
            new DateTime($_POST['date-of-birth']),
            Gender::from($_POST['sex']),
            $_POST['address'],
            $_POST['nationality'],
            $_POST['height'],
            $_POST['weight'],
            $_POST['eye-color'],
            $bloodType
        );

        // UPDATE DB
        $result = $license->update($this->conn);
        return $result;
    }

    // PARA SA ADMIN DELETE LICENSE
    public function deleteLicense(): string {
        if (empty($_POST['license-number'])) {
            return json_encode([
                "status" => "error",
                "message" => "License number not provided."
            ]);
        }

        $licenseNumber = $_POST['license-number'];

        // YUNG STATIC FUNCTION SA DRIVERSLICENSE CLASS
        $result = DriversLicense::delete($this->conn, $licenseNumber);

        // YUNG RESPONSE
        if ($result === true) {
            return json_encode([
                "status" => "success",
                "message" => "License deleted successfully."
            ]);
        } else {
            return json_encode([
                "status" => "error",
                "message" => $result
            ]);
        }
    }



}