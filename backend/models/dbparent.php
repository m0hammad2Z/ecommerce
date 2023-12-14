<?php

Class DBParent{
    public int $id = 0;
    public bool $isDeleted = false;
    public string $table = "";

    protected $conn;

    function __construct()
    {   

        $this->table = strtolower(get_class($this)) . "s";
        
        $this->conn = Connect::makeConnection();
        

        // Create table if not exists
        $sql = "";
        $sql .= "create table if not exists " . $this->table . " (";
        $sql .= "id int auto_increment PRIMARY KEY,";
        foreach($this as $key => $value){
            if($key == "id" || $key == "isDeleted" || $key == "table" || $key == "conn")
                continue;

            $type = "varchar(255)";

            if(gettype($value) == "integer")
                $type = "int";
            else if(gettype($value) == "double")
                $type = "float";
            else if(gettype($value) == "boolean")
                $type = "boolean";
            else if(gettype($value) == "array")
                $type = "json";

            $sql .= $key . " " . $type . ",";
        }
        $sql .= "isDeleted boolean not null default false";
        $sql .= ");";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    }



    public function getById($id){
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id AND isDeleted = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!$result)
            return null;
        
        $object = new $this;
        foreach($result as $key => $value){
            if(gettype($object->$key) == "array")
                $object->$key = json_decode($value);
            else
                $object->$key = $value;
        }
        return $object;
    }

    public function getAll(){
        $sql = "SELECT * FROM " . $this->table . " WHERE isDeleted = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if(!$result)
            return null;
        
        $objects = array();
        foreach($result as $row){
            $object = new $this;
            foreach($row as $key => $value){
                if(gettype($object->$key) == "array")
                    $object->$key = json_decode($value);
                else
                    $object->$key = $value;
            }
            array_push($objects, $object);
        }
        return $objects;
    }

    public function delete($id){
        $sql = "UPDATE " . $this->table . " SET isDeleted = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    // Perform a any query
    public function query($sql){
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if(!$result)
            return null;
        
        $objects = array();
        foreach($result as $row){
            $object = new $this;
            foreach($row as $key => $value){
                $object->$key = $value;
            }
            array_push($objects, $object);
        }
        return $objects;
    }


}

?>