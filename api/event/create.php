<?php
// Headers

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Max-Age: 60');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: AccountKey,x-requested-with, Content-Type, origin, authorization, accept, client-security-token, host, date, cookie, cookie2");

// Import required classes
require_once '../../models/Event.php';
require_once '../../models/City.php';
require_once '../../config/Database.php';

// Initialize the database connection
$db = new Database();
$conn = $db->connect();

// Initialize Event and City
$event = new Event($conn);
$city = new City($conn);

// Get the HTTP method
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST' || $method == 'OPTIONS') {
    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $city->name = $data->city;
    $city_id = $city->findOrCreate();

    $event->name = $data->name;
    $event->start_time = $data->start_time;
    $event->end_time = $data->end_time;
    $event->description = $data->description;
    $event->category_id = $data->category;
    $event->city_id = $city_id;
    $event->location = $data->location;
    $event->banner_image = $data->banner_image;
    $event->user_id = $data->user_id;

    // Create Event
    $new_event = $event->create();
    if ($new_event) {
        http_response_code(201);
        echo json_encode($new_event);
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Event Not Created']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
}