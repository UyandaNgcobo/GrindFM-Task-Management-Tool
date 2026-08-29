<?php 

    $method = $_SERVER['REQUEST_METHOD'];

    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/userRepository.php';

    header('Content-Type:application/json');

    $repository = new userRepository($pdo);

    if($method == 'GET'){
        
        //retrive user
    }

    if($method == 'POST'){
        $rawJson = file_get_contents('php://input');
        $data = json_decode($rawJson, true);

        $username = $data['username'];
        $email = $data['email'] ?? '';
        $rawPassword = $data['password'] ?? '';
        $password_hash = password_hash($rawPassword, PASSWORD_DEFAULT);

        $user = $repository->getByEmail($email);


        //check user exists. if not allow add
        if (empty($user)) {

            try {
                $repository->createUser($username, $email, $password_hash);

                echo json_encode([
                    "status" => "success",
                    "message" => "Welcome, " . $username . "! Hope you enjoy!",
                ]);
            } catch (PDOException $e) {
                if($e->getCode() == 23000){
                    echo json_encode([
                        "status" => "failed",
                        "message" => "That username is already taken. Please choose another."
                    ]);
                };
            }

            
        }else{
            echo json_encode([
                "status" => "failed",
                "message" => "An account with this email already exists!"
            ]);
        }
        
    }


?>