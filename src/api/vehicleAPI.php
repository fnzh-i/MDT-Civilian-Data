<?php
require_once __DIR__ . '/../bootstrap.php';

header('Content-Type: application/json');

class VehicleAPI {
    private mysqli $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function searchPlate(string $plateNumber): string {
        $result = Vehicle::searchPlateNumber($this->conn, $plateNumber);

        // If Vehicle::searchPlateNumber returns an error string
        if (is_string($result)) {
            return json_encode([
                'status' => 'error',
                'message' => $result
            ]);
        }

        // Otherwise successful
        $vehicle = $result['vehicle'];
        $vehicleId = $result['vehicle_id'];

        return json_encode([
            'status' => 'success',
            'vehicle' => [
                'id' => $vehicleId,
                'plate' => $vehicle->getPlateNumber(),
                'mvFile' => $vehicle->getMVFileNumber(),
                'brand' => $vehicle->getBrandName(),
                'model' => $vehicle->getModelName(),
                'color' => $vehicle->getModelColor(),
                'regExpiry' => $vehicle->getExpiryDate()->format('M-d-Y'),
                'status' => $vehicle->getRegistrationStatus(),
                'year' => $vehicle->getModelYear(),
                'license_id' => $vehicle->getLicenseID()
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
}

?>
