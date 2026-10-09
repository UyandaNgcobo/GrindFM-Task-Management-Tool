<?php

    session_start();
    
    $method = $_SERVER['REQUEST_METHOD'];

    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/../Repositories/userRepository.php';

    header('Content-Type:application/json');

 

    //inject connection object
    $repository = new UserRepository($pdo);

    if($method == 'GET'){

        $user_id = $_SESSION['user_id'];
        
        if(!$user_id){
            $users = $repository->getAllUsers();

            echo json_encode([
                "status" => "success",
                "users" => $users
            ]);
            exit;
        }

        $user = $repository->getUser($user_id);
        echo json_encode([
            "status" => "success",
            "user" => $user
        ]);
        exit;

        //retrive user
    }

    if($method == 'POST'){

        $rawJson = file_get_contents('php://input');
        $data = json_decode($rawJson, true);

        $username = $data['username'];
        $email = $data['email'];
        $password = $data['password'];

        $hash = password_hash($password, PASSWORD_DEFAULT);

        //create user
        $repository->createUser(
            $username,
            $email,
            $hash
        );

        echo json_encode([
        "status" => "success",
        "message" => "Account has successfully been created!"]);
        
    }


    
?>