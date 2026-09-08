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

    public function createReminder(int $userId, String $title, String $description) : bool{
        $statement = $this->pdo->prepare(
            "INSERT INTO Reminders (user_id, title, description)
            VALUES (?, ?, ?)
            "
        );

        try {
            $statement->execute([
            $userId,
            $title,
            $description
        ]);

        return true;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
        
    }

    public function deleteReminder(int $userId, int $reminder_id){
        $statement = $this->pdo->prepare(
            "DELETE FROM Reminders
            WHERE user_id = ?
            AND reminder_id = ?"
        );

        $statement->execute([
            $userId,
            $reminder_id
        ]);
    }

    public function deleteAllReminder(int $userId) : void{
        $statement = $this->pdo->prepare(
            "DELETE FROM Reminders
            WHERE user_id = ?"
        );

        try {
            $statement->execute([
                $userId
            ]);

        } catch (PDOException $e) {
            $e->getMessage();
        }
        
    }

    public function editReminder(int $userId, int $reminder_id){
        $statement = $this->pdo->prepare(
            ""
        );

        $statement->execute([
            $userId
        ]);
    }

}