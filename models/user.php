<?php

class Role{
    public const ADMIN = 'admin';
    public const USER = 'user';
}

class User{
   public $id;
   public $name;
   public $email;
   public $password;
   public $role;
   public $address;
   public $mobile;

   private $conn;

   function __construct()
    {       
        try {
            $this->conn = Connect::makeConnection();
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function add($name, $email, $password, $role, $address, $mobile){
        $sql = "INSERT INTO users (name, email, password, role, address, mobile) VALUES (:name, :email, :password, :role, :address, :mobile)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':mobile', $mobile);

        $stmt->execute();
        $stmt->closeCursor();
    }

    public function update($id, $name, $email, $password, $role, $address, $mobile){
        $sql = "UPDATE users SET name = :name, email = :email, password = :password, role = :role, address = :address, mobile = :mobile WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':mobile', $mobile);

        $stmt->execute();
        $stmt->closeCursor();
    }

    public function delete($id){
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id);

        $stmt->execute();
        $stmt->closeCursor();
    }

    public function getAll(){
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!$result){
            return null;
        }
        
        $users = [];
        foreach($result as $row){
            $user = new User();
            $user->id = $row['id'];
            $user->name = $row['name'];
            $user->email = $row['email'];
            $user->password = $row['password'];
            $user->role = $row['role'];
            $user->address = $row['address'];
            $user->mobile = $row['mobile'];
            array_push($users, $user);
        }

        return $users;
    }

    public function getById($id){
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$result){
            return null;
        }

        $user = new User();
        $user->id = $result['id'];
        $user->name = $result['name'];
        $user->email = $result['email'];
        $user->password = $result['password'];
        $user->role = $result['role'];
        $user->address = $result['address'];
        $user->mobile = $result['mobile'];

        return $user;
    }
    
}


?>