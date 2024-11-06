<?php
namespace DAO;

use Entities\User;
use Database;

class UserDAO {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create(User $user) {
        $query = "INSERT INTO users (name, cpf, phone, email, password, user_type) VALUES (:name, :cpf, :phone, :email, :password, :user_type)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $user->getName());
        $stmt->bindParam(':cpf', $user->getCpf());
        $stmt->bindParam(':phone', $user->getPhone());
        $stmt->bindParam(':email', $user->getEmail());
        $stmt->bindParam(':password', password_hash($user->getPassword(), PASSWORD_BCRYPT));
        $stmt->bindParam(':user_type', $user->getUserType());

        return $stmt->execute();
    }
}
?>
