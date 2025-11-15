<?php
require_once __DIR__ . '/../bootstrap.php';

header('Content-Type: application/json');

$response = [];

if ($conn) {
    $sql = "SELECT * FROM vehicles";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $vehicles = [];

        while ($row = mysqli_fetch_assoc($result)) {
            
            $vehicle = Vehicle::fromDatabase($row);

            $vehicles[] = [
                'vehicle_id' => $row['vehicle_id'],
                'vehicle_number' => $vehicle->getPlateNumber(),
                'mv_ file_number' => $vehicle->getMVFileNumber(),
                'expiry_date' => $vehicle->getExpiryDate()->format('M-d-Y'),
                'registration_status' => $vehicle->getRegistrationStatus(),
                'brand_name' => $vehicle->getBrandName(),
                'model_name' => $vehicle->getModelName(),
                'model_year' => $vehicle->getModelYear(),
                'model_color' => $vehicle->getModelColor(),
                'license_id' => $vehicle->getLicenseID()
            ];
        }
        echo json_encode(['vehicles' => $vehicles], JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch vehicles from database.']);
    }
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed.']);
}
