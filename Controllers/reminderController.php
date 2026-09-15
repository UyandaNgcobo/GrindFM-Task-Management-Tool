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
    if($method == 'POST'){

        $rawJSON = file_get_contents('php://input');
        $data = json_decode($rawJSON, true);

        $title = $data['title'];
        $description = $data['description'];
        $trigger_at = $data['trigger_at'];

        $success = $repository->createReminder($userId, $title, $description, $trigger_at);

        if(!$success){
            echo json_encode([
                "status" => "failure",
                "message" => "Failed to create reminder!"
            ]);
        }else{
            echo json_encode([
                "status" => "success",
                "message" => "Successfully created reminder!"
            ]);
        }
        
    }

    if($method == 'DELETE'){

        $reminders = $repository->deleteAllReminder($userId);

        echo json_encode([
            "status" => "success",
            "message" => "All reminders successfully deleted!"
        ]);
    }

    if($method == 'PATCH'){
        $rawJSON = file_get_contents('php://input');
        $data = json_decode($rawJSON, true);

        $updatedDescription = $data['description'];
        $reminderId = $_GET['reminderId'] ?? null;

        if($reminderId === null){
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Missing reminderId."]);
            exit;
        }

        $success = $repository->editReminderDescription($userId, $reminderId, $updatedDescription);

        if(!$success){
            echo json_encode([
                "status" => "failure",
                "message" => "Failed to update reminder!"
            ]);
        }else{
            echo json_encode([
                "status" => "success",
                "message" => "Successfully updated reminder!"
            ]);
        }
    }
?>