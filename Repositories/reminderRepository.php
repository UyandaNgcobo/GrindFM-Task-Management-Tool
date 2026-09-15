<?php

class reminderRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function getAllReminders(int $userId) {
        $statement = $this->pdo->prepare(
            "SELECT * FROM Reminders
            WHERE user_id = ?
            ORDER BY trigger_at ASC;
            "
        );

        try {
            $statement->execute([
                $userId
            ]);

            return $statement->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $e->getMessage();
        }
        
    }

    public function createReminder(int $userId, string $title, string $description, string $trigger_at) : bool{
        $statement = $this->pdo->prepare(
            "INSERT INTO Reminders (user_id, title, description, trigger_at)
            VALUES (?, ?, ?, ?)
            "
        );

        try {
            $statement->execute([
            $userId,
            $title,
            $description,
            $trigger_at
        ]);

        return true;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
        
    }

    public function deleteReminder(int $userId, int $reminder_id) : bool{
        $statement = $this->pdo->prepare(
            "DELETE FROM Reminders
            WHERE user_id = ?
            AND reminder_id = ?"
        );

        try {
            $statement->execute([
            $userId,
            $reminder_id
        ]);

        return true;

        } catch (PDOException $e) {
            error_log("deleteReminder Exception", $e->getMessage());
            return false;
        }

    }

    public function deleteAllReminders(int $userId) : bool{
        $statement = $this->pdo->prepare(
            "DELETE FROM Reminders
            WHERE user_id = ?"
        );

        try {
            $statement->execute([
                $userId
            ]);

            return true;
        } catch (PDOException $e) {
            error_log("getAllReminders Error: " . $e->getMessage());
            return false;
        }
        
    }

    public function editReminderDescription(int $userId, int $reminder_id, string $description) : bool{
        $statement = $this->pdo->prepare(
            "UPDATE reminders 
            SET description = ?
            WHERE user_id = ?
            AND reminder_id = ?"
        );

        try {
            $statement->execute([
            $description,
            $userId,
            $reminder_id,
        ]);

        return true;

        } catch (PDOException $e) {
            error_log("getAllReminders Error: " . $e->getMessage());
            return false;
        }

    }

}