<?php
require_once __DIR__ . '/../bootstrap.php';

header('Content-Type: application/json');

class VehicleAPI {
    private mysqli $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function searchPlate(string $plateNumber): string {
        // CHECK IF EMPTY YUNG INPUT FIELD
        if (trim($plateNumber) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter a plate number or MV file number.'
            ]);
        }

        $result = Vehicle::searchVehicle($this->conn, $plateNumber);

        if (is_string($result)) {
            return json_encode([
                'status' => 'error',
                'message' => $result
            ]);
        }

        $vehicle = $result['vehicle'];
        $vehicleId = $result['vehicle_id'];

        // CALCULATE ISSUE DATE FROM EXPIRY DATE, NEED TO SA UPDATE VEHICLE
        $issueDate = $vehicle->getExpiryDate() 
            ? Vehicle::inferIssueDate($vehicle->getExpiryDate()->format('Y-m-d')) 
            : null;

        return json_encode([
            'status' => 'success',
            'vehicle' => [
                'id' => $vehicleId,
                'plate' => $vehicle->getPlateNumber(),
                'mvFile' => $vehicle->getMVFileNumber(),
                'vin' => $vehicle->getVin(),
                'brand' => $vehicle->getBrandName(),
                'model' => $vehicle->getModelName(),
                'color' => $vehicle->getModelColor(),
                'regExpiry' => $vehicle->getExpiryDate()->format('M-d-Y'),
                'issueDate' => $issueDate ? $issueDate->format('Y-m-d') : null, // NEED SA UPDATE VEHICLE
                'status' => $vehicle->getRegistrationStatus(),
                'year' => $vehicle->getModelYear(),
                'license_id' => $vehicle->getLicenseID()
            ],
            'license' => [
                'license_number' => $result['license']['license_number'] ?? null,
                'license_status' => $result['license']['license_status'] ?? null,
                'license_type'   => $result['license']['license_type'] ?? null,
                'issue_date'     => $result['license']['issue_date'] ?? null,
                'expiry_date'    => $result['license']['expiry_date'] ?? null
            ],
            'person' => [
                'first_name'  => $result['person']['first_name'] ?? null,
                'middle_name' => $result['person']['middle_name'] ?? null,
                'full_name'   => $result['person']['full_name'] ?? null,
                'last_name'   => $result['person']['last_name'] ?? null,
                'address'     => $result['person']['address'] ?? null
            ]
        ]);
    }


    public function getAllVehicles(): string {
        if (!$this->conn) {
            http_response_code(500);
            return json_encode(['error' => 'Database connection failed.']);
        }

        $sql = "SELECT * FROM vehicles";
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            http_response_code(500);
            return json_encode(['error' => 'Failed to fetch vehicles from database.']);
        }

        $vehicles = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $vehicle = Vehicle::fromDatabase($row);

            $vehicles[] = [
                'vehicle_id' => $row['vehicle_id'],
                'vehicle_number' => $vehicle->getPlateNumber(),
                'mv_file_number' => $vehicle->getMVFileNumber(),
                'vin' => $vehicle->getVin(),
                'expiry_date' => $vehicle->getExpiryDate()->format('M-d-Y'),
                'registration_status' => $vehicle->getRegistrationStatus(),
                'brand_name' => $vehicle->getBrandName(),
                'model_name' => $vehicle->getModelName(),
                'model_year' => $vehicle->getModelYear(),
                'model_color' => $vehicle->getModelColor(),
                'license_id' => $vehicle->getLicenseID()
            ];
        }

        return json_encode(['vehicles' => $vehicles]);
    }

    public function createVehicle(): string {
        // CHECK IF EMPTY ANG LICENSE-NUMBER
        $licenseNumber = $_POST['license-number'] ?? '';
        if (trim($licenseNumber) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the license number.'
            ]);
        }
        // CHECK IF EMPTY ANG PLATE NUMBER
        $plateNumber = $_POST['plate-number'] ?? '';
        if (trim($plateNumber) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the plate number.'
            ]);
        }
        // CHECK IF EMPTY ANG MV FILE NUMBER (KASI DI NA SYA OPTIONAL RIGHT)
        $mvFileNumber = $_POST['mv-file-number'] ?? '';
        if (trim($mvFileNumber) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the MV file number.'
            ]);
        }
        // CHECK IF EMPTY ANG VIN
        $vin = $_POST['vin'] ?? '';
        if (trim($vin) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the VIN.'
            ]);
        }
        // CHECK IF EMPTY ANG ISSUE DATE
        $issueDate = $_POST['issue-date'] ?? '';
        if (trim($issueDate) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please input the issue date.'
            ]);
        }
        // CHECK IF WALANG PINILING REGISTRATION STATUS
        $registrationStatus = $_POST['registration-status'] ?? '';
        if ($registrationStatus === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please select the registration status.'
            ]);
        }
        // CHECK IF EMPTY ANG BRAND NAME
        $brandName = $_POST['brand-name'] ?? '';
        if (trim($brandName) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the brand name.'
            ]);
        }
        // CHECK IF EMPTY ANG MODEL NAME
        $modelName = $_POST['model-name'] ?? '';
        if (trim($modelName) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the model name.'
            ]);
        }
        // CHECK IF EMPTY ANG MODEL YEAR
        $modelYear = $_POST['model-year'] ?? '';
        if (trim($modelYear) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the model year.'
            ]);
        }
        // CHECK IF POSITIVE INTEGER SYA
        if (!ctype_digit($modelYear) || (int)$modelYear <= 0) {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter a valid year (positive integer).'
            ]);
        }
        // CHECK IF EMPTY ANG MODEL COLOR
        $modelColor = $_POST['model-color'] ?? '';
        if (trim($modelColor) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the model color.'
            ]);
        }

        // VEHICLE OBJECT
        $vehicle = new Vehicle(
            $plateNumber,
            $mvFileNumber,
            $vin,
            new DateTime($issueDate),
            RegistrationStatus::from($registrationStatus),
            $brandName,
            $modelName,
            (int) $modelYear,
            $modelColor,
            0 // PLACEHOLDER SA LICENSE_ID MUNA, SINCE DI PA NASASAVE SA DB
        );

        // SAVING TO DB
        $result = $vehicle->save($this->conn, $licenseNumber);

        return $result;
    }

    public function updateVehicle(): string {
        // CHECK IF EMPTY ANG LICENSE-NUMBER
        $licenseNumber = $_POST['license-number'] ?? '';
        if (trim($licenseNumber) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the license number.'
            ]);
        }
        // CHECK IF EMPTY ANG PLATE NUMBER
        $plateNumber = $_POST['plate-number'] ?? '';
        if (trim($plateNumber) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the plate number.'
            ]);
        }
        // CHECK IF EMPTY ANG MV FILE NUMBER (KASI DI NA SYA OPTIONAL RIGHT)
        $mvFileNumber = $_POST['mv-file-number'] ?? '';
        if (trim($mvFileNumber) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the MV file number.'
            ]);
        }
        // CHECK IF EMPTY ANG VIN
        $vin = $_POST['vin'] ?? '';
        if (trim($vin) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the VIN.'
            ]);
        }
        // CHECK IF EMPTY ANG ISSUE DATE
        $issueDate = $_POST['issue-date'] ?? '';
        if (trim($issueDate) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please input the issue date.'
            ]);
        }
        // CHECK IF WALANG PINILING REGISTRATION STATUS
        $registrationStatus = $_POST['registration-status'] ?? '';
        if ($registrationStatus === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please select the registration status.'
            ]);
        }
        // CHECK IF EMPTY ANG BRAND NAME
        $brandName = $_POST['brand-name'] ?? '';
        if (trim($brandName) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the brand name.'
            ]);
        }
        // CHECK IF EMPTY ANG MODEL NAME
        $modelName = $_POST['model-name'] ?? '';
        if (trim($modelName) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the model name.'
            ]);
        }
        // CHECK IF EMPTY ANG MODEL YEAR
        $modelYear = $_POST['model-year'] ?? '';
        if (trim($modelYear) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the model year.'
            ]);
        }
        // CHECK IF POSITIVE INTEGER SYA
        if (!ctype_digit($modelYear) || (int)$modelYear <= 0) {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter a valid year (positive integer).'
            ]);
        }
        // CHECK IF EMPTY ANG MODEL COLOR
        $modelColor = $_POST['model-color'] ?? '';
        if (trim($modelColor) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the model color.'
            ]);
        }

        // KUNIN VEHICLE ID DUN SA HIDDEN INPUT SA ADMINCREATEVEHICLE (UPDATE MODE)
        $vehicleId = (int)($_POST['vehicle-id'] ?? 0);
        if ($vehicleId <= 0) {
            return json_encode([
                'status' => 'error',
                'message' => 'Vehicle ID is missing. Cannot update.'
            ]);
        }

        // GET LICENSE ID
        $stmt = $this->conn->prepare("SELECT license_id FROM licenses WHERE license_number = ?");
        $stmt->bind_param("s", $licenseNumber);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows === 0) {
            return json_encode(['status'=>'error','message'=>"License number '{$licenseNumber}' does not exist."]);
        }
        $licenseId = (int)$res->fetch_assoc()['license_id'];
        $stmt->close();

        // VEHICLE OBJECT
        $vehicle = new Vehicle(
            $plateNumber,
            $mvFileNumber,
            $vin,
            new DateTime($issueDate),
            RegistrationStatus::from($registrationStatus),
            $brandName,
            $modelName,
            (int) $modelYear,
            $modelColor,
            $licenseId
        );

        // UPDATE DB
        $result = $vehicle->update($this->conn, $vehicleId);

        if ($result === true) {
            return json_encode([
                'status' => 'success',
                'message' => 'Vehicle updated successfully.'
            ]);
        } else {
            return json_encode([
                'status' => 'error',
                'message' => $result
            ]);
        }
    }

    // PARA SA ADMIN DELETE VEHICLE
    public function deleteVehicle(): string {
        if (empty($_POST['plate-number'])) {
            return json_encode([
                "status" => "error",
                "message" => "Plate number not provided."
            ]);
        }

        $plateNumber = $_POST['plate-number'];

        // YUNG STATIC FUNCT THE DELETE SA VEHICLE CLASS
        $result = Vehicle::delete($this->conn, $plateNumber);

        // YUNG RESPONSE
        if ($result === true) {
            return json_encode([
                "status" => "success",
                "message" => "Vehicle deleted successfully."
            ]);
        } else {
            return json_encode([
                "status" => "error",
                "message" => $result
            ]);
        }
    }


}
?>
