<?php 

 
class Product extends DBParent{
    public string $name = "";    
    public float $price = 0.0;
    public string $description = "";
    public int $categoryId = 0;  
    public int $stock = 0;

    public function __construct(){
        parent::__construct("products");
        Constraints::addForignKey("products", "categoryId", "categorys", "id");
    }


    public function add($name, $price, $description, $categoryId, $stock){
        $sql = "INSERT INTO $this->table (name, price, description, categoryId, stock, isDeleted) VALUES (:name, :price, :description, :categoryId, :stock, 0)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':categoryId', $categoryId);
        $stmt->bindParam(':stock', $stock);
        $stmt->execute();
    }

    public function update($id, $name, $price, $description, $categoryId, $stock){
        $sql = "UPDATE $this->table SET name = :name, price = :price, description = :description, categoryId = :categoryId, stock = :stock WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':categoryId', $categoryId);
        $stmt->bindParam(':stock', $stock);
        $stmt->execute();
    }

    public function getByCategoryId($categoryId){
        $sql = "SELECT * FROM $this->table WHERE categoryId = :categoryId AND isDeleted = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':categoryId', $categoryId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!$result)
            return null;

        $products = array();
        foreach($result as $row){
            $product = new Product();
            $product->id = $row['id'];
            $product->name = $row['name'];
            $product->price = $row['price'];
            $product->description = $row['description'];
            $product->categoryId = $row['categoryId'];
            $product->stock = $row['stock'];
            $product->isDeleted = $row['isDeleted'];
            array_push($products, $product);
        }

        return $products;
    }
}


?>