<?php
class Category extends DBParent{
    public string $name = "";  

    public function add($name){
        $sql = "INSERT INTO $this->table (name, isDeleted) VALUES (:name, 0)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
    }

    public function update($id, $name){
        $sql = "UPDATE  $this->table SET name = :name WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
    }

    public function getByName($name){
        $sql = "SELECT * FROM  $this->table WHERE name = :name AND isDeleted = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!$result)
            return null;
        
        $category = new Category();
        $category->id = $result['id'];
        $category->name = $result['name'];
        return $category;
    }
}
?>