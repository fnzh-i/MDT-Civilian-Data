<?php
require_once __DIR__ . '/../bootstrap.php';

header('Content-Type: application/json');

class VehicleAPI {
    private mysqli $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function searchPlate(string $plateNumber): array|string {
        return Vehicle::searchPlateNumber($this->conn, $plateNumber);
    }

    public function getAllVehicles(): array {
        if (!$this->conn) {
            http_response_code(500);
            return ['error' => 'Database connection failed.'];
        }

        $sql = "SELECT * FROM vehicles";
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            http_response_code(500);
            return ['error' => 'Failed to fetch vehicles from database.'];
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

        return ['vehicles' => $vehicles];
    }

}
?>
