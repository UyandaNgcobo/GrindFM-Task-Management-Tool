<?php
    session_start();

    $method = $_SERVER['REQUEST_METHOD'];

    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/../Repositories/reminderRepository.php';

    header('Content-Type:application/json');

    //inject connection object
    $repository = new reminderRepository($pdo);

   
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Not logged in."]);
        exit;
    }
    $userId = $_SESSION['user_id'];


    if($method == 'GET'){

        $reminders = $repository->getAllReminders($userId);

        echo json_encode([
            "status" => "success",
            "reminders" => $reminders
        ]);
    }
?>