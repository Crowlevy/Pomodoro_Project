<?php

class PomodoroModel {
    private $conn;
    private $table_name = "sessions";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function startSession($user_id, $subject, $duration) {
        $query = "INSERT INTO " . $this->table_name . " (user_id, subject, duration) VALUES (:user_id, :subject, :duration)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':duration', $duration);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
