<?php

class Achievement
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAchievements($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM achievements WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addAchievement($userId, $badgeName)
    {
        $stmt = $this->db->prepare("INSERT INTO achievements (user_id, badge_name) VALUES (?, ?)");
        return $stmt->execute([$userId, $badgeName]);
    }
}
