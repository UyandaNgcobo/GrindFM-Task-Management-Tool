<?php

class UserRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    
    public function createUser($username, $email, $password){

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
}

?>