<?php 

    $method = $_SERVER['REQUEST_METHOD'];

    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/userRepository.php';

    header('Content-Type:application/json');

    $repository = new userRepository($pdo);

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();

    if (isset($_SESSION['user_id'])) {
        echo json_encode([
            "status" => "already_logged_in"
        ]);
        exit;
    }

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

            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['user_id'];

            echo json_encode([
                "status" => "success",
                "message" => "Welcome back, " . $user['username'] . "!",
                "user_id" => $user['user_id']
            ]);
        }
        
    }


?>