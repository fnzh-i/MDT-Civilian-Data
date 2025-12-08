<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
require_once __DIR__ . '/../bootstrap.php';


  if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    switch ($action) {
    case 'USER-LOGIN':

      $email = $_POST['email'] ?? null;
      $password = $_POST['password'] ?? null;

      $loginResult = User::searchEmail($conn, $email, $password);

      if (is_array($loginResult)) { // <--- IMPORTANTE WAG GAGALINGIN TONG LINYANG TO
        $_SESSION['id'] = $loginResult['user_id'];
        $_SESSION['email'] = $loginResult['email'];
        $_SESSION['role'] = $loginResult['role'];
        $_SESSION['first_name'] = $loginResult['first_name'];
        $_SESSION['last_name'] = $loginResult['last_name'];

        // logic redirect based on role
        $redirect = match (strtoupper($_SESSION['role'])) {
          // 'ADMIN' => '../_admin_panel/admin_dashboard.php',
          'ADMIN' => '_officer/officer_dashboard.php',
          'SUPERVISOR' => '_officer/officer_dashboard.php',
          'USER' => '_user/user_dashboard.php',
          default => '_officer/officer_dashboard.php', // fallback to officer
        };

        // send JSON with redirect info
        echo json_encode([
          "status" => "SUCCESS",
          "role" => $_SESSION['role'],
          "redirect" => $redirect
        ]);
      } else {
        echo json_encode([
          "status" => "ERROR",
          "message" => $loginResult
        ]);
      }
      exit;

    case 'REGISTER-USER':
      header('Content-Type: application/json');

      $userAPI = new UserAPI($conn);
      echo $userAPI->registerUser();
      exit();

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

      case 'CREATE-USER': // PARA SA ADMIN CREATE USER
        header('Content-Type: application/json');

        $userAPI = new UserAPI($conn);
        echo $userAPI->registerAdmin();
        exit();
  }
}
?>