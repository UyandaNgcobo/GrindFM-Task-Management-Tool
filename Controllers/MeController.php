<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../public/Config/session.php';

header('Content-Type: application/json');

session_start();

echo json_encode([
    "user_id" => $_SESSION['user_id'] ?? null
]);