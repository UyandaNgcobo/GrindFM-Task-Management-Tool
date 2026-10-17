CREATE TABLE IF NOT EXISTS Schedules (
    schedule_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    starts_at DATETIME NOT NULL,
    ends_at DATETIME NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (schedule_id),
    INDEX idx_schedules_user_start (user_id, starts_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
