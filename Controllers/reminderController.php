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
        try {
            $reminders = $repository->getAllReminders($userId);
            echo json_encode([
                "status" => "success",
                "reminders" => $reminders
            ]);
        } catch (PDOException $error) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Reminders could not be loaded."]);
        }
        exit;
    }
    if($method == 'POST'){

        $rawJSON = file_get_contents('php://input');
        $data = json_decode($rawJSON, true);

        $title = is_array($data) && is_string($data['title'] ?? null)
            ? trim($data['title'])
            : '';
        $description = is_array($data) && is_string($data['description'] ?? null)
            ? trim($data['description'])
            : '';
        $trigger_at = is_array($data) && is_string($data['trigger_at'] ?? null)
            ? $data['trigger_at']
            : '';

        if ($title === '') {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "A reminder name is required."]);
            exit;
        }

        $parsedTriggerAt = DateTime::createFromFormat('!Y-m-d\TH:i', $trigger_at);
        $dateErrors = DateTime::getLastErrors();

        if (
            $parsedTriggerAt === false ||
            ($dateErrors !== false && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0))
        ) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "A valid reminder date and time are required."]);
            exit;
        }

        $mysqlFormattedTime = $parsedTriggerAt->format('Y-m-d H:i:s');

        $success = $repository->createReminder($userId, $title, $description, $mysqlFormattedTime);

        if(!$success){
            http_response_code(500);
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
        exit;
        
    }

    if($method == 'DELETE'){

        $taskId = $_GET['taskId'] ?? null;

        if($taskId == null){
            $success = $repository->deleteAllReminders($userId);
        }else{
            $success = $repository->deleteReminder($userId, $taskId);
        }
        
        if(!$success){
            http_response_code(500);
            echo json_encode([
                "status" => "failure",
                "message" => "Failed to delete task!"
            ]);
        }else{
            echo json_encode([
                "status" => "success",
                "message" => $taskId !== null ?  "Reminder successfully deleted!" : "All reminders successfully deleted!"
            ]);
        }
        exit;

    }

    if($method == 'PATCH'){
        $rawJSON = file_get_contents('php://input');
        $data = json_decode($rawJSON, true);

        $updatedDescription = is_array($data) && is_string($data['description'] ?? null)
            ? trim($data['description'])
            : null;
        $reminderId = $_GET['reminderId'] ?? null;

        if($reminderId === null || $updatedDescription === null){
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "A reminder ID and description are required."]);
            exit;
        }

        $success = $repository->editReminderDescription($userId, $reminderId, $updatedDescription);

        // echo $success
        if(!$success){
            http_response_code(500);
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
        exit;
    }

    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed."]);
?>