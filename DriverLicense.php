<?php
  require_once "Person.php";

  enum LicenseStatus: string {
    case REGISTERED = "Registered";
    case UNREGISTERED = "Unregistered";
    case EXPIRED = "Expired";
  }

  enum LicenseType: string {
    case PROFESSIONAL = "Professional";
    case NON_PROFESSIONAL = "Non-Professional";
    case STUDENT_PERMIT = "Student Permit";
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

  class DriverLicense {
    private string $licenseNumber;
    private LicenseStatus $licenseStatus;
    private LicenseType $licenseType;
    private DateTime $issueDate;
    private ExpiryOption $expiryOption;
    private DateTime $expiryDate;
    private array $dlCodes;
    private Person|int $person;

    public function __construct(
      string $licenseNumber,
      LicenseStatus $licenseStatus,
      LicenseType $licenseType,
      DateTime $issueDate,
      ExpiryOption $expiryOption,
      array $dlCodes,
      Person|int $person
    ) {
      $this->licenseNumber = $licenseNumber;
      $this->licenseStatus = $licenseStatus;
      $this->licenseType = $licenseType;
      $this->issueDate = $issueDate;
      $this->expiryOption = $expiryOption;
      $this->dlCodes = $dlCodes;
      $this->person = $person;

      $this->expiryDate = clone $this->issueDate;
      $this->expiryDate->add($this->expiryOption->getInterval());
    }

    public function setLicenseNumber(string $licenseNumber): void {
      $this->licenseNumber = $licenseNumber;
    }

    public function setLicenseStatus(LicenseStatus $licenseStatus): void {
      $this->licenseStatus = $licenseStatus;
    }

    public function setLicenseType(LicenseType $licenseType): void {
      $this->licenseType = $licenseType;
    }

    public function setIssueDate(DateTime $issueDate): void {
      $this->issueDate = $issueDate;
    }

    public function setDLCodes(array $dlCodes): void {
      $this->dlCodes = $dlCodes;
    }

    public function setPerson(Person|int $person): void {
      $this->person = $person;
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

    public function getPerson(): Person|int {
      return $this->person;
    }
    
    public function getDLCodesToString(): string {
      $str = "";
      foreach ($this->dlCodes as $code) {
          $str .= $code->value . ", ";
      }
      return rtrim($str, ", ");
    }

    public function getPersonId(): int {
      if ($this->person instanceof Person) {
        if ($this->person->getPersonId() === null) {
          throw new Exception("Person object does not have a personId set.");
        }
        return $this->person->getPersonId();
      }
      return $this->person; // already an int
    }

    public function displayDLInfo(): string {
      return
      "
        License Number: {$this->getLicenseNumber()} <br>
        License Status: {$this->getLicenseStatus()->value} <br>
        License Type: {$this->getLicenseType()->value} <br>
        Issue Date: {$this->getIssueDate()->format("F j, Y")} <br>
        Expiry Date: {$this->getExpiryDate()->format("F j, Y")} <br>
        DL Codes: {$this->getDLCodesToString()} <br> <br>

        <strong>Personal Information</strong> <br>
        First Name: {$this->getPerson()->getFirstName()} <br>
        Middle Name: {$this->getPerson()->getMiddleName()} <br>
        Last Name: {$this->getPerson()->getLastName()} <br>
        Date Of Birth: {$this->getPerson()->getDateOfBirth()->format("F j, Y")} <br>
        Sex: {$this->getPerson()->getGender()->value} <br>
        Address: {$this->getPerson()->getAddress()} <br>
      ";
    }

    public function save(mysqli $conn): bool {
      $stmt = $conn->prepare("
        INSERT INTO driver_licenses 
        (license_number, license_status, license_type, issue_date, expiry_date, dl_codes, person_id)
        VALUES (?, ?, ?, ?, ?, ?, ?)
      ");

      if (!$stmt) {
        echo "Prepare failed: {$conn->error}";
        return false;
      }

      $licenseNumber = $this->licenseNumber;
      $licenseStatus = $this->licenseStatus->value;   // READ the enum value
      $licenseType   = $this->licenseType->value;     // READ the enum value
      $issueDate     = $this->issueDate->format("Y-m-d");
      $expiryDate    = $this->expiryDate->format("Y-m-d");
      $dlCodes       = $this->getDLCodesToString();
      $personId      = $this->getPersonId();

      $stmt->bind_param(
        "ssssssi",
        $licenseNumber,
        $licenseStatus,
        $licenseType,
        $issueDate,
        $expiryDate,
        $dlCodes,
        $personId
      );

      return $stmt->execute();
    }

  }
?>