import { Task } from './Task.js';

export class TaskManager{
    tasks = []
    task_id = 0;
    now = new Date();

    constructor(){

    }

    //Tasks Manager creates task __
    createTask(task){

        if(task.length != 0){
            const id = this.task_id += 1
            let createdAt = this.now.toLocaleString('en-US');
            let new_task = new Task(id, task, createdAt)
            this.tasks.push(new_task)
            console.log("\nAdding task...\n")
        }else{
            console.log("\nTask cannot be empty!\n")
        }
        
    }

    //Task Manager edits task __ and changes it to __
    editTask(task_id, text){
        let old_task = this.tasks.find(task => task.id == task_id)
        old_task.task = text;
    }

    //Tasks Manager deletes task __
    deleteTask(task_id){

    }


    //Tasks Manager marks task __ complete
    completeTask(task_id){

    }
    
}