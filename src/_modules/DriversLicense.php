<?php
  require_once __DIR__ . '/../bootstrap.php';

  enum LicenseStatus: string {
    case REGISTERED = "REGISTERED";
    case UNREGISTERED = "UNREGISTERED";
    case EXPIRED = "EXPIRED";
    case REVOKED = "REVOKED";
  }

  enum LicenseType: string {
    case PROFESSIONAL = "PROFESSIONAL";
    case NON_PROFESSIONAL = "NON-PROFESSIONAL";
    case STUDENT_PERMIT = "STUDENT PERMIT";
  }

  enum ExpiryOption: int {
    case FIVE_YEARS = 5;
    case TEN_YEARS = 10;

    public function getInterval(): DateInterval {
      return new DateInterval("P{$this->value}Y");
    }
  }

  enum DLCodes: string {
    case A = "A"; // motorcycles
    case A1 = "A1"; // tricycles
    case B = "B";
    case B1 = "B1";
    case C = "C"; // large trucks
    case D = "D"; // buses
  }

  enum Gender: string {
    case MALE = "Male";
    case FEMALE = "Female";
  }

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
      string $address
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

    public function getLastName(): string {
      return $this->lastName;
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
        $row['address']
      );
    }

      public static function searchLicenseNumber(mysqli $conn, string $licenseNumber): string | array {
      $checkStmt = $conn->prepare("SELECT * FROM licenses WHERE license_number = ?");
      $checkStmt->bind_param("s", $licenseNumber);
      $checkStmt->execute();

      $result = $checkStmt->get_result();

      if ($result->num_rows === 0) {
        $checkStmt->close();
        return "Error: License Number $licenseNumber not found in licenses table.";
      } else {
        $row = $result->fetch_assoc();
        $checkStmt->close();
        
        $license = self::fromDatabase($row);

        return [
          "license" => $license,
          "license_id" => $row['license_id']
        ];
      }
    }
  }
?>