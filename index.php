<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <style>
      body {
        margin: 0;
        padding: 0;
        height: 100vh;

        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
      }
      a {
        text-decoration: none;
        background-color: green;
        color: white;
        padding: 16px 20px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 24px;
      }
      a:hover {
        opacity: 0.7;
      }
    </style>
  </head>
  <body>
        <a href="PageCreatePerson.php">Create Person</a>
        <a href="PageCreateDL.php">Create License</a>
  </body>
</html>

<?php
  require_once "DBConnect.php";
  require_once "Vehicle.php";
  require_once "VehicleRegistration.php";
  require_once "DriversLicense.php";
  require_once "TicketViolation.php";

  // Vehicle: brandName, modelName, modelYear, modelColor
  // VehicleRegistration: plateNumber, mvFileNumber, issueDate, registrationStatus, vehicle, driverLicense
  // Person: firstName, middleName, lastName, dateOfBirth, gender, address
  // DriverLicense: licenseNumber, licenseStatus, licenseType, issueDate, expiryOption, person
  // TicketViolation: trafficViolation, dateOfIncident, placeOfIncident, violationStatus, driverLicense
?>