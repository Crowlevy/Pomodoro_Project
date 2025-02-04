<?php

class PomodoroController {
    private $pomodoroModel;

    public function __construct($db) {
        $this->pomodoroModel = new PomodoroModel($db);
    }

    public function startSession($data) {
        if (!isset($data['user_id'], $data['subject'], $data['duration'])) {
            return ['status' => false, 'message' => 'Formatação inválida'];
        }

        if ($this->pomodoroModel->startSession($data['user_id'], $data['subject'], $data['duration'])) {
            return ['status' => true, 'message' => 'Sessão de pomodoro iniciada'];
        }
        return ['status' => false, 'message' => 'Erro ao começar a sessão'];
    }
    public function validateSession($session_id, $is_valid) {
        $query = "UPDATE sessions SET is_valid = :is_valid WHERE id = :session_id";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':is_valid', $is_valid, PDO::PARAM_BOOL);
        $stmt->bindParam(':session_id', $session_id);
    
        return $stmt->execute();
    }
    
    public function updateStatistics($user_id, $duration) {
        $statsModel = new StatisticsModel($this->conn);
        return $statsModel->addMinutes($user_id, $duration);
    }
    
}

