<?php

    class Database {
        private $host = 'ep-old-block-a4e2qg01-pooler.us-east-1.aws.neon.tech';
        private $dbname = 'verceldb';
        private $user = 'default';
        private $password = 'jW0EBVo9ayuh';
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
