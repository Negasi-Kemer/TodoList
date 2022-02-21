<?php
//Headers
header('Access-Allow-Control-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Todo.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate todo object
$todo = new Todo($db);

// Get Todo ID
$todo->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get todo
$result = $todo->read_single();
if ($result) {
    // Create array 
$todo_array = array(
    'id' => $todo->id,
    'title' => $todo->title,
    'description' => $todo->description, // removes html elements from the text
    'date' => $todo->date,
    'time' => $todo->time,
    'status' => $todo->status
);

// Turn to array 
print_r(json_encode($todo_array));
} else {
    // No todos found\
    echo json_encode(
        array('message' => "No todo found by the specified id")
    );
}


