<?php

    class Database {
        private $host = 'dpg-cslvm98gph6c73aanj0g-a.oregon-postgres.render.com';
        private $dbname = 'inovadevs_db';
        private $user = 'guilherme';
        private $password = 'QZ1KgXDFpoBiECN3TzNljHFhEB8wVtwR';
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
