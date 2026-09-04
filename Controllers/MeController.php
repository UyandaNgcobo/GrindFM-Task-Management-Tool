<?php

require_once __DIR__ . '/../config.php';

header('Content-Type: application/json');

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

echo json_encode([
    "user_id" => $_SESSION['user_id'] ?? null
]);