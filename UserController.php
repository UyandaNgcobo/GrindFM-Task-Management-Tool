<?php
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/userRepository.php';

    header('Content-Type:application/json');

    $rawJson = file_get_contents('php://input');
    $data = json_decode($rawJson, true);

    $username = $data['username'];
    $email = $data['email'];
    $password = $data['password'];

    //inject connection object
    $repository = new UserRepository($pdo);

    $repository->createUser(
        $username,
        $email,
        $password
    );


    echo json_encode([
        "status" => "success",
        "message" => "Account has successfully been created!"
    ]);
?>