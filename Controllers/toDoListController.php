<?php

    $method = $_SERVER['REQUEST_METHOD'];

    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/../Repositories/toDoListRepository.php';

    header('Content-Type:application/json');


    //inject connection object
    $repository = new toDoListRepository($pdo);

    session_start();
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Not logged in."]);
        exit;
    }
    $userId = $_SESSION['user_id'];


    if($method == 'GET'){

        $tasks = $repository->getAllTasks($userId);
        $count = $repository->getPendingTaskCount($userId, 1);
        $completedCount = $repository->getCompletedTaskCount($userId, 2);
        $rawActivity = $repository->getActivity($userId);
        
        // 2. Format it into a simple dictionary: {"2026-10-01": 5}
        $formattedActivity = [];
        if (is_array($rawActivity)) {
            foreach ($rawActivity as $row) {
                $date = $row['activity_date'];
                $taskCount = (int)$row['daily_count'];
                $formattedActivity[$date] = $taskCount;
            }
        }
        echo json_encode([
            "status" => "success",
            "tasks" => $tasks,
            "count" => $count,
            "completedCount" => $completedCount,
            "activity" => $formattedActivity
        ]);
        //retrive user
    }

    if($method == 'POST'){

        $rawJson = file_get_contents('php://input');
        $data = json_decode($rawJson, true);

        $title = $data['title'];
        $description = $data['description'];

        $success = $repository->createTask($userId, $title, $description);

        if($success){
            echo json_encode([
                "status" => "success",
                "message" => "Task has successfully been created!"
            ]);
        }else{
            echo json_encode([
                "status" => "failure",
                "message" => "Failed to create Task!"
            ]);
        }
    }

    //remove all tasks
    if($method == 'DELETE'){

    $taskId = $_GET['taskId'] ?? null;

    if($taskId != null){
        $success = $repository->deleteTask((int)$userId, (int)$taskId);
       
    }else{
        $success = $repository->deleteAllTasks($userId);
    }

    if($success){
        echo json_encode([
            "status" => "success",
            "message" => $taskId !== null ? "Task deleted" : "All tasks deleted."
        ]);
    }else{
        echo json_encode([
            "status" => "failure",
            "message" => "Failed to delete Task!"
        ]);
    }

    }

    if($method == 'PATCH'){

        $rawJson = file_get_contents('php://input');
        $data = json_decode($rawJson, true);

        $taskId = $_GET['taskId'] ?? null;
        $statusId = $data['statusId'] ?? null;

        if($taskId === null || $statusId === null ){
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Missing taskId or statusId."]);
            exit;
        }

        $success = $repository->updateTaskStatus((int)$userId, (int)$taskId, (int)$statusId);
        if($success){
            echo json_encode([
                "status" => "success",
                "message" => "Status updated!"
            ]);
        }else{
            echo json_encode([
                "status" => "success",
                "message" => "Failed to update status!"
            ]);
        }
        

        
    }


    
?>