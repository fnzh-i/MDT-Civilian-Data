<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  
</body>
</html>

<?php
  require_once "DBConnect.php";
  require_once "User.php";
  require_once "DriversLicense.php";
  require_once "Vehicle.php";
  require_once "TicketViolation.php";

  // $license = new DriverLicense(
  //   "A5-66-778899",
  //   LicenseStatus::EXPIRED,
  //   LicenseType::PROFESSIONAL,
  //   new DateTime("November 7, 2024"),
  //   ExpiryOption::FIVE_YEARS,
  //   array (DLCodes::A, DLCodes::A1, DLCodes::B, DLCodes::B1, DLCodes::C, DLCodes::D),
  //   "John",
  //   "Cruz",
  //   "Garcia",
  //   new DateTime("March 1, 2009"),
  //   Gender::MALE,
  //   "Quezon City"
  // );

  // echo $license->displayInfo();

  // if ($license->save($conn)) {
  //   echo "License saved to licenses table.";
  // } else {
  //   echo "Failed saving to license table: {$conn->error}"; 
  // }

  // $vehicle = new Vehicle(
  //   "LMNO 9876",
  //   "3467-9876543",
  //   new DateTime("June 7, 2019"),
  //   RegistrationStatus::EXPIRED,
  //   "Mitsubishi",
  //   "Montero GLS",
  //   2019,
  //   "Black"
  // );

  // echo $vehicle->displayInfo();

  // $result = $vehicle->save($conn, 4);

  // if ($result === true) {
  //   echo "Vehicle added to vehicles table.";
  // } else {
  //   echo "Failed saving to vehicles table: {$result}";
  // }

  // $ticket = new TicketViolation(
  //   Violation::ILLEGAL_PARKING,
  //   new DateTime("October 13, 2025 9:30 AM"),
  //   "Quezon City",
  //   ViolationStatus::UNSETTLED
  // );
  // echo $ticket->displayInfo();

  // $result = $ticket->save($conn, 1);
  // if ($result === true) {
  //   echo "Ticket added to ticket_violations table.";
  // } else {
  //   echo "Failed saving to ticker_violations table: {$result}";
  // }
?>