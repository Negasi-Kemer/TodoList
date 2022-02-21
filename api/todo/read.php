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

// Todo query
$result = $todo->read();

//Get row count
$num = $result->rowCount();

// Check if any todo
if ($num >0) {
    $todoArray = array();
    $todoArray['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $todoItem = array(
            'id' => $id,
            'title' => $title,
            'description' => html_entity_decode($description), // removes html elements from the text
            'todoDate' => $todoDate,
            'todoTime' => $todoTime,
            'status' => $status
        );

        // Push to "data"
        array_push($todoArray['data'], $todoItem);
    }

    // Turn to JSON and print
    echo json_encode($todoArray);
}else{
    // No todos found\
    echo json_encode(
        array('message' => "No todos found")
    );
}
