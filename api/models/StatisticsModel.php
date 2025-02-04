<?php

class StatisticsModel {
    private $conn;
    private $table_name = "statistics";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addMinutes($user_id, $minutes) {
        $query = "INSERT INTO " . $this->table_name . " (user_id, total_minutes)
                  VALUES (:user_id, :minutes)
                  ON DUPLICATE KEY UPDATE total_minutes = total_minutes + :minutes";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':minutes', $minutes);

        return $stmt->execute();
    }

    public function getLeaderboard() {
        $query = "SELECT users.username, statistics.total_minutes
                  FROM " . $this->table_name . "
                  INNER JOIN users ON statistics.user_id = users.id
                  ORDER BY statistics.total_minutes DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
