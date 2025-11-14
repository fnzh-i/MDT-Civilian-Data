<?php
  require_once "DBConnect.php";

  enum RegistrationStatus: string {
    case REGISTERED = "REGISTERED";
    case UNREGISTERED = "UNREGISTERED";
    case EXPIRED = "EXPIRED";
  }

  class Vehicle {
    private string $plateNumber;
    private ?string $mvFileNumber;
    private DateTime $issueDate;
    private DateTime $expiryDate;
    private RegistrationStatus $registrationStatus;
   
    private string $brandName;
    private string $modelName;
    private int $modelYear;
    private string $modelColor;

    public function __construct(
      string $plateNumber,
      ?string $mvFileNumber,
      DateTime $issueDate,
      RegistrationStatus $registrationStatus,

      string $brandName,
      string $modelName,
      int $modelYear,
      string $modelColor,
      ) {
      $this->plateNumber = $plateNumber;
      $this->mvFileNumber = $mvFileNumber;
      $this->issueDate = $issueDate;
      $this->registrationStatus = $registrationStatus;

      $this->expiryDate = clone $this->issueDate;
      $this->expiryDate->add(new DateInterval("P1Y"));

      $this->brandName = $brandName;
      $this->modelName = $modelName;
      $this->modelYear = $modelYear;
      $this->modelColor = $modelColor;
    }

    public function getPlateNumber(): string {
      return $this->plateNumber;
    }

    public function getMVFileNumber(): ?string {
      return $this->mvFileNumber;
    }

    public function getExpiryDate(): DateTime {
      return $this->expiryDate;
    }

    public function getRegistrationStatus(): RegistrationStatus {
      return $this->registrationStatus;
    }

    public function getBrandName(): string {
      return $this->brandName;
    }

    public function getModelName(): string {
      return $this->modelName;
    }

    public function getModelYear(): int {
      return $this->modelYear;
    }

    public function getModelColor(): string {
      return $this->modelColor;
    }

    public function displayInfo() {
      return 
        "
          <strong>Vehicle Information</strong> <br>
          Plate Number: {$this->getPlateNumber()} <br>
          MV File Number: {$this->getMVFileNumber()} <br>
          Expiry Date: {$this->getExpiryDate()->format("F j, Y")} <br>
          Registration Status: {$this->getRegistrationStatus()->value} <br> <br>

          Brand Name: {$this->getBrandName()} <br>
          Model Name: {$this->getModelName()} <br>
          Model Year: {$this->getModelYear()} <br>
          Model Color: {$this->getModelColor()} <br>
        ";
    }

    public function save(mysqli $conn, int $license_id): string | bool {
      $checkStmt = $conn->prepare("SELECT license_id FROM licenses WHERE license_id = ?");
      $checkStmt->bind_param("i", $license_id);
      $checkStmt->execute();

      $result = $checkStmt->get_result();

      if ($result->num_rows === 0) {
        $checkStmt->close();
        return "Error: License ID $license_id not found in licenses table.";
      }

      $checkStmt->close();

      $stmt = $conn->prepare("
        INSERT INTO vehicles(plate_number, mv_file_number, expiry_date, registration_status,
        brand_name, model_name, model_year, model_color, license_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
      ");

      $plateNumber = $this->getPlateNumber();
      $mvFileNumber = $this->getMVFileNumber();
      $expiryDate = $this->getExpiryDate()->format("Y-m-d");
      $registrationStatus = $this->getRegistrationStatus()->value;
      $brandName = $this->getBrandName();
      $modelName = $this->getModelName();
      $modelYear = $this->getModelYear();
      $modelColor = $this->getModelColor();

      $stmt->bind_param(
        "ssssssisi",
        $plateNumber,
        $mvFileNumber,
        $expiryDate,
        $registrationStatus,
        $brandName,
        $modelName,
        $modelYear,
        $modelColor,
        $license_id
      );

      if (!$stmt->execute()) {
        $error = "Database error: {$stmt->error}";
        $stmt->close();
        return $error;
      }

      $stmt->close();
      return true;
    }

    private static function inferIssueDate(string $expiryDate): DateTime {
      $date = new DateTime($expiryDate);
      $date->sub(new DateInterval("P1Y")); // subtract 1 year
      return $date;
    }

    public static function fromDatabase(array $row): self {
      return new self(
        $row['plate_number'],
        $row['mv_file_number'] ?? null,
        self::inferIssueDate($row['expiry_date']),
        RegistrationStatus::from($row['registration_status']),
        $row['brand_name'],
        $row['model_name'],
        (int)$row['model_year'],
        $row['model_color']
      );
    }

    public static function searchPlateNumber(mysqli $conn, string $plateNumber): string|array {
      $stmt = $conn->prepare("SELECT * FROM vehicles WHERE plate_number = ?");
      $stmt->bind_param("s", $plateNumber);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows === 0) {
        $stmt->close();
        return "Error: Vehicle with plate number $plateNumber not found.";
      } else {
        $row = $result->fetch_assoc();
        $stmt->close();
        return [
          "vehicle" => self::fromDatabase($row),
          "vehicle_id" => $row['vehicle_id'] ?? null
        ];
      }
    }

    public static function searchMVfileNumber(mysqli $conn, string $mvFileNumber): string|array {
      $stmt = $conn->prepare("SELECT * FROM vehicles WHERE mv_file_number = ?");
      $stmt->bind_param("s", $mvFileNumber);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows === 0) {
        $stmt->close();
        return "Error: Vehicle with MV File Number $mvFileNumber not found.";
      } else {
        $row = $result->fetch_assoc();
        $stmt->close();
        return [
          "vehicle" => self::fromDatabase($row),
          "vehicle_id" => $row['vehicle_id'] ?? null
        ];
      }
    }

  }
?>