<?php

class reminderRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function createReminder(int $userId){
        $statement = $this->pdo->prepare(
            ""
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