<?php
  require_once __DIR__ . '/../bootstrap.php';


  // $sql = "ALTER TABLE licenses
  //   DROP COLUMN first_name,
  //   DROP COLUMN middle_name,
  //   DROP COLUMN last_name,
  //   DROP COLUMN date_of_birth,
  //   DROP COLUMN gender,
  //   DROP COLUMN address
  // ;";


  // $sql = "CREATE TABLE personal_information(
  //   license_id INT NOT NULL,
  //   first_name VARCHAR(50) NOT NULL,
  //   middle_name VARCHAR(50) NULL,
  //   last_name VARCHAR(50) NOT NULL,
  //   date_of_birth DATE NOT NULL,
  //   gender VARCHAR(50) NOT NULL,
  //   address VARCHAR(255) NOT NULL,
  //   nationality VARCHAR(50) NOT NULL,
  //   height VARCHAR(50) NOT NULL,
  //   weight VARCHAR(50) NOT NULL,
  //   eye_color VARCHAR(50) NOT NULL,
  //   blood_type VARCHAR(50) NULL,

  //   PRIMARY KEY (license_id),
  //   FOREIGN KEY (license_id) REFERENCES licenses(license_id)
  // );";

  // if ($conn->query($sql)) {
  //   echo "Successful.";
  // } else {
  //   echo "Unsuccessful: {$conn->error}";
  // }

  // $sql = "ALTER TABLE personal_information
  //   MODIFY nationality VARCHAR(50) NULL,
  //   MODIFY height VARCHAR(50) NULL,
  //   MODIFY weight VARCHAR(50) NULL,
  //   MODIFY eye_color VARCHAR(50) NULL
  // ;";

  // if ($conn->query($sql)) {
  //   echo "Successful.";
  // } else {
  //   echo "Unsuccessful: {$conn->error}";
  // }

  // $sql = "
  //   INSERT INTO personal_information (
  //     license_id, first_name, middle_name, last_name,
  //     date_of_birth, gender, address
  //   )
  //   SELECT
  //     license_id, first_name, middle_name, last_name,
  //     date_of_birth, gender, address
  //   FROM licenses
  // ;";

  // if ($conn->query($sql)) {
  //   echo "Successful.";
  // } else {
  //   echo "Unsuccessful: {$conn->error}";
  // }

  // $sql = "
  //  SET FOREIGN_KEY_CHECKS = 1;
  // ";
  // if ($conn->query($sql)) {
  //   echo "Successful.";
  // } else {
  //   echo "Unsuccessful: {$conn->error}";
  // }

  // $sql = "
  //   ALTER TABLE licenses
  //   DROP COLUMN first_name,
  //   DROP COLUMN middle_name,
  //   DROP COLUMN last_name,
  //   DROP COLUMN date_of_birth,
  //   DROP COLUMN gender,
  //   DROP COLUMN address
  // ;";

  // if ($conn->query($sql)) {
  //   echo "Successful.";
  // } else {
  //   echo "Unsuccessful: {$conn->error}";
  // }

//   $sql = "DESCRIBE licenses";
// $result = $conn->query($sql);

// if ($result) {
//     while ($row = $result->fetch_assoc()) {
//         echo $row['Field'] . " | " . $row['Type'] . " | " . $row['Null'] . " | " . $row['Key'] . "<br>";
//     }
// } else {
//     echo "Unsuccessful: " . $conn->error;
// }

// $license = new DriversLicense(
  //   "QRS 4723",
  //   LicenseStatus::REGISTERED,
  //   LicenseType::PROFESSIONAL,
  //   new DateTime("January 28, 2023"),
  //   ExpiryOption::TEN_YEARS,
  //   [DLCodes::A, DLCodes::B],

  //   "Jane",
  //   null,
  //   "Reyes",
  //   new DateTime("October 16, 2006"),
  //   Gender::FEMALE,
  //   "Quezon City",
  //   "Filipino",
  //   "162 cm",
  //   "55 kg",
  //   "Brown",
  //   null
  // );

  // if ($license->save($conn)) {
  //   echo "Successful";
  // } else {
  //   echo "Unsuccesful: {$conn->error}";
  // }
?>