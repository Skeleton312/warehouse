<?php 
class Gudang {
    private $conn;
    private $table_name = "gudang";

    public $id;
    public $name;
    public $capacity;
    public $location;
    public $status;
    public $openTime;
    public $closeTime;


    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        $stmt = $this->conn->prepare("INSERT INTO ". $this->table_name ." (name, location, capacity, status, opening_hour, closing_hour) VALUES (:name, :location, :capacity, :status, :opening_hour, :closing_hour)");

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":capacity", $this->capacity);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":opening_hour", $this->openTime);
        $stmt->bindParam(":closing_hour", $this->closeTime);
        
        if ($stmt->execute()) {
            return true;
        }

        return false;

    }

    public function read(){
        $stmt = $this->conn->prepare("SELECT id, name, location, capacity, status, opening_hour, closing_hour FROM ". $this->table_name);
        $stmt->execute();

        return $stmt;
    }

    public function show($id){
        $stmt = $this->conn->prepare("SELECT id, name, location, capacity, status, opening_hour, closing_hour FROM ". $this->table_name ." WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt;
    }

    public function update(){
        $stmt = $this->conn->prepare("UPDATE ". $this->table_name ." SET name=:name, location=:location, capacity=:capacity, status=:status, closing_hour=:closing_hour, opening_hour=:opening_hour WHERE id=:id");

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":capacity", $this->capacity);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":opening_hour", $this->openTime);
        $stmt->bindParam(":closing_hour", $this->closeTime);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete(){
        $stmt = $this->conn->prepare("DELETE FROM ". $this->table_name ." WHERE id=:id");
        $stmt->bindParam(":id", $this->id);
        if ($stmt->execute()) {
            return true;
        }   

        return false;
    }
    public function paginasi($start, $limit) {
        $query = "SELECT id, name, location, capacity, status, opening_hour, closing_hour FROM " . $this->table_name . " LIMIT ?, ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $start, PDO::PARAM_INT);
        $stmt->bindParam(2, $limit, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt;
    }
    
}

?>