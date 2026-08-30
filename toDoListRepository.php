<?php

class toDoListRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    
    public function createNote(int $userId, String $title) : void{

        $statement = $this->pdo->prepare(
            "INSERT INTO Tasks (user_id, title)
            VALUES (?, ?)
            "
        );

        $statement->execute([
            $userId,
            $title
        ]);
    }

    public function deleteNote(int $userId) : void{

    $statement = $this->pdo->prepare(
        "DELETE FROM Tasks
        WHERE task_id = ? AND user_id = ? 
        "
    );
    
    $statement->execute([
        $userId
    ]);
    }

    public function getAllTasks(int $userId) : array{

        $statement = $this->pdo->prepare(
            "SELECT * FROM Tasks
            WHERE user_id = ?
            "
        );
        
        $statement->execute([
            $userId
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>