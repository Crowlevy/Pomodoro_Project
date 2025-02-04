<?php

class GoalModel
{
    private $conn;
    private $table_name = "study_goals";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getGoals($userId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM study_goals WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateGoals($userId, $dailyGoal, $weeklyGoal, $monthlyGoal)
    {
        $stmt = $this->conn->prepare("REPLACE INTO study_goals (user_id, daily_goal, weekly_goal, monthly_goal) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$userId, $dailyGoal, $weeklyGoal, $monthlyGoal]);
    }

    public function updateProgress($userId, $minutes)
    {
        $stmt = $this->conn->prepare("
            UPDATE study_goals
            SET daily_progress = daily_progress + ?, 
                weekly_progress = weekly_progress + ?, 
                monthly_progress = monthly_progress + ?
            WHERE user_id = ?
        ");
        return $stmt->execute([$minutes, $minutes, $minutes, $userId]);
    }
}
