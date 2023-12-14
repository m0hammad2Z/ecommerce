<?php
class Image extends DBParent{
    public int $productId = 0; 
    public string $path = "";

    function __construct()
    {   
        parent::__construct();
        Constraints::addForignKey($this->table, 'productId', 'products', 'id');
    }

    public function add($productId, $path){
        $sql = "INSERT INTO $this->table (productId, path, isDeleted) VALUES (:productId, :path, 0)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':productId', $productId);
        $stmt->bindParam(':path', $path);
        $stmt->execute();
    }

    public function update($id, $productId, $path){
        $sql = "UPDATE $this->table SET productId = :productId, path = :path WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':productId', $productId);
        $stmt->bindParam(':path', $path);
        $stmt->execute();
    }

    public function getByProductId($productId){
        $sql = "SELECT * FROM $this->table WHERE productId = :productId AND isDeleted = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if(!$result)
            return null;
        
        $images = array();
        foreach($result as $row){
            $image = new Image();
            $image->id = $row['id'];
            $image->productId = $row['productId'];
            $image->path = $row['path'];
            array_push($images, $image);
        }
        return $images;
    }

    public function getByPath($path){
        $sql = "SELECT * FROM $this->table WHERE path = :path AND isDeleted = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':path', $path);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!$result)
            return null;
        
        $image = new Image();
        $image->id = $result['id'];
        $image->productId = $result['productId'];
        $image->path = $result['path'];
        return $image;
    }

}
?>