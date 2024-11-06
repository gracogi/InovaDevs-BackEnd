<?php
    namespace DAO;

    use PDO;
    use Entities\User;

    class UserDAO {
        private $conn;
        private $table_name = "users";

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function create($user) {
            $query = "INSERT INTO " . $this->table_name . " (name, cpf, phone, email, password, user_type) 
                      VALUES (:name, :cpf, :phone, :email, :password, :userType)";
            $stmt = $this->conn->prepare($query);
        
            $name = $user->getName();
            $cpf = $user->getCpf();
            $phone = $user->getPhone();
            $email = $user->getEmail();
            $password = $user->getPassword();
            $userType = $user->getUserType();
        
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":cpf", $cpf, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":userType", $userType);
        
            if ($stmt->execute()) {
                return true;
            }
            return false;
        }
        

        public function read($userId = null) {
            if ($userId) {
                $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :userId";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            } else {
                $query = "SELECT * FROM " . $this->table_name;
                $stmt = $this->conn->prepare($query);
            }

            $stmt->execute();
            return $stmt;
        }

        public function update(User $user) {
            $query = "UPDATE " . $this->table_name . " SET name = :name, cpf = :cpf, phone = :phone, email = :email, password = :password, user_type = :userType WHERE user_id = :userId";
            
            $stmt = $this->conn->prepare($query);

            $userId = $user->getUserId();        
            $name = $user->getName();
            $cpf = $user->getCpf();
            $phone = $user->getPhone();
            $email = $user->getEmail();
            $password = $user->getPassword();
            $userType = $user->getUserType();
        
            $stmt->bindParam(":userId", $userId);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":cpf", $cpf, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":userType", $userType);

            if ($stmt->execute()) {
                return true;
            }
        
            return false;
        }
        

        public function delete($userId) {
            $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :userId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }
    }
?>
