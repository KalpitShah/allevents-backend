<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PUT, PATCH, GET, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Api-Key, X-Requested-With, Content-Type, Accept, Authorization");

// Import required classes
require_once '../../models/User.php';
require_once '../../config/Database.php';

// Initialize the database connection
$db = new Database();
$conn = $db->connect();

// Initialize User
$user = new User($conn);

// Get the HTTP method
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST' || $method == 'OPTIONS') {
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    $user->user_id = $data->user_id;
    $user->name = $data->name;
    $user->email = $data->email;
    $user->image_url = $data->image_url;

    if ($user->create()) {
        http_response_code(201);
        echo json_encode(['message' => 'User created successfully']);
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'User could not be created']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
}