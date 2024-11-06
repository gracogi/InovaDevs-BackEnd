<?php
namespace Entities;

class User {
    private $user_id;
    private $name;
    private $cpf;
    private $phone;
    private $email;
    private $password;
    private $user_type;
    private $creation_date;

    // Getters e Setters
    public function getUserId() { return $this->user_id; }
    public function setUserId($user_id) { $this->user_id = $user_id; }

    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function getCpf() { return $this->cpf; }
    public function setCpf($cpf) { $this->cpf = $cpf; }

    public function getPhone() { return $this->phone; }
    public function setPhone($phone) { $this->phone = $phone; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getPassword() { return $this->password; }
    public function setPassword($password) { $this->password = $password; }

    public function getUserType() { return $this->user_type; }
    public function setUserType($user_type) { $this->user_type = $user_type; }

    public function getCreationDate() { return $this->creation_date; }
    public function setCreationDate($creation_date) { $this->creation_date = $creation_date; }
}
?>
