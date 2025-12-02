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
    private string $vin;
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
      string $vin,
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
      $this->vin = $vin;
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

    public function getVin(): string {
      return $this->vin;
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
        $row['vin'],
        self::inferIssueDate($row['expiry_date']),
        RegistrationStatus::from($row['registration_status']),
        $row['brand_name'],
        $row['model_name'],
        (int)$row['model_year'],
        $row['model_color'],
        $row['license_id'],
      );
    }


    // I SE-SEARCH PAREHONG PLATE AT MV FILE NUMBER, PARA IISANG FUNCTION CALL NALANG
    public static function searchVehicle(mysqli $conn, string $query): string|array {
      $sql = "SELECT 
        v.*, 
        l.license_number, l.license_status, l.license_type, 
        l.issue_date, l.expiry_date AS license_expiry,
        p.first_name, p.middle_name, p.last_name, p.address
        FROM vehicles v
        LEFT JOIN licenses l ON v.license_id = l.license_id
        LEFT JOIN personal_information p ON l.license_id = p.license_id
        WHERE v.plate_number = ? OR v.mv_file_number = ?";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ss", $query, $query);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows === 0) {
        $stmt->close();
        return "Error: Vehicle with Plate or MV File Number '$query' not found.";
      }

      $row = $result->fetch_assoc();
      $stmt->close();

      // full name formatting
      $fullName = trim($row["first_name"] ?? '');
      if (!empty($row["middle_name"])) {
        $fullName .= ' ' . strtoupper($row["middle_name"][0]) . '.';
      }
      $fullName .= ' ' . ($row["last_name"] ?? '');
      $fullName = trim($fullName);

      return [
        "vehicle" => self::fromDatabase($row),
        "vehicle_id" => $row['vehicle_id'] ?? null,
        "license" => [
          "license_number" => $row['license_number'],
          "license_status" => $row['license_status'],
          "license_type"   => $row['license_type'],
          "issue_date"     => $row['issue_date'],
          "expiry_date"    => $row['license_expiry']
        ],
        "person" => [
          "first_name"  => $row['first_name'],
          "middle_name" => $row['middle_name'],
          "last_name"   => $row['last_name'],
          "full_name"   => $fullName,
          "address"     => $row['address']
        ]
      ];
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