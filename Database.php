<?php

    class Database {
        private $host = 'localhost';
        private $dbname = 'inovadevs';
        private $user = 'guilherme';
        private $password = 'goncaGuih22';
        public $conn;

        public function getConnection() {
            $this->conn = null;
            try {
                $this->conn = new PDO("pgsql:host={$this->host};dbname={$this->dbname}", $this->user, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $exception) {
                echo "Erro na conexão: " . $exception->getMessage();
            }

            return $this->conn;
        }
    }
?>
