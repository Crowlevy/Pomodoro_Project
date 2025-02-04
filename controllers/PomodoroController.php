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
}
