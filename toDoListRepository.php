<?php

class toDoListRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    
    public function createTask(int $userId, String $title, String $description) : bool{

        $statement = $this->pdo->prepare(
            "INSERT INTO Tasks (user_id, title, description)
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
           echo "DEBUG: " . $e->getMessage();
           return false;
        }
        
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