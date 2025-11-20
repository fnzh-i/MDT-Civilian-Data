<?php
  session_start();
  require_once __DIR__ . '/../bootstrap.php';


  if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    switch ($action) {
      case 'USER-LOGIN':
          $email = $_POST['email'] ?? null;
          $password = $_POST['password'] ?? null;
          

          $loginResult = User::searchEmail($conn, $email, $password);

          if ($loginResult === true) {
              echo "SUCCESS";
          } else {
              echo $loginResult; // the error message from User::searchEmail()
          }
      exit;




      case 'SEARCH-PLATE-NUMBER':
          header('Content-Type: application/json');

          $plateNumber = $_POST['plate-number'];

          $vehicleAPI = new VehicleAPI($conn);
          $result = $vehicleAPI->searchPlate($plateNumber);

          if (is_string($result)) {
              echo json_encode([
                  'status' => 'error',
                  'message' => $result
              ]);
              exit();
          }

          $vehicle = $result['vehicle'];
          $vehicleId = $result['vehicle_id']; 

          echo json_encode([
              'status' => 'success',
              'vehicle' => [
                  'id' => $vehicleId,
                  'plate' => $vehicle->getPlateNumber(),
                  'brand' => $vehicle->getBrandName(),
                  'model' => $vehicle->getModelName(),
                  'color' => $vehicle->getModelColor()
              ]
          ]);
          exit();


            // case 'SEARCH-PLATE-NUMBER':
      //   $plateNumber = $_POST['plate-number'];
      //   $result = Vehicle::searchPlateNumber($conn, $plateNumber);

      //   if (is_string($result)) {
      //     $_SESSION['error-message'] = $result;

      //     header("Location: Error.php");
      //     exit();
      //   } else {
      //     $vehicle = $result['vehicle'];
      //     $vehicleId = $result['vehicle_id']; 
      //     $plateNumber = $vehicle->getPlateNumber();

      //     $_SESSION['vehicle'] = $vehicle;
      //     $_SESSION['vehicle-id'] = $vehicleId;
      //     $_SESSION['plate-number'] = $plateNumber;

      //     header("Location: AdminSearchVehicleResult.php");
      //     exit();
      //   }

          
      case 'SEARCH-LICENSE-NUMBER':
        $licenseNumber = $_POST['license-number'];
        $result = DriversLicense::searchLicenseNumber($conn, $licenseNumber);

        if (is_string($result)) {
          $_SESSION['error-message'] = $result;

          header("Location: Error.php");
          exit();
        } else {
          $license = $result['license'];
          $licenseId = $result['license_id'];

          $_SESSION['license'] = $license;
          $_SESSION['license-id'] = $licenseId;

          header("Location: AdminSearchLicenseResult.php");
          exit();
        }
        
        break;
      
      case 'ADD-VIOLATION':
        $violation = Violation::from($_POST['violation']);
        $dateOfIncident = $_POST['date-of-incident'];
        $placeOfIncident = $_POST['place-of-incident'];
        $note = $_POST['note'];

        $ticket = new TicketViolation($violation, new DateTime($dateOfIncident), $placeOfIncident, $note);

        $licenseId = $_SESSION['license-id'];

        $result = $ticket->save($conn, $licenseId);

        if (is_string($result)) {
          $_SESSION['error-message'] = $result;

          header("Location: Error.php");
          exit();
        } else {
          echo "Ticket saved successfully.";
        }
        break;
    }
  }
?>