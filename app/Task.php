<?php 
class Task {
    public int $id;
    public string $task;
    public string $createdAt;
    public bool $isCompleted;

    public function __construct(int $id, string $task, string $createdAt){
        $this->id = $id;
        $this->task = $task;
        $this->createdAt = $createdAt;
        $this->isCompleted = false;
    }
}
?>