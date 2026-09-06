<?php 

    $method = $_SERVER['REQUEST_METHOD'];

    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/../public/Config/session.php';
    require_once __DIR__ . '/../Repositories/userRepository.php';

    header('Content-Type:application/json');

    $repository = new userRepository($pdo);

    initSession(); //initiliase session

    //extra check incase they've somehow accessed login while logged in
    if (isset($_SESSION['user_id'])) {
        http_response_code(200);
        echo json_encode([
            "status" => "already_logged_in"
        ]);
        exit;
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

            http_response_code(200);
            echo json_encode([
                "status" => "success",
                "message" => "Welcome back, " . $user['username'] . "!",
                "user_id" => $user['user_id']
            ]);
        } else {
            http_response_code(401);
            echo json_encode([
                "status" => "error",
                "message" => "Invalid email or password."
            ]);
        }
        
    }


?>