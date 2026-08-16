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
    function editTask(int $task_id, string $text){
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
    function deleteTask(int $task_id){

        if($task_id == null){
            echo 'Invalid ID';
            return;
        }
        $this->tasks = array_values(
            array_filter(
                $this->tasks,
                fn($task) => $task->id != $task_id
            )
        );
    }
    function completeTask(int $task_id){
        $task = array_find(
            $this->tasks,
            fn($task) => $task->id == $task_id
        );

        if($task == null){
            echo 'Task not found!';
            return;
        }
        if($task->isCompleted == true){
            echo 'Task is already Complete!';
            return;
        }

        $task->isCompleted = true;
    }
}

$manager = new TaskManager();
$task = new Task(1, "iron my shirt", "2026-08-16 17:42:31");
$manager->createTask("wash my clothes");
var_dump($manager->tasks);
$t1 = $manager->tasks[0];
$manager->editTask(99, "I donno");
$manager->completeTask(99);
$manager->deleteTask($t1->id);

var_dump($manager->tasks);
