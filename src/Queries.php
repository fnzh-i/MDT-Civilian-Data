<?php
  require_once "DBConnect.php";
  require_once "Person.php";
  require_once "DriverLicense.php";

  // $sql = "CREATE TABLE persons (
  //   person_id INT PRIMARY KEY AUTO_INCREMENT,
  //   first_name VARCHAR(50) NOT NULL,
  //   middle_name VARCHAR(50),
  //   last_name VARCHAR(50) NOT NULL,
  //   date_of_birth DATE NOT NULL,
  //   gender ENUM('Male', 'Female') NOT NULL,
  //   address VARCHAR(100) NOT NULL
  // );";

  // if ($conn->query($sql)) {
  //   echo "persons table created successfully.";
  // } else {
  //   echo "Table creation failed: {$conn->error}";
  // }

  // $sql = "CREATE TABLE driver_licenses (
  //   license_id INT PRIMARY KEY AUTO_INCREMENT,
  //   license_number VARCHAR(50) NOT NULL UNIQUE,
  //   license_status ENUM('Registered', 'Unregistered', 'Expired') NOT NULL,
  //   license_type ENUM('Professional', 'Non-Professional', 'Student Permit') NOT NULL,
  //   issue_date DATE NOT NULL,
  //   expiry_date DATE NOT NULL,
  //   dl_codes VARCHAR(50) NOT NULL,
  //   person_id INT NOT NULL UNIQUE,
  //   FOREIGN KEY (person_id) REFERENCES persons(person_id)
  // );";

  // if ($conn->query($sql)) {
  //   echo "driver_licenses table created successfully.";
  // } else {
  //   echo "Table creation failed: {$conn->error}";
  // }
?>