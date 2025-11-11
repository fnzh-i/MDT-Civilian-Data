<?php
  require_once "DBConnect.php";

  enum Gender: string {
    case MALE = "Male";
    case FEMALE = "Female";
  }

  class Person {
    private string $firstName;
    private ?string $middleName;
    private string $lastName;
    private DateTime $dateOfBirth;
    private Gender $gender;
    private string $address;

    public function __construct(
      string $firstName,
      ?string $middleName,
      string $lastName,
      DateTime $dateOfBirth,
      Gender $gender,
      string $address,
    ) {
      $this->firstName = $firstName;
      $this->middleName = $middleName;
      $this->lastName = $lastName;
      $this->dateOfBirth = $dateOfBirth;
      $this->gender = $gender;
      $this->address = $address;
    }

    public function setFirstName(string $firstName): void {
      $this->firstName = $firstName;
    }

    public function setMiddleName(?string $middleName): void {
      $this->middleName = $middleName;
    }

    public function setLastName(string $lastName): void {
      $this->lastName = $lastName;
    }

    public function setDateofBirth(DateTime $dateOfBirth): void {
      $this->dateOfBirth = $dateOfBirth;
    }

    public function setGender(Gender $gender): void {
      $this->gender = $gender;
    }

    public function setAddress(string $personAddress): void {
      $this->address = $personAddress;
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

    public function displayPersonInfo(): string {
      return
      "
        First Name: {$this->getFirstName()} <br>
        Middle Name: {$this->getMiddleName()} <br>
        Last Name: {$this->getLastName()} <br>
        Date Of Birth: {$this->getDateOfBirth()->format("F j, Y")} <br>
        Sex: {$this->getGender()->value} <br>
        Address: {$this->getAddress()} <br>
      ";
    }

    public function save(mysqli $conn): bool {
      $stmt = $conn->prepare("
        INSERT INTO persons (first_name, middle_name, last_name, date_of_birth, gender, address)
        VALUES (?, ?, ?, ?, ?, ?)
      ");

      $firstName = $this->getFirstName();
      $middleName = $this->getMiddleName();
      $lastName = $this->getLastName();
      $dateOfBirth = $this->getDateOfBirth()->format("Y-m-d");
      $gender = $this->getGender()->value;
      $address = $this->getAddress();

      $stmt->bind_param(
        "ssssss",
        $firstName,
        $middleName,
        $lastName,
        $dateOfBirth,
        $gender,
        $address
      );

      return $stmt->execute();
    }

    public static function fetchById(mysqli $conn, int $personId): ?Person {
      $stmt = $conn->prepare("SELECT * FROM persons WHERE person_id = ?");
      $stmt->bind_param("i", $personId);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($row = $result->fetch_assoc()) {
          return new Person(
              $row['first_name'],
              $row['middle_name'] ?: null,
              $row['last_name'],
              new DateTime($row['date_of_birth']),
              Gender::from($row['gender']),
              $row['address'],
          );
      }

      return null; // no person found
    }
  }
?>