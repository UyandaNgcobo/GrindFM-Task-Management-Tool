<?php
    $env = parse_ini_file(__DIR__ . '/.env');

    $host = $env['DB_HOST'];
    $dbname = $env['DB_NAME'];
    $username = $env['DB_USER'];
    $password = $env['DB_PASS'];

    try {

        //setup DB
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

        //start connection with credentials
        $pdo = new PDO($dsn, $username, $password);

        //config connection
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }catch (PDOException $e){
        
    exit();
    }
?>
