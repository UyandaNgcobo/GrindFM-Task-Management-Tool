<?php
require_once 'Task.php';
class TaskManager{
    public array $tasks = [];
    public int $task_id = 0;
    public DateTime $now;

    public function __construct()
    {
        $this->now = new DateTime();
    }

    function createTask(string $text){
        if(strlen($text) != 0){
            $task_id = $this->task_id;
            $createdAt = $this->now->format('Y-m-d H:i:s');
            $task = new Task($task_id, $text, $createdAt);
            $this->task_id += 1;
            $this->tasks[] = $task;
        }else{
            echo 'Enter Task!';
        }   
    }
    function editTask(int $task_id, $text){
        $old_task = array_find(
            $this->tasks,
            fn($task) => $task->id == $task_id
        );

        if($old_task != null){
            $old_task->task = $text;
        }
        else{
            echo "Enter an appropriate index!";
        }
    }
    function deleteTask($task_id){
        
    }
    function completeTask($task_id){
        
    }
}

$manager = new TaskManager();
$task = new Task(1, "iron my shirt", "2026-08-16 17:42:31");
$manager->createTask("wash my clothes");
var_dump($manager->tasks);
$t1 = $manager->tasks[0];
$manager->editTask(0, "I donno");
var_dump($manager->tasks);
