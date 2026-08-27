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

        $email = $data['email'] ?? '';
        $rawPassword = $data['password'] ?? '';

        $user = $repository->getByEmail($email);

        //check user exists and match pass
        if ($user && password_verify($rawPassword, $user['password'])) {
            
            
            echo json_encode([
                "status" => "success",
                "message" => "Welcome back, " . $user['username'] . "!",
                "user_id" => $user['user_id']
            ]);
        }
        
    }


?>