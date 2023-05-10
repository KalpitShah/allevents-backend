<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/City.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate city object
$city = new City($db);

// City query
$result = $city->readAll();
// Get row count
$num = $result->rowCount();

// Check if any cities
if ($num > 0) {
    // City array
    $cities_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $city_item = array(
            'id' => $id,
            'name' => $name,
            'slug' => $slug
        );

        // Push to "data"
        array_push($cities_arr, $city_item);
    }

    // Turn to JSON & output
    echo json_encode($cities_arr);

} else {
    // No Cities
    echo json_encode(
        array('message' => 'No Cities Found')
    );
}