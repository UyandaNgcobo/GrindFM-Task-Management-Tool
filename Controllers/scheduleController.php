<?php

session_start();
$method = $_SERVER['REQUEST_METHOD'];

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../Repositories/scheduleRepository.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Not logged in."]);
    exit;
}

$userId = (int) $_SESSION['user_id'];
$repository = new ScheduleRepository($pdo);

if ($method === 'GET') {
    try {
        echo json_encode([
            "status" => "success",
            "schedules" => $repository->getAllSchedules($userId),
        ]);
    } catch (PDOException $error) {
        error_log($error->getMessage());
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Your schedule could not be loaded."]);
    }
    exit;
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!is_array($data)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "A valid event payload is required."]);
        exit;
    }

    $titleInput = $data['title'] ?? '';
    $descriptionInput = $data['description'] ?? '';
    if (!is_string($titleInput) || !is_string($descriptionInput)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Event name and description must be text."]);
        exit;
    }

    $title = trim($titleInput);
    $description = trim($descriptionInput);
    $startsAtInput = $data['starts_at'] ?? '';
    $endsAtInput = $data['ends_at'] ?? '';

    if ($title === '' || !is_string($startsAtInput) || $startsAtInput === '') {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "An event name and start date are required."]);
        exit;
    }

    $startsAt = DateTime::createFromFormat('!Y-m-d\TH:i', $startsAtInput);
    $startErrors = DateTime::getLastErrors();

    if (
        $startsAt === false ||
        ($startErrors !== false && ($startErrors['warning_count'] > 0 || $startErrors['error_count'] > 0))
    ) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Enter a valid start date and time."]);
        exit;
    }

    if ($endsAtInput !== '' && !is_string($endsAtInput)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Enter a valid end date and time."]);
        exit;
    }

    $endsAt = null;
    if ($endsAtInput !== '') {
        $endsAt = DateTime::createFromFormat('!Y-m-d\TH:i', $endsAtInput);
        $endErrors = DateTime::getLastErrors();
        if (
            $endsAt === false ||
            ($endErrors !== false && ($endErrors['warning_count'] > 0 || $endErrors['error_count'] > 0)) ||
            $endsAt <= $startsAt
        ) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "The end must be after the start."]);
            exit;
        }
    }

    $created = $repository->createSchedule(
        $userId,
        $title,
        $description,
        $startsAt->format('Y-m-d H:i:s'),
        $endsAt?->format('Y-m-d H:i:s')
    );

    if (!$created) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "The event could not be created. Please try again."]);
        exit;
    }

    echo json_encode(["status" => "success", "message" => "Event created successfully."]);
    exit;
}

if ($method === 'DELETE') {
    $scheduleId = filter_input(INPUT_GET, 'scheduleId', FILTER_VALIDATE_INT);
    if ($scheduleId === false || $scheduleId === null || $scheduleId < 1) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "A valid schedule ID is required."]);
        exit;
    }

    if (!$repository->deleteSchedule($userId, $scheduleId)) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "The event could not be deleted. Please try again."]);
        exit;
    }

    echo json_encode(["status" => "success", "message" => "Event deleted."]);
    exit;
}

http_response_code(405);
echo json_encode(["status" => "error", "message" => "Method not allowed."]);
