<?php

class UserRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    
    public function createUser($username, $email, $password) : void{

        $statement = $this->pdo->prepare(
            "INSERT INTO users (username, email, password)
            VALUES (?, ?, ?)"
        );

        $statement->execute([
            $username,
            $email,
            $password
        ]);

    }

    public function deleteUser(int $id) : void{

        $statement = $this->pdo->prepare(
            "DELETE FROM users
            WHERE user_id = ?
            "
        );

        $statement->execute([
            $id
        ]);
    }

    public function getAllUsers() : array{
        $statement = $this->pdo->prepare(
            "SELECT user_id, username, email
            FROM users"
        );

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByEmail(String $email){
        $statement = $this->pdo->prepare(
            "SELECT user_id, username, email, password
            FROM users
            WHERE email = ?"
        );

        $statement->execute([
            $email
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }
}

?>