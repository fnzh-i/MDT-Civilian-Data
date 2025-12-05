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

        echo $vehicleAPI->searchPlate($plateNumber);
        exit();
        
        
      case 'SEARCH-LICENSE-NUMBER':
        header('Content-Type: application/json');

        $licenseNumber = $_POST['license-number'];
        $licenseAPI = new LicenseAPI($conn);
        echo $licenseAPI->searchLicense($licenseNumber);
        exit();


      case 'FETCH-TICKETS':
        header('Content-Type: application/json');

        $licenseID = $_POST['license_id'];
        $status = $_POST['status'] ?? null;

        $ticketAPI = new TicketAPI($conn);
        echo $ticketAPI->fetchTickets($licenseID, $status);
        exit();


      case 'CREATE-TICKET':
        header('Content-Type: application/json');

        $ticketAPI = new TicketAPI($conn);
        echo $ticketAPI->createTicket($_POST);
        exit();


      case 'UPDATE-TICKET-STATUS':
        header('Content-Type: application/json');

        $ticketAPI = new TicketAPI($conn);
        echo $ticketAPI->updateTicketStatus($_POST['ticket_id'], $_POST['status']);
        exit();


      case 'DELETE-TICKET':
        header('Content-Type: application/json');

        $ticketAPI = new TicketAPI($conn);
        echo $ticketAPI->deleteTicket($_POST['ticket_id']);
        exit();

      case 'CREATE-LICENSE': // PARA SA ADMIN CREATE LICENSE
        $licenseAPI = new LicenseAPI($conn);
        echo $licenseAPI->createLicense();
        exit();

      case 'UPDATE-LICENSE': // PARA SA ADMIN CREATE LICENSE
        header('Content-Type: application/json');

        $licenseAPI = new LicenseAPI($conn);
        echo $licenseAPI->updateLicense();
        exit();

        
      case 'DELETE-LICENSE': // PARA SA ADMIN DELETE LICENSE
        header('Content-Type: application/json');

        $licenseAPI = new LicenseAPI($conn);
        echo $licenseAPI->deleteLicense();
        exit();


      case 'CREATE-VEHICLE': // PARA SA ADMIN CREATE VEHICLE
        $vehicleAPI = new VehicleAPI($conn);
        echo $vehicleAPI->createVehicle();
        exit();


      case 'UPDATE-VEHICLE': // PARA SA ADMIN UPDATE VEHICLE
        header('Content-Type: application/json');

        $vehicleAPI = new VehicleAPI($conn);
        echo $vehicleAPI->updateVehicle();
        exit();

      case 'DELETE-VEHICLE': // PARA SA ADMIN DELETE VEHICLE
        header('Content-Type: application/json');

        $vehicleAPI = new VehicleAPI($conn);
        echo $vehicleAPI->deleteVehicle();
        exit();
  }
}
?>