<?php
  require_once "DBConnect.php";

  enum LicenseStatus: string {
    case REGISTERED = "REGISTERED";
    case UNREGISTERED = "UNREGISTERED";
    case EXPIRED = "EXPIRED";
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

  class DriverLicense {
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
      string $address,
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
      $middleInitial = mb_substr($this->getMiddleName(), 0, 1);
      return "{$middleInitial}.";
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

    public function displayInfo(): string {
      return
      "
        <strong>License Information</strong> <br>
        License Number: {$this->getLicenseNumber()} <br>
        License Status: {$this->getLicenseStatus()->value} <br>
        License Type: {$this->getLicenseType()->value} <br>
        Issue Date: {$this->getIssueDate()->format("F j, Y")} <br>
        Expiry Date: {$this->getExpiryDate()->format("F j, Y")} <br>
        DL Codes: {$this->getDLCodesToString()} <br> <br>

        <strong>Personal Information</strong> <br>
        First Name: {$this->getFirstName()} <br>
        Middle Name: {$this->getMiddleName()} <br>
        Last Name: {$this->getLastName()} <br>
        Date Of Birth: {$this->getDateOfBirth()->format("F j, Y")} <br>
        Gender: {$this->getGender()->value} <br>
        Address: {$this->getAddress()} <br>
      ";
    }

    public function save(mysqli $conn): bool {
      $stmt = $conn->prepare("
        INSERT INTO licenses(license_number, license_status, license_type, issue_date, expiry_date, dl_codes,
        first_name, middle_name, last_name, date_of_birth, gender, address)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
      ");

      $licenseNumber = $this->getLicenseNumber();
      $licenseStatus = $this->getLicenseStatus()->value;
      $licenseType = $this->getLicenseType()->value;
      $issueDate = $this->getIssueDate()->format("Y-m-d");
      $expiryDate = $this->getExpiryDate()->format("Y-m-d");
      $dlCodes = $this->getDLCodesToString();

      $firstName = $this->getFirstName();
      $middleName = $this->getMiddleName();
      $lastName = $this->getLastName();
      $dateOfBirth = $this->getDateOfBirth()->format("Y-m-d");
      $gender = $this->getGender()->value;
      $address = $this->getAddress();

      $stmt->bind_param(
        "ssssssssssss",
        $licenseNumber,
        $licenseStatus,
        $licenseType,
        $issueDate,
        $expiryDate,
        $dlCodes,
        $firstName,
        $middleName,
        $lastName,
        $dateOfBirth,
        $gender,
        $address
      );

      return $stmt->execute();
    }
  }
?>