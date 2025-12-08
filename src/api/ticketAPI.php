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

    // CREATE TICKET (GINAGAMIT BOTH SA USER AND SA ADMIN)
    public function createTicket(array $data): string {
        // DETERMINE IF SA USER (TRAFFIC ENFORCER) OR ADMIN BA YUNG REQUEST
        $licenseID = null;

        // USER WORKFLOW (passes license_id)
        if (isset($data['license_id'])) {
            $licenseID = (int)$data['license_id'];
        }
        // ADMIN WORKFLOW (passes license_number)
        else if (isset($data['license_number'])) {

            $licenseNumber = $data['license_number'];

            $stmt = $this->conn->prepare(
                "SELECT license_id FROM licenses WHERE license_number = ?"
            );
            if (!$stmt) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Prepare failed: ' . $this->conn->error
                ]);
            }

            $stmt->bind_param("s", $licenseNumber);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows === 0) {
                return json_encode([
                    'status' => 'error',
                    'message' => "License number '{$licenseNumber}' not found."
                ]);
            }

            $row = $res->fetch_assoc();
            $licenseID = (int)$row['license_id'];

            $stmt->close();
        }
        else {
            return json_encode([
                'status' => 'error',
                'message' => 'You must provide license_id (user) or license_number (admin).'
            ]);
        }


        // VIOLATION CHECKER
        try {
            $violation = Violation::from($data['violation']);
        } catch (ValueError $e) {
            return json_encode([
                'status' => 'error',
                'message' => 'Please input a valid violation.'
            ]);
        }


        // CHECK IF EMPTY DATE OF INCIDENT
        $dateOfIncident = $data['date-of-incident'] ?? '';
        if (trim($dateOfIncident) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please input the date of incident.'
            ]);
        }

        // CHECK IF EMPTY PLACE OF INCIDENT
        $placeOfIncident = $data['place-of-incident'] ?? '';
        if (trim($placeOfIncident) === '') {
            return json_encode([
                'status' => 'error',
                'message' => 'Please enter the place of incident.'
            ]);
        }


        // CREATE TicketViolation OBJECT
        $ticket = new TicketViolation(
            $violation,
            new DateTime($dateOfIncident),
            $placeOfIncident,
            $data['note'] ?? ''
        );

        // SAVE
        $result = $ticket->save($this->conn, $licenseID);

        if ($result === true) {
            return json_encode([
                'status' => 'success',
                'message' => 'Ticket created.'
            ]);
        }

        return json_encode([
            'status' => 'error',
            'message' => $result
        ]);
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
