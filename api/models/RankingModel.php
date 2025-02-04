<?php

class RankingModel
{
    private $conn;
    private $table_name = "statistics";

    public function __construct($db)
    {
        $this->$conn = $db;
    }

    public function getRanking()
    {
        $stmt = $this->$table_name->query("
            SELECT u.username, s.total_minutes
            FROM statistics s
            JOIN users u ON s.user_id = u.id
            ORDER BY s.total_minutes DESC
            LIMIT 10
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
