<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Import required classes
require_once '../../models/User.php';
require_once '../../config/Database.php';

// Initialize the database connection
$db = new Database();
$conn = $db->connect();

// Initialize User
$user = new User($conn);

// Get the HTTP method and user_id (if any)
$method = $_SERVER['REQUEST_METHOD'];
$user_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($method == 'GET') {
    if ($user_id) {
        // If user_id is set, read the specific user
        $user->user_id = $user_id;
        $result = $user->read_single();

        if ($result) {
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'User not found']);
        }
    } else {
        // If user_id is not set, read all users
        $result = $user->read();

        if ($result->rowCount() > 0) {
            $users_arr = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                array_push($users_arr, $row);
            }
            echo json_encode($users_arr);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'No users found']);
        }
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
}