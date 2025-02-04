<?php

class Database {
    private $host = "tangibly-elegant-veery.data-1.use1.tembo.io";
    private $db_name = "pomodoro_db";
    private $username = "postgres";
    private $password = "mBOaU56EjpR9aYgp";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Erro de conexão irmão: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
