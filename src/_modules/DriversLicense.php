<?php
  require_once __DIR__ . '/../bootstrap.php';

  class DriversLicense {
    private ?int $license_id = null; // will have an auto-incremented value once saved to DB
    private string $licenseNumber;
    private LicenseStatus $licenseStatus;
    private LicenseType $licenseType;
    private DateTime $issueDate;
    private ExpiryOption $expiryOption;
    private DateTime $expiryDate;
    private array $dlCodes;

    private string $firstName;
    private ?string $middleName;
    private string $lastName;
    private DateTime $dateOfBirth;
    private Gender $gender;
    private string $address;
    private string $nationality;
    private string $height;
    private string $weight;
    private string $eyeColor;
    private ?string $bloodType;

    public function __construct(
      string $licenseNumber,
      LicenseStatus $licenseStatus,
      LicenseType $licenseType,
      DateTime $issueDate,
      ExpiryOption $expiryOption,
      array $dlCodes,

      string $firstName,
      ?string $middleName,
      string $lastName,
      DateTime $dateOfBirth,
      Gender $gender,
      string $address,
      string $nationality,
      string $height,
      string $weight,
      string $eyeColor,
      ?string $bloodType
    ) {
      $this->licenseNumber = $licenseNumber;
      $this->licenseStatus = $licenseStatus;
      $this->licenseType = $licenseType;
      $this->issueDate = $issueDate;
      $this->expiryOption = $expiryOption;
      $this->dlCodes = $dlCodes;

      $this->expiryDate = clone $this->issueDate;
      $this->expiryDate->add($this->expiryOption->getInterval());

      $this->firstName = $firstName;
      $this->middleName = $middleName;
      $this->lastName = $lastName;
      $this->dateOfBirth = $dateOfBirth;
      $this->gender = $gender;
      $this->address = $address;
      $this->nationality = $nationality;
      $this->height = $height;
      $this->weight = $weight;
      $this->eyeColor = $eyeColor;
      $this->bloodType = $bloodType;
    }

    public function getLicenseID(): int {
      return $this->license_id;
    }

    public function getLicenseNumber(): string {
      return $this->licenseNumber;
    }

    public function getLicenseStatus(): LicenseStatus {
      return $this->licenseStatus;
    }

    public function getLicenseType(): LicenseType {
      return $this->licenseType;
    }

    public function getIssueDate(): DateTime {
      return $this->issueDate;
    }

    public function getExpiryDate(): DateTime {
      return $this->expiryDate;
    }

    public function getDLCodes(): array {
      return $this->dlCodes;
    }
    
    public function getDLCodesToString(): string {
      $str = "";
      foreach ($this->dlCodes as $code) {
          $str .= $code->value . ", ";
      }
      return rtrim($str, ", ");
    }

    public function getFirstName(): string {
      return $this->firstName;
    }

    public function getMiddleName(): ?string {
      return $this->middleName;
    }

    public function getMiddleInitial(): string {
      if ($this->middleName) {
        return strtoupper($this->middleName[0]) . ".";
      }
      return ""; // return empty string if wala syang middle name
    }

    public function getLastName(): string {
      return $this->lastName;
    }

    public function getFullName(): string {
      return "{$this->getFirstName()} {$this->getMiddleInitial()} {$this->getLastName()}";
    }

    public function getDateOfBirth(): DateTime {
      return $this->dateOfBirth;
    }

    public function getGender(): Gender {
      return $this->gender;
    }

    public function getAddress(): string {
      return $this->address;
    }

    public function getNationality(): string {
      return $this->nationality;
    }

    public function getHeight(): string {
      return $this->height;
    }

    public function getWeight(): string {
      return $this->weight;
    }

    public function getEyeColor(): string {
      return $this->eyeColor;
    }

    public function getBloodType(): ?string {
      return $this->bloodType;
    }

    public function save(mysqli $conn): string | bool {
      // CHECK MUNA IF EXISTING NA YUNG LICENSE-NUMBER SA DB TO AVOID DUPLICATION
      $licenseNumber = $this->getLicenseNumber();

      $check = $conn->prepare("SELECT 1 FROM licenses WHERE license_number = ?");
      if (!$check) {
        return "Check prepare failed: " . $conn->error;
      }

      $check->bind_param("s", $licenseNumber);
      $check->execute();
      $check->store_result();

      if ($check->num_rows > 0) {
        return "License number already exists.";
      }

      $check->close();

      // insert sa licenses table muna
      $stmt1 = $conn->prepare(
        "INSERT INTO licenses
        (license_number, license_status, license_type, issue_date, expiry_date, dl_codes)
        VALUES (?, ?, ?, ?, ?, ?)"
      );

      if (!$stmt1) {
        return "Prepare failed for licenses: " . $conn->error;
      }

      $licenseNumber = $this->licenseNumber;
      $licenseStatus = $this->licenseStatus->value;
      $licenseType = $this->licenseType->value;
      $issueDate = $this->issueDate->format('Y-m-d');
      $expiryDate = $this->expiryDate->format('Y-m-d');
      $dlCodes = $this->getDLCodesToString(); // comma separated strings

      $stmt1->bind_param(
        "ssssss",
        $licenseNumber,
        $licenseStatus,
        $licenseType,
        $issueDate,
        $expiryDate,
        $dlCodes
      );

      if (!$stmt1->execute()) {
        return "Error saving license: " . $stmt1->error;
      }

      $license_id = $conn->insert_id; // kunin yung auto-incremented license_id key, for foreign key purposes

      $stmt1->close();

      // iinsert na sa personal_information table kasama yung license_id as foreign key
      $stmt2 = $conn->prepare(
        "INSERT INTO personal_information
        (license_id, first_name, middle_name, last_name, date_of_birth, gender, address, nationality, height, weight, eye_color, blood_type)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
      );

      if (!$stmt2) {
        return "Prepare failed for personal_information: " . $conn->error;
      }

      $firstName   = $this->firstName;
      $middleName  = $this->middleName ?? null; // null sa db if left blank
      $lastName    = $this->lastName;
      $dateOfBirth = $this->dateOfBirth->format('Y-m-d');
      $gender      = $this->gender->value;
      $address     = $this->address;
      $nationality = $this->nationality;
      $height      = $this->height;
      $weight      = $this->weight;
      $eyeColor    = $this->eyeColor;
      $bloodType   = $this->bloodType ?? null; // null sa db if left blank

      $stmt2->bind_param(
        "isssssssssss",
        $license_id,
        $firstName,
        $middleName,
        $lastName,
        $dateOfBirth,
        $gender,
        $address,
        $nationality,
        $height,
        $weight,
        $eyeColor,
        $bloodType
      );

      if (!$stmt2->execute()) {
        return "Error saving personal information: " . $stmt2->error;
      }

      $stmt2->close();

      return true;
    }

    public static function inferExpiryOption(string $issueDate, string $expiryDate) {
      $diff = (new DateTime($issueDate))->diff(new DateTime($expiryDate));
      return ($diff->y >=10) ? ExpiryOption::TEN_YEARS : ExpiryOption::FIVE_YEARS;
    }

    public static function fromDatabase(array $row): self {
      $dlCodesArray = array_map(fn($code) => DLCodes::from(trim($code)), explode(',', $row['dl_codes']));

      return new self(
        $row['license_number'],
        LicenseStatus::from($row['license_status']),
        LicenseType::from($row['license_type']),
        new DateTime($row['issue_date']),
        self::inferExpiryOption($row['issue_date'], $row['expiry_date']),
        $dlCodesArray,

        $row['first_name'],
        $row['middle_name'] ?? null,
        $row['last_name'],
        new DateTime($row['date_of_birth']),
        Gender::from($row['gender']),
        $row['address'],
        $row['nationality'],
        $row['height'],
        $row['weight'],
        $row['eye_color'],
        $row['blood_type'] ?? null
      );
    }

    public static function searchLicenseNumber(mysqli $conn, string $licenseNumber): string | array {

      // SQL left join, yung "l" is lahat ng column data sa licenses table, and "p" is from personal_information table
      // ON = pumunta sa personal_information table, hanapin yung row na nagmamatch ang license_id
      // WHERE = hanapin lang yung nag-match na license number na tinype ni User
      $checkStmt = $conn->prepare("
        SELECT 
          l.*, 
          p.first_name, 
          p.middle_name, 
          p.last_name, 
          p.date_of_birth, 
          p.gender, 
          p.address, 
          p.nationality, 
          p.height, 
          p.weight, 
          p.eye_color, 
          p.blood_type
        FROM licenses l
        LEFT JOIN personal_information p 
          ON l.license_id = p.license_id
        WHERE l.license_number = ?
      ");

      if (!$checkStmt) {
        return "SQL Prepare failed: " . $conn->error;
      }

      $checkStmt->bind_param("s", $licenseNumber); // yung entered License number
      $checkStmt->execute();
      $result = $checkStmt->get_result();

      if ($result->num_rows === 0) { // if walang data meaning non-existent yung entered license number
        $checkStmt->close();
        return "Error: License Number $licenseNumber not found.";
      }

      $row = $result->fetch_assoc(); // kunin lahat ng rows ng "joined" table
      $checkStmt->close();

      $license = self::fromDatabase($row); // rebuild the DriversLicense object

      return [
        "license"    => $license,
        "license_id" => $row['license_id']
      ];
    }

    // PARA SA ADMIN UPDATE LICENSE
    public function update(mysqli $conn): string | bool {
      $licenseNumber = $this->getLicenseNumber();

      // GET LICENSE ID
      $stmtId = $conn->prepare("SELECT license_id FROM licenses WHERE license_number = ?");
      if (!$stmtId) return "Prepare failed (fetch license_id): " . $conn->error;

      $stmtId->bind_param("s", $licenseNumber);
      $stmtId->execute();
      $stmtId->bind_result($license_id);
      if (!$stmtId->fetch()) {
        $stmtId->close();
        return "License not found.";
      }
      $stmtId->close();

      // UPDATE LICENSES TABLE
      $stmt1 = $conn->prepare(
        "UPDATE licenses SET 
          license_status = ?, 
          license_type = ?, 
          issue_date = ?, 
          expiry_date = ?, 
          dl_codes = ?
        WHERE license_id = ?"
      );
      if (!$stmt1) return "Prepare failed (update licenses): " . $conn->error;

      $licenseStatus = $this->licenseStatus->value;
      $licenseType   = $this->licenseType->value;
      $issueDate     = $this->issueDate->format('Y-m-d');
      $expiryDate    = $this->expiryDate->format('Y-m-d');
      $dlCodes       = $this->getDLCodesToString();

      $stmt1->bind_param(
        "sssssi",
        $licenseStatus,
        $licenseType,
        $issueDate,
        $expiryDate,
        $dlCodes,
        $license_id
      );

      if (!$stmt1->execute()) {
        return "Error updating license: " . $stmt1->error;
      }
      $stmt1->close();

      // UPDATE PERSONAL INFORMATION TABLE
      $stmt2 = $conn->prepare(
        "UPDATE personal_information SET 
          first_name = ?, 
          middle_name = ?, 
          last_name = ?, 
          date_of_birth = ?, 
          gender = ?, 
          address = ?, 
          nationality = ?, 
          height = ?, 
          weight = ?, 
          eye_color = ?, 
          blood_type = ?
        WHERE license_id = ?"
      );
      if (!$stmt2) return "Prepare failed (update personal_information): " . $conn->error;

      $middleName = $this->middleName ?? null;
      $bloodType = $this->bloodType ?? null;
      $dob = $this->dateOfBirth->format('Y-m-d');
      $gender = $this->gender->value;

      $stmt2->bind_param(
        "sssssssssssi",
        $this->firstName,
        $middleName,
        $this->lastName,
        $dob,
        $gender,
        $this->address,
        $this->nationality,
        $this->height,
        $this->weight,
        $this->eyeColor,
        $bloodType,
        $license_id
      );
      
      if (!$stmt2->execute()) {
        return "Error updating personal information: " . $stmt2->error;
      }
      $stmt2->close();

      return true;
    }

  }
?>