<?php

class User extends DBParent{
   public string $name= "";
   public string $email = "";
   public string $password ="";
   public string $role = "";
   public string $address = "";
   public string $mobile = "";
 

   public function add($name, $email, $password, $role, $address, $mobile) {
    $hashedPassword = md5($password);

    $sql = "INSERT INTO $this->table (name, email, password, role, address, mobile, isDeleted) VALUES (:name, :email, :password, :role, :address, :mobile, 0)";
    $stmt = $this->conn->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':mobile', $mobile);


    $stmt->execute();
    $stmt->closeCursor();
}


        public function update($id, $name, $email, $password, $role, $address, $mobile){
            $sql = "UPDATE $this->table SET name = :name, email = :email, password = :password, role = :role, address = :address, mobile = :mobile WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $password = md5($password);
            if($password == md5(''))
                $password = $this->getById($id)->password;
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':mobile', $mobile);
            $stmt->execute();
            $stmt->closeCursor();
        }


        public function getByEmail($email){
            $sql = "SELECT * FROM $this->table WHERE email = :email AND isDeleted = 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(!$result)
                return null;
            
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