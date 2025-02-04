<?php


class GoalController
{
    private $goal;

    public function __construct($db)
    {
        $this->goal = new Goal($db);
    }

    public function getGoals($userId)
    {
        echo json_encode($this->goal->getGoals($userId));
    }

    public function updateGoals($userId, $dailyGoal, $weeklyGoal, $monthlyGoal)
    {
        if ($this->goal->updateGoals($userId, $dailyGoal, $weeklyGoal, $monthlyGoal)) {
            echo json_encode(["message" => "Metas adicionadas com sucesso"]);
        } else {
            echo json_encode(["error" => "Falha ao adicionar metas"]);
        }
    }
}
