<?php
class Todo{
    
    // Some DB stuff
    private $conn;
    private $table = 'todolist';
    
    // Todo properties
    public $id;
    public $title;
    public $description;
    public $date;
    public $time;
    public $status;

    // Constructor with database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get/Read todos
    public function read(){
        // Create query
        $query = 'SELECT 
                    td.id,
                    td.title,
                    td.description,
                    td.date,
                    td.time,
                    td.status
                    FROM 
                    '.$this->table.' td';
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get/read single todo by id
    public function read_single(){
        // Create query
        $query = 'SELECT 
                    td.id,
                     td.title,
                    td.description,
                    td.date,
                    td.time,
                    td.status
                    FROM 
                    '.$this->table.' td 
                    WHERE 
                    td.id = ?
                    LIMIT 0,1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind param
        $stmt->bindParam(1, $this->id);

        // Execute the query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check the row is not empty
        if ($row) {
            // Set properties
            $this->title = $row['title'];
            $this->description = $row['description'];
            $this->date = $row['date'];
            $this->time = $row['time'];
            $this->status = $row['status']; 
            echo "Status is: ".$row['status'];
        } else {
            echo "Opps...No Todo Found";
        }
        return $row;
    }

    // Create Todo
    public function create(){
        $query = 'INSERT INTO '.
                $this->table .
                'SET 
                    title = :title,
                    description = :description,
                    date = :date,
                    time = :time,
                    status = :status ';
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->time = htmlspecialchars(strip_tags($this->time));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind named parameters
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':time', $this->time);
        $stmt->bindParam(':status', $this->status);
        echo "To be insterted as: ". $this->description;  
        //Execute query
        try {
            $stmt->execute();
            // if ($stmt->execute()) {
            //     return true;
            // }else{
            //     echo "Not Executed";
            // }
        } catch (PDOException $e) {
            echo "DB error: ".$e->getMessage();
        }

        // Print error if something goes wrong
        printf("Error: %s .\n", $stmt->error);

        return false;
        
    }
}