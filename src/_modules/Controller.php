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

      case 'CREATE-LICENSE': // para sa Admin Panel: Create a License
        $licenseAPI = new LicenseAPI($conn);
        echo $licenseAPI->createLicense();
        exit();

      case 'CREATE-VEHICLE': // PARA SA ADMIN CREATE VEHICLE
        $vehicleAPI = new VehicleAPI($conn);
        echo $vehicleAPI->createVehicle();
        exit();








        

        // $licenseNumber = $_POST['license-number'];
        // $result = DriversLicense::searchLicenseNumber($conn, $licenseNumber);

        // if (is_string($result)) {
        //   $_SESSION['error-message'] = $result;

        //   header("Location: Error.php");
        //   exit();
        // } else {
        //   $license = $result['license'];
        //   $licenseId = $result['license_id'];

        //   $_SESSION['license'] = $license;
        //   $_SESSION['license-id'] = $licenseId;

        //   header("Location: AdminSearchLicenseResult.php");
        //   exit();
        // } 
      // case 'SEARCH-LICENSE-NUMBER':
      //   $licenseNumber = $_POST['license-number'];
      //   $result = DriversLicense::searchLicenseNumber($conn, $licenseNumber);

      //   if (is_string($result)) {
      //     $_SESSION['error-message'] = $result;

      //     header("Location: Error.php");
      //     exit();
      //   } else {
      //     $license = $result['license'];
      //     $licenseId = $result['license_id'];

      //     $_SESSION['license'] = $license;
      //     $_SESSION['license-id'] = $licenseId;

      //     header("Location: AdminSearchLicenseResult.php");
      //     exit();
      //   }

      
      // case 'ADD-VIOLATION':
      //   $violation = Violation::from($_POST['violation']);
      //   $dateOfIncident = $_POST['date-of-incident'];
      //   $placeOfIncident = $_POST['place-of-incident'];
      //   $note = $_POST['note'];

      //   $ticket = new TicketViolation($violation, new DateTime($dateOfIncident), $placeOfIncident, $note);

      //   $licenseId = $_SESSION['license-id'];

      //   $result = $ticket->save($conn, $licenseId);

      //   if (is_string($result)) {
      //     $_SESSION['error-message'] = $result;

      //     header("Location: Error.php");
      //     exit();
      //   } else {
      //     echo "Ticket saved successfully.";
      //   }
      //   break;
      }
  }
?>