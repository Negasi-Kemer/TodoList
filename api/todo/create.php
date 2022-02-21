<?php
//Headers
header('Access-Allow-Control-Origin: *');
header('Content-Type: application/json');
header('Acces-Allow-Control-Methods: POST');
header('Acces-Allow-Control-Headers: Acces-Allow-Control-Headers, Content-Type, Acces-Allow-Control-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Todo.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate todo object
$todo = new Todo($db);

// Get raw todo data
$todoData = json_decode(file_get_contents("php://input"));

// Assing value to the Todo object
$todo->title = $todoData->title;
$todo->description = $todoData->description;
$todo->date = $todoData->date;
$todo->time = $todoData->time;
$todo->status = $todoData->status;
echo "Values assigned as: ".$todo->description;
//Create Todo
if ($todo->create()) {
    echo json_encode(
        array('message' => 'Todo Created')
    );
}else{
    echo json_encode( array('message' => 'Opps todo not created'));
}