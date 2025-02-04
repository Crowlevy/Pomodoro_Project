<?php

class UserModel {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $email, $password) {
        $query = "INSERT INTO " . $this->table_name . " (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->conn->prepare($query);

        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_hash);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function login($email, $password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    public function updateProfile($user_id, $photo, $description) {
        $query = "UPDATE " . $this->table_name . " SET photo = :photo, description = :description WHERE id = :user_id";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':photo', $photo);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':user_id', $user_id);
    
        return $stmt->execute();
    }
    
}
