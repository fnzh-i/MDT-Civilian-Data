<?php
require_once __DIR__ . '/../bootstrap.php';

class TicketAPI {

    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // FETCH TICKETS
    public function fetchTickets(int $licenseID, ?string $status): string {

        if ($status !== null) {
            try {
                $violationStatus = ViolationStatus::from($status);
            } catch (ValueError $e) {
                return json_encode(['status' => 'error', 'message' => 'Invalid status value.']);
            }

            $tickets = TicketViolation::fetchByStatus($this->conn, $licenseID, $violationStatus);
        } else {
            $sql = "SELECT * FROM ticket_violations WHERE license_id = $licenseID ORDER BY date_of_incident DESC";
            $result = mysqli_query($this->conn, $sql);

            if (!$result) {
                return json_encode(['status' => 'error', 'message' => mysqli_error($this->conn)]);
            }

            $tickets = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $tickets[] = TicketViolation::fromDatabase($row);
            }
        }

        $response = [];
        foreach ($tickets as $ticket) {
            $response[] = [
                'ticket_id' => $ticket->getTicketID(),
                'violation' => $ticket->getViolation()->value,
                'date_of_incident' => $ticket->getDateOfIncident()->format('M-d-Y'),
                'place_of_incident' => $ticket->getPlaceOfIncident(),
                'status' => $ticket->getViolationStatus()->value,
                'note' => $ticket->getNote()
            ];
        }

        return json_encode(['status' => 'success', 'tickets' => $response]);
    }

    // CREATE TICKET
    public function createTicket(array $data): string {

        try {
            $violation = Violation::from($data['violation']);
        } catch (ValueError $e) {
            return json_encode(['status' => 'error', 'message' => 'Invalid violation.']);
        }

        try {
            $dateOfIncident = new DateTime($data['date_of_incident']);
        } catch (Exception $e) {
            return json_encode(['status' => 'error', 'message' => 'Invalid date format.']);
        }

        $ticket = new TicketViolation(
            $violation,
            $dateOfIncident,
            $data['place_of_incident'],
            $data['note'] ?? ''
        );

        $result = $ticket->save($this->conn, $data['license_id']);

        if ($result === true) {
            return json_encode(['status' => 'success', 'message' => 'Ticket created.']);
        }
        return json_encode(['status' => 'error', 'message' => $result]);
    }

    // UPDATE STATUS
    public function updateTicketStatus(int $ticketID, string $status): string {

        try {
            $newStatus = ViolationStatus::from($status);
        } catch (ValueError $e) {
            return json_encode(['status' => 'error', 'message' => 'Invalid status.']);
        }

        $result = TicketViolation::updateStatus($this->conn, $ticketID, $newStatus);

        if ($result === true) {
            return json_encode(['status' => 'success', 'message' => 'Ticket updated.']);
        }
        return json_encode(['status' => 'error', 'message' => $result]);
    }

    // DELETE TICKET
    public function deleteTicket(int $ticketID): string {

        $result = TicketViolation::delete($this->conn, $ticketID);

        if ($result === true) {
            return json_encode(['status' => 'success', 'message' => 'Ticket deleted.']);
        }
        return json_encode(['status' => 'error', 'message' => $result]);
    }
}
