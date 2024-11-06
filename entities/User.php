<?php
    namespace Entities;

    class User {
        private $userId;
        private $name;
        private $cpf;
        private $phone;
        private $email;
        private $password;
        private $userType;
        private $creationDate;

        // Getters e Setters
        public function getUserId() { return $this->userId; }
        public function setUserId($userId) { $this->userId = $userId; }

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

        public function getUserType() { return $this->userType; }
        public function setUserType($userType) { $this->userType = $userType; }

        public function getCreationDate() { return $this->creationDate; }
        public function setCreationDate($creationDate) { $this->creationDate = $creationDate; }
    }
?>
