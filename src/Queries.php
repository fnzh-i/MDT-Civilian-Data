<?php
  require_once "DBConnect.php";
  require_once "DriversLicense.php";

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

  // $sql = "DROP TABLE persons;";

  // if ($conn->query($sql)) {
  //   echo "driver_licenses table created successfully.";
  // } else {
  //   echo "Table creation failed: {$conn->error}";
  // }

  // $sql = "CREATE TABLE licenses (
  //   license_id INT AUTO_INCREMENT PRIMARY KEY,
  //   license_number VARCHAR(50) NOT NULL UNIQUE,
  //   license_status ENUM('REGISTERED', 'UNREGISTERED', 'EXPIRED') NOT NULL,
  //   license_status ENUM('REGISTERED', 'UNREGISTERED', 'EXPIRED', 'REVOKED') NOT NULL,
  //   license_status ENUM('REGISTERED', 'UNREGISTERED', 'EXPIRED', 'REVOKED') NOT NULL,
  //   license_type ENUM('PROFESSIONAL', 'NON-PROFESSIONAL', 'STUDENT PERMIT') NOT NULL,
  //   issue_date DATE NOT NULL,
  //   expiry_date DATE NOT NULL,
  //   dl_codes VARCHAR(50) NOT NULL,

  //   first_name VARCHAR(50) NOT NULL,
  //   middle_name VARCHAR(50) NULL,
  //   last_name VARCHAR(50) NOT NULL,
  //   date_of_birth DATE NOT NULL,
  //   gender ENUM('Male', 'Female') NOT NULL,
  //   address VARCHAR(100) NOT NULL
  // );";

  // if ($conn->query($sql)) {
  //   echo "Table created successfully.";
  // } else {
  //   echo "Error creating table: {$conn->error}";
  // }

  // $sql = "CREATE TABLE vehicles (
  //   vehicle_id INT AUTO_INCREMENT PRIMARY KEY,
  //   plate_number VARCHAR(50) NOT NULL UNIQUE,
  //   mv_file_number VARCHAR(50) NULL UNIQUE,
  //   expiry_date DATE NOT NULL,
  //   registration_status ENUM('REGISTERED', 'UNREGISTERED', 'EXPIRED') NOT NULL,

  //   brand_name VARCHAR(50) NOT NULL,
  //   model_name VARCHAR(50) NOT NULL,
  //   model_year INT NOT NULL,
  //   model_color VARCHAR(50) NOT NULL,
  //   license_id INT NOT NULL,
  //   FOREIGN KEY (license_id) REFERENCES licenses (license_id)
  // );";

  // if ($conn->query($sql)) {
  //   echo "Table created successfully.";
  // } else {
  //   echo "Error creating table: {$conn->error}";
  // }

  // $sql = "CREATE TABLE ticket_violations (
  //   ticket_id INT AUTO_INCREMENT PRIMARY KEY,
  //   violation ENUM(
  //     'ILLEGAL PARKING', 'RECKLESS DRIVING', 'DISOBEYING TRAFFIC SIGNS',
  //     'OVERSPEEDING', 'DRIVING UNDER INFLUENCE', 'OBSTRUCTION',
  //     'NO DRIVER LICENSE', 'EXPIRED DRIVER LICENSE', 'UNREGISTERED VEHICLE',
  //     'NO OR/CR', 'NUMBER CODING', 'NO HELMET', 'NO SEATBELT'
  //   ) NOT NULL,
  //   date_of_incident DATE NOT NULL,
  //   place_of_incident VARCHAR(100) NOT NULL,
  //   status ENUM('SETTLED', 'UNSETTLED'),
  //   license_id INT NOT NULL,
  //   FOREIGN KEY (license_id) REFERENCES licenses (license_id)
  // )";

  // if ($conn->query($sql)) {
  //   echo "Table created successfully.";
  // } else {
  //   echo "Error creating table: {$conn->error}";
  // }

  // $sql = "ALTER TABLE ticket_violations 
  //  MODIFY COLUMN date_of_incident DATETIME NOT NULL;";

  //  if ($conn->query($sql)) {
  //   echo "Modification succeeded.";
  //  } else {
  //   echo "Modification failed: {$conn->error}";
  //  }
  
  // $sql = "CREATE TABLE users (
  //   user_id INT AUTO_INCREMENT PRIMARY KEY,
  //   email VARCHAR(100) NOT NULL,
  //   password VARCHAR(100) NOT NULL
  // );";

  // if ($conn->query($sql)) {
  //   echo "Table created successfully.";
  // } else {
  //   echo "Table creation failed: {$conn->error}";
  // }

  // $sql = "TRUNCATE TABLE ticket_violations";

  // if ($conn->query($sql)) {
  //   echo "Truncation successful.";
  // } else {
  //   echo "Truncation failed: {$conn->error}";
  // }

  // $sql = "ALTER TABLE ticket_violations ADD note VARCHAR(255) NULL AFTER status";

  // if ($conn->query($sql)) {
  //   echo "Table altered successfully.";
  // } else {
  //   "Altering table failed: {$conn->error}";
  // }

  // $sql = "CREATE TABLE licenses (
  //   license_id INT AUTO_INCREMENT PRIMARY KEY,
  //   license_number VARCHAR(50) NOT NULL UNIQUE,
  //   license_status ENUM('REGISTERED', 'UNREGISTERED', 'EXPIRED', 'REVOKED') NOT NULL,
  //   license_type ENUM('PROFESSIONAL', 'NON-PROFESSIONAL', 'STUDENT PERMIT') NOT NULL,
  //   issue_date DATE NOT NULL,
  //   expiry_date DATE NOT NULL,
  //   dl_codes VARCHAR(50) NOT NULL,

  //   first_name VARCHAR(50) NOT NULL,
  //   middle_name VARCHAR(50) NULL,
  //   last_name VARCHAR(50) NOT NULL,
  //   date_of_birth DATE NOT NULL,
  //   gender ENUM('Male', 'Female') NOT NULL,
  //   address VARCHAR(100) NOT NULL
  // );";

  // if ($conn->query($sql)) {
  //   echo "Table created successfully.";
  // } else {
  //   echo "Error creating table: {$conn->error}";
  // }
?>