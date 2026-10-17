<?php
$envFile = __DIR__ . '/.env';
$fileEnv = is_file($envFile) ? parse_ini_file($envFile, false, INI_SCANNER_RAW) : [];

if ($fileEnv === false) {
    throw new RuntimeException('Database environment file could not be parsed.');
}

$getSetting = static function (string $name) use ($fileEnv): string {
    $value = getenv($name);
    if ($value === false || $value === '') {
        $value = $fileEnv[$name] ?? null;
    }

    if (!is_string($value) || $value === '') {
        throw new RuntimeException("Missing required database setting: {$name}");
    }

    return $value;
};

$host = $getSetting('DB_HOST');
$dbname = $getSetting('DB_NAME');
$username = $getSetting('DB_USER');
$password = $getSetting('DB_PASS');
$dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $error) {
    error_log('Database connection failed: ' . $error->getMessage());
    http_response_code(503);
    exit(1);
}
