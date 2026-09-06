<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../public/Config/session.php';


header('Content-Type: application/json');

session_start();//Just so session can catch the user_id var

// Clear session data
$_SESSION = [];

// Expire the cookie in the browser
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy the session server-side
session_destroy();

echo json_encode(["status" => "success", "message" => "Logged out."]);