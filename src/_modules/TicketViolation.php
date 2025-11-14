<?php
  require_once "DBConnect.php";

  enum Violation: string {
    case ILLEGAL_PARKING = "ILLEGAL PARKING";
    case RECKLESS_DRIVING = "RECKLESS DRIVING";
    case DISOBEYING_TRAFFIC_SIGNS = "DISOBEYING TRAFFIC SIGNS";
    case OVERSPEEDING = "OVERSPEEDING";
    case DRIVING_UNDER_INFLUENCE = "DRIVING UNDER INFLUENCE";
    case OBSTRUCTION = "OBSTRUCTION";
    case NO_DRIVER_LICENSE = "NO DRIVER LICENSE";
    case EXPIRED_LICENSE = "EXPIRED DRIVER LICENSE";
    case UNREGISTERED_VEHICLE = "UNREGISTERED VEHICLE";
    case NO_OR_CR = "NO OR/CR";
    case NUMBER_CODING = "NUMBER CODING";
    case NO_HELMET = "NO HELMET";
    case NO_SEATBELT = "NO SEATBELT";
  }

  enum ViolationStatus: string {
    case SETTLED = "SETTLED";
    case UNSETTLED = "UNSETTLED";
  }

  class TicketViolation {
    private Violation $violation;
    private DateTime $dateOfIncident;
    private string $placeOfIncident;
    private ViolationStatus $violationStatus;

    public function __construct(
      Violation $violation,
      DateTime $dateOfIncident,
      string $placeOfIncident,
      ViolationStatus $violationStatus
      ) {
      $this->violation = $violation;
      $this->dateOfIncident = $dateOfIncident;
      $this->placeOfIncident = $placeOfIncident;
      $this->violationStatus = $violationStatus;
    }

    public function setViolationStatus(ViolationStatus $violationStatus): void {
      $this->violationStatus = $violationStatus;
    }

    public function getViolation(): Violation {
      return $this->violation;
    }

    public function getDateOfIncident(): DateTime {
      return $this->dateOfIncident;
    }

    public function getPlaceOfIncident(): string {
      return $this->placeOfIncident;
    }

    public function getViolationStatus(): ViolationStatus {
      return $this->violationStatus;
    }

    public function displayInfo(): string {
      return
      "
        Violation: {$this->getViolation()->value} <br>
        Date Of Incident: {$this->getDateOfIncident()->format("F j, Y g:i A")} <br>
        Place Of Incident: {$this->getPlaceOfIncident()} <br>
        Status: {$this->getViolationStatus()->value} <br> <br>
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
        INSERT INTO ticket_violations(violation, date_of_incident, place_of_incident, status, license_id)
        VALUES (?, ?, ?, ?, ?)
      ");

      $violation = $this->getViolation()->value;
      $dateOfIncident = $this->getDateOfIncident()->format("Y-m-d H:i:s");
      $placeOfIncident = $this->getPlaceOfIncident();
      $violationStatus = $this->getViolationStatus()->value;

      $stmt->bind_param(
        "ssssi",
        $violation,
        $dateOfIncident,
        $placeOfIncident,
        $violationStatus,
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
  }
?>