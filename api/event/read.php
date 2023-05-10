<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Import required classes
require_once '../../models/Event.php';
require_once '../../config/Database.php';

// Initialize the database connection
$db = new Database();
$conn = $db->connect();

// Initialize Event
$event = new Event($conn);

// Get the HTTP method and event_id (if any)
$method = $_SERVER['REQUEST_METHOD'];
$event_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($method == 'GET') {
    if ($event_id) {
        // If event_id is set, read the specific event
        $event->event_id = $event_id;
        $result = $event->readSingle();

        if ($result) {
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Event not found']);
        }
    } else {
        // If event_id is not set, read all events
        $result = $event->readAll();

        if (count($result) > 0) {
            http_response_code(201);
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'No events found']);
        }
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
}
?>