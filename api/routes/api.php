<?php

require_once './config/database.php';
require_once './models/UserModel.php';
require_once './models/PomodoroModel.php';
require_once './models/RankingModel.php';
require_once './models/GoalModel.php';
require_once './models/AchievementsModel.php';
require_once './controllers/AuthController.php';
require_once './controllers/PomodoroController.php';
require_once './controllers/AchievementsController.php';
require_once './controllers/RankingController.php';
require_once './controllers/GoalController.php';
$database = new Database();
$db = $database->getConnection();

header('Content-Type: application/json');

$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

$request = str_replace('/pomodoro_project/api/index.php', '', $_SERVER['REQUEST_URI']);

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
    $rankingController = new RankingController($db);
    echo json_encode($rankingController->getRanking());

} elseif ($request === '/api/goals' && $method === 'GET') {
    if (!isset($_GET['user_id'])) {
        echo json_encode(['status' => false, 'message' => 'User ID é obrigatório']);
        exit();
    }

    $goalsController = new GoalsController($db);
    $goals = $goalsController->getGoals($_GET['user_id']);  

    if (empty($goals)) {
        echo json_encode(['status' => false, 'message' => 'Nenhum objetivo encontrado']);
    } else {
        echo json_encode($goals);  // dados dos objetivos
    }

} elseif ($request === '/api/goals/update' && $method === 'POST') {
    $goalsController = new GoalsController($db);
    echo json_encode($goalsController->updateGoals($data));

} elseif ($request === '/api/achievements' && $method === 'GET') {
    if (!isset($_GET['user_id'])) {
        echo json_encode(['status' => false, 'message' => 'User ID é obrigatório']);
    } else {
        $achievementsController = new AchievementsController($db);
        echo json_encode($achievementsController->getAchievements($_GET['user_id']));
    }
}
 else {
    echo json_encode(['status' => false, 'message' => 'O endpoint não foi achado']);
}

