<?php


class RankingController
{
    private $ranking;

    public function __construct($db)
    {
        $this->ranking = new Ranking($db);
    }

    public function getRanking()
    {
        echo json_encode($this->ranking->getRanking());
    }
}
