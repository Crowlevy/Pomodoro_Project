<?php

require_once './config/database.php';
require_once './models/UserModel.php';
require_once './models/PomodoroModel.php';
require_once './controllers/AuthController.php';
require_once './controllers/PomodoroController.php';

$database = new Database();
$db = $database->getConnection();

header('Content-Type: application/json');

$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

$request = str_replace('/pomodoro_project/api/index.php', '', $request);

if ($request === '/api/register' && $method === 'POST') {
    $authController = new AuthController($db);
    echo json_encode($authController->register($data));
} elseif ($request === '/api/login' && $method === 'POST') {
    $authController = new AuthController($db);
    echo json_encode($authController->login($data));
} elseif ($request === '/api/pomodoro/start' && $method === 'POST') {
    $pomodoroController = new PomodoroController($db);
    echo json_encode($pomodoroController->startSession($data));
}
elseif ($request === '/api/session/validate' && $method === 'POST') {
    $pomodoroController = new PomodoroController($db);
    $result = $pomodoroController->validateSession($data['session_id'], $data['is_valid']);
    echo json_encode(['status' => $result, 'message' => $result ? 'Sessão validada com sucesso eba' : 'Falha ao validar a sessão ah não']);
} elseif ($request === '/api/statistics/leaderboard' && $method === 'GET') {
    $statsModel = new StatisticsModel($db);
    echo json_encode($statsModel->getLeaderboard());
}
 else {
    echo json_encode(['status' => false, 'message' => 'O endpoint não foi achado']);
}

