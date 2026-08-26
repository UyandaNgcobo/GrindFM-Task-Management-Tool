<?php

require_once __DIR__ . '/config.php';

$statement = $pdo->query("SELECT * FROM users");

$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows);