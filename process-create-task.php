<?php
    header('Content-Type:application/json');

    $rawJson = file_get_contents('php://input');

    $data = json_decode($rawJson, true);

    $title = $data['title'];

    $description = $data['description'] ?? '';

    echo json_encode([
        "status" => "success",
        "message" =>  "Process successfully received your Task"
    ]);

?>