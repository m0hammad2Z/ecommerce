<?php

class Transaction extends DBParent{
    public int $userId = 0; 
    public float $totalPrice = 0; 
    public array $orders = array();      
    public string $status = "";  

    public function __construct(){
        parent::__construct("transactions");
        Constraints::addForignKey("transactions", "userId", "users", "id");
    }

    public function add($userId, $totalPrice, $orders, $status){ 
        try{
            $orders = json_encode($orders);
            $sql = "INSERT INTO $this->table (userId, totalPrice, orders, status, isDeleted) VALUES (:userId, :totalPrice, :orders, :status, 0)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':totalPrice', $totalPrice);
            $stmt->bindParam(':orders', $orders);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function update($id, $userId, $totalPrice, $orders, $status){
        try{
            $orders = json_encode($orders);
            $sql = "UPDATE $this->table SET userId = :userId, totalPrice = :totalPrice, orders = :orders, status = :status WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':totalPrice', $totalPrice);
            $stmt->bindParam(':orders', $orders);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getByUserId($userId){
        $sql = "SELECT * FROM $this->table WHERE userId = :userId AND isDeleted = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if(!$result)
            return null;
        
        $transactions = array();
        foreach($result as $row){
            $transaction = new Transaction();
            $transaction->id = $row['id'];
            $transaction->userId = $row['userId'];
            $transaction->totalPrice = $row['totalPrice'];
            $transaction->orders = json_decode($row['orders']);
            $transaction->status = $row['status'];
            array_push($transactions, $transaction);
        }
        return $transactions;
    }

    public function getByProductId($productId){
        $data = $this->getAll();
         
    }

    public function getByStatus($status){
        $sql = "SELECT * FROM $this->table WHERE status = :status AND isDeleted = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if(!$result)
            return null;
        
        $transactions = array();
        foreach($result as $row){
            $transaction = new Transaction();
            $transaction->id = $row['id'];
            $transaction->userId = $row['userId'];
            $transaction->totalPrice = $row['totalPrice'];
            $transaction->orders = json_decode($row['orders']);
            $transaction->status = $row['status'];
            array_push($transactions, $transaction);
        }
        return $transactions;
    }
}

?>