<?php



class AchievementsController
{
    private $achievement;

    public function __construct($db)
    {
        $this->achievement = new Achievement($db);
    }

    public function getAchievements($userId)
    {
        echo json_encode($this->achievement->getAchievements($userId));
    }

    public function addAchievement($userId, $badgeName)
    {
        if ($this->achievement->addAchievement($userId, $badgeName)) {
            echo json_encode(["message" => "Conquista adicionada"]);
        } else {
            echo json_encode(["error" => "Problema ao adicionar conquista"]);
        }
    }
}
