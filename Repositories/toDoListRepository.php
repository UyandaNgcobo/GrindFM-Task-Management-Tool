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
           return false;
        }
        
    }

    public function deleteTask(int $userId, int $taskID) : bool{

        $statement = $this->pdo->prepare(
            "DELETE FROM Tasks
            WHERE task_id = ? AND user_id = ? 
            "
        );

        try {
            $statement->execute([
                $taskID,
                $userId
        ]);

        return true;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
       
    }

    public function deleteAllTasks(int $userId) : bool{
            $statement = $this->pdo->prepare(
            "DELETE FROM Tasks
            WHERE user_id = ? 
            "
        );

        try {
           $statement->execute([
                $userId,
            ]);

        return true;

        }catch (PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }  

    public function getAllTasks(int $userId) : array{

        $statement = $this->pdo->prepare(
            "SELECT * FROM Tasks
            WHERE user_id = ?
            ORDER BY status_id ASC, task_id DESC
            "
        );
        
        $statement->execute([
            $userId
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendingTaskCount(int $userId, int $statusId) : int{
        $statement = $this->pdo->prepare(
            "SELECT COUNT(*) AS total 
            FROM Tasks
            WHERE user_id = ?
            AND status_id = ?"
        );

        $statement->execute([
            $userId,
            $statusId
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return (int) $result['total'];
    }

    public function getCompletedTaskCount(int $userId, int $statusId) : int{

        $statement = $this->pdo->prepare(
            "SELECT COUNT(*) AS total 
            FROM Tasks
            WHERE user_id = ?
            AND status_id = ?"
        );

        $statement->execute([
            $userId,
            $statusId
        ]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }

    public function updateTaskStatus(int $userId, int $taskID, int $statusId) : bool{
        $statement = $this->pdo->prepare(
            "UPDATE Tasks
            SET status_id = ?
            WHERE task_id = ?
            AND user_id = ?"
        );

       try {
            $statement->execute([$statusId, $taskID, $userId]);
            error_log("Rows affected: " . $statement->rowCount());
            return true;
        } catch (PDOException $e){
            error_log($e->getMessage());
            return false;
        }

    }

    public function getActivity(int $userId){{
        $statement = $this->pdo->prepare(
        "SELECT 
                DATE(created_at) as activity_date, 
                COUNT(task_id) as daily_count 
            FROM Tasks
            WHERE user_id = ? 
              AND created_at >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
            GROUP BY DATE(created_at)
            ORDER BY activity_date ASC
        ");

        try {
            error_log("Rows affected: " . $statement->rowCount());
            $statement->execute([$userId]);
            $activities = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $activities;
        } catch (PDOException $e){
            error_log($e->getMessage());
        }
       
    }

    }
}

?>