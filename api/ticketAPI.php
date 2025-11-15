<?php
require_once __DIR__ . '/../src/bootstrap.php';

header('Content-Type: application/json');

$response = [];

if ($conn) {
    $sql = "SELECT * FROM ticket_violations";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $tickets = [];

        while ($row = mysqli_fetch_assoc($result)) {
            
            $ticket = TicketViolation::fromDatabase($row);

            $tickets[] = [
                'ticket_id' => $row['ticket_id'],
                'violation' => $ticket->getViolation(),
                'date_of_incident' => $ticket->getDateOfIncident()->format('M-d-Y'),
                'place_of_incident' => $ticket->getPlaceOfIncident(),
                'status' => $ticket->getViolationStatus(),
                'note' => $ticket->getNote(),
                'license_id'=> $ticket->getLicenseID(),
            ];
        }
        echo json_encode(['tickets' => $tickets], JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch vehicles from database.']);
    }
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed.']);
}