<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbName = "mobile_data_terminal";

  $conn = new mysqli($servername, $username, $password, $dbName);

  if ($conn->connect_error) {
    die("Failed to connect to database: {$conn->connect_error}");
  } // else {
  // echo "Connected to database successfully.";
  // }

  // $sql = "CREATE DATABASE mobile_data_terminal;";

  // if ($conn->query($sql)) {
  //   echo "Database created successfully";
  // } else {
  //   echo "Database creation failed: {$conn->error}";
  // }

  // $sql = "DELETE FROM persons WHERE person_id=8;";

  // $sql = "ALTER TABLE driver_licenses 
  //   MODIFY COLUMN license_type ENUM('Professional','Non-Professional', 'Student Permit') NOT NULL;";

  // if ($conn->query($sql)) {
  //   echo "Alteration successfully.";
  // } else {
  //   echo "Error alteration: {$conn->error}";
  // }

?>