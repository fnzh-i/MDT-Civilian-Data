<?php
require_once __DIR__ . '/../bootstrap.php';

class TicketViolation
{
  private Violation $violation;
  private DateTime $dateOfIncident;
  private string $placeOfIncident;
  private ViolationStatus $violationStatus;
  private string $note;
  //private int $licenseID; wala muna dapat sa obj creation
  private ?int $ticketID = null;

  public function __construct(
    Violation $violation,
    DateTime $dateOfIncident,
    string $placeOfIncident,
    string $note,
    ViolationStatus $violationStatus = ViolationStatus::UNSETTLED // unsettled na agad upon ticket obj creation
    //int $licenseID wala muna dapat sa obj creation
  ) {
    $this->violation = $violation;
    $this->dateOfIncident = $dateOfIncident;
    $this->placeOfIncident = $placeOfIncident;
    $this->note = $note;
    $this->violationStatus = $violationStatus;
    // $this->licenseID = $licenseID; wala muna dapat sa obj creation
  }

  public function setViolationStatus(ViolationStatus $violationStatus): void
  {
    $this->violationStatus = $violationStatus;
  }

  public function getViolation(): Violation
  {
    return $this->violation;
  }

  public function getDateOfIncident(): DateTime
  {
    return $this->dateOfIncident;
  }

  public function getPlaceOfIncident(): string
  {
    return $this->placeOfIncident;
  }

  public function getViolationStatus(): ViolationStatus
  {
    return $this->violationStatus;
  }

  public function getNote(): string
  {
    return $this->note;
  }

  public function getTicketID(): ?int
  {
    return $this->ticketID;
  }

  // public function getLicenseID(): int{
  //   return $this->licenseID;
  // }

  public static function fromDatabase(array $row): self
  {
    $ticket = new self(
      Violation::from($row['violation']),
      new DateTime($row['date_of_incident']),
      $row['place_of_incident'],
      $row['note'] ?? '',
      ViolationStatus::from($row['status'])
    );

    // assign the primary key AFTER creating the object
    $ticket->ticketID = (int) $row['ticket_id'];

    return $ticket;
  }

      // I CHECHECK MUNA IF EXISTING YUNG LICENSE_ID, YES PARANG REDUNDANT SYA
      // PERO KASI GAGAMITIN KO RIN ITONG SAVE FUNCTION SA ADMIN CREATE TICKET
      // PARA DI NA AKO GUMAWA PA NG ANOTHER FUNCTION
      $check = $conn->prepare("SELECT license_id FROM licenses WHERE license_id = ?");
      if (!$check) {
        return "Prepare failed: " . $conn->error;
      }

      $check->bind_param("i", $licenseID);
      $check->execute();
      $res = $check->get_result();

      if ($res->num_rows === 0) {
        return "Error: license_id {$licenseID} does not exist.";
      }

      $check->close();


      // DITO NA YUNG START NG ACTUAL SAVING SA ticket_violations
      $sql = "INSERT INTO ticket_violations 
        (violation, date_of_incident, place_of_incident, status, note, license_id)
        VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
      return "Prepare failed: " . $conn->error;
    }

    // galing sa nagawang TicketViolation obj
    $violation = $this->getViolation()->value;
    $dateOfIncident = $this->getDateOfIncident()->format('Y-m-d');
    $placeOfIncident = $this->getPlaceOfIncident();
    $status = $this->getViolationStatus()->value;
    $note = $this->getNote();

    // binding the parameters
    $stmt->bind_param(
      "sssssi",
      $violation,
      $dateOfIncident,
      $placeOfIncident,
      $status,
      $note,
      $licenseID
    );

    // execute tapos return sa ticketAPI
    if ($stmt->execute()) {
      return true;
    }

    return "Error saving ticket: " . $stmt->error;
  }


  // DELETE TICKET
  public static function delete(mysqli $conn, int $ticketID): bool|string
  {
    $sql = "DELETE FROM ticket_violations WHERE ticket_id = $ticketID";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      return true;
    } else {
      return "Error deleting ticket: " . mysqli_error($conn);
    }
  }

  // UPDATE TICKET (EITHER TO SETTLED OR PWEDE RING UNSETTLED)
  public static function updateStatus(mysqli $conn, int $ticketID, ViolationStatus $newStatus): bool|string
  {
    $sql = "UPDATE ticket_violations 
        SET status = '{$newStatus->value}' 
        WHERE ticket_id = $ticketID";

    $result = mysqli_query($conn, $sql);

    if ($result) {
      return true;
    } else {
      return "Error updating ticket status: " . mysqli_error($conn);
    }
  }

  // FETCH TICKETS BY STATUS (SETTLED / UNSETTLED)
  public static function fetchByStatus(mysqli $conn, int $licenseID, ViolationStatus $status): array|string
  {
    $sql = "SELECT * FROM ticket_violations 
        WHERE license_id = $licenseID 
        AND status = '{$status->value}' 
        ORDER BY date_of_incident DESC";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
      return "Error fetching tickets: " . mysqli_error($conn);
    }

    $tickets = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $tickets[] = self::fromDatabase($row);
    }

    return $tickets;
  }


  // public function save(mysqli $conn, int $license_id): string | bool {
  //   $checkStmt = $conn->prepare("SELECT license_id FROM licenses WHERE license_id = ?");
  //   $checkStmt->bind_param("i", $license_id);
  //   $checkStmt->execute();

  //   $result = $checkStmt->get_result();

  //   if ($result->num_rows === 0) {
  //     $checkStmt->close();
  //     return "Error: License ID $license_id not found in licenses table.";
  //   }

  //   $checkStmt->close();

  //   $stmt = $conn->prepare("
  //     INSERT INTO ticket_violations(violation, date_of_incident, place_of_incident, status, license_id)
  //     VALUES (?, ?, ?, ?, ?)
  //   ");

  //   $violation = $this->getViolation()->value;
  //   $dateOfIncident = $this->getDateOfIncident()->format("Y-m-d H:i:s");
  //   $placeOfIncident = $this->getPlaceOfIncident();
  //   $violationStatus = $this->getViolationStatus()->value;

  //   $stmt->bind_param(
  //     "ssssi",
  //     $violation,
  //     $dateOfIncident,
  //     $placeOfIncident,
  //     $violationStatus,
  //     $license_id
  //   );

  //   if (!$stmt->execute()) {
  //     $error = "Database error: {$stmt->error}";
  //     $stmt->close();
  //     return $error;
  //   }

  //   $stmt->close();
  //   return true;
  // }
}
?>