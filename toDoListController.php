<?php

    $method = $_SERVER['REQUEST_METHOD'];

    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/toDoListRepository.php';

    header('Content-Type:application/json');

 

    //inject connection object
    $repository = new toDoListRepository($pdo);

    session_start();
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Not logged in."]);
        exit;
    }
    $id = $_SESSION['user_id'];

    

    if($method == 'GET'){

        $tasks = $repository->getAllTasks($id);

        echo json_encode([
            "status" => "success",
            "tasks" => $tasks
        ]);
        //retrive user
    }

    if($method == 'POST'){

        $rawJson = file_get_contents('php://input');
        $data = json_decode($rawJson, true);

        $title = $data['title'];
        $description = $data['description'];

        $success = $repository->createTask($id, $title, $description);

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


    
?>