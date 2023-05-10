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

// Get the HTTP method and filters (if any)
$method = $_SERVER['REQUEST_METHOD'];
$date = isset($_GET['date']) ? $_GET['date'] : '';
$category = isset($_GET['category']) && $_GET['category'] != -1 ? $_GET['category'] : '';
$city = isset($_GET['city']) && $_GET['city'] != -1 ? $_GET['city'] : '';

if ($method == 'GET') {
    $result = $event->filterEvents($date, $category, $city);

    if (!empty($result)) {
        echo json_encode($result);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'No events found']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
}
?>