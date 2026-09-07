<?php

class reminderRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function getAllReminders(int $userId) {
        $statement = $this->pdo->prepare(
            "SELECT * FROM Reminders
            ORDER BY trigger_at ASC;
            WHERE user_id = ?
            "
        );

        try {
            $statement->execute([
                $userId
            ]);

            return $statement->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

    public function createReminder(int $userId){
        $statement = $this->pdo->prepare(
            "INSERT INTO Reminders (user_id, title, description)
            VALUES (?, ?, ?)
            "
        );

        $statement->execute([
            $userId
        ]);
    }

    public function deleteReminder(int $userId, int $reminder_id){
        $statement = $this->pdo->prepare(
            ""
        );

        $statement->execute([
            $userId
        ]);
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