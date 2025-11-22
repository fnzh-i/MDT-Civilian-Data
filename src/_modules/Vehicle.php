<?php
  require_once __DIR__ . '/../bootstrap.php';

  enum RegistrationStatus: string {
    case REGISTERED = "REGISTERED";
    case UNREGISTERED = "UNREGISTERED";
    case EXPIRED = "EXPIRED";
  }

  class Vehicle {
    private string $plateNumber;
    private ?string $mvFileNumber;
    private string $vinNumber;
    private DateTime $issueDate;
    private DateTime $expiryDate;
    private RegistrationStatus $registrationStatus;
   
    private string $brandName;
    private string $modelName;
    private int $modelYear;
    private string $modelColor;
    private int $licenseID;

    public function __construct(
      string $plateNumber,
      ?string $mvFileNumber,
      string $vinNumber,
      DateTime $issueDate,
      RegistrationStatus $registrationStatus,

      string $brandName,
      string $modelName,
      int $modelYear,
      string $modelColor,
      int $licenseID
      ) {
      $this->plateNumber = $plateNumber;
      $this->mvFileNumber = $mvFileNumber;
      $this->vinNumber = $vinNumber;
      $this->issueDate = $issueDate;
      $this->registrationStatus = $registrationStatus;

      $this->expiryDate = clone $this->issueDate;
      $this->expiryDate->add(new DateInterval("P1Y"));

      $this->brandName = $brandName;
      $this->modelName = $modelName;
      $this->modelYear = $modelYear;
      $this->modelColor = $modelColor;
      $this->licenseID = $licenseID;
    }

    public function getPlateNumber(): string {
      return $this->plateNumber;
    }

    public function getMVFileNumber(): ?string {
      return $this->mvFileNumber;
    }

    public function getVinNumber(): string {
      return $this->vinNumber;
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

    public function getLicenseID(): int {
      return $this->licenseID;
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
        $row['vin_number'],
        self::inferIssueDate($row['expiry_date']),
        RegistrationStatus::from($row['registration_status']),
        $row['brand_name'],
        $row['model_name'],
        (int)$row['model_year'],
        $row['model_color'],
        $row['license_id'],
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