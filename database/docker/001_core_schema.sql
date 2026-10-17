CREATE TABLE IF NOT EXISTS users (
    user_id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (user_id),
    UNIQUE KEY username (username),
    UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS task_status (
    status_id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    PRIMARY KEY (status_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO task_status (status_id, name) VALUES
    (1, 'In Progress'),
    (2, 'Completed'),
    (3, 'Not Started');

CREATE TABLE IF NOT EXISTS Tasks (
    task_id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_id INT NOT NULL,
    status_id INT NOT NULL DEFAULT 1,
    PRIMARY KEY (task_id),
    CONSTRAINT fk_user_task FOREIGN KEY (user_id)
        REFERENCES users (user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_task_status FOREIGN KEY (status_id)
        REFERENCES task_status (status_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS Reminders (
    reminder_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    title TEXT NOT NULL,
    description TEXT NULL,
    trigger_at DATETIME NOT NULL,
    PRIMARY KEY (reminder_id),
    CONSTRAINT reminders_ibfk_1 FOREIGN KEY (user_id)
        REFERENCES users (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
