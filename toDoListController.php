<?php

    $method = $_SERVER['REQUEST_METHOD'];

    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/toDoListController.php.php';

    header('Content-Type:application/json');

 

    //inject connection object
    $repository = new toDoListRepository($pdo);


    $id = $_SESSION['user_id'];

    if($method == 'GET'){

        $tasks = $repository->getAllTasks($id);

        echo json_encode([
            "status" => "success",
            "users" => $tasks
        ]);
        //retrive user
    }

    if($method == 'POST'){

        $rawJson = file_get_contents('php://input');
        $data = json_decode($rawJson, true);

        $title = $data['title'];
        $description = $data['description'];

        $hash = password_hash($password, PASSWORD_DEFAULT);

        //create user
        $repository->createTask(
            $id,
            $title,
            $description
        );

        echo json_encode([
        "status" => "success",
        "message" => "Account has successfully been created!"]);
        
    }


    
?>