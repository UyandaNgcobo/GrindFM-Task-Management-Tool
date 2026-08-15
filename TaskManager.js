import { Task } from './Task.js';

export class TaskManager{
    tasks = []
    task_id = 0;
    now = new Date();

    constructor(){

    }

    createTask(task){

        if(task.length != 0){
            const id = this.task_id += 1
            let time = this.now.toLocaleString('en-US');
            let new_task = new Task(id, task, time)
            this.tasks.push(new_task)
            console.log("\nAdding task...\n")
        }else{
            console.log("\nTask cannot be empty!\n")
        }
        
    }

    editTask(task_id, task){
        let new_task = this.tasks.find(task => task.id == task_id)
        if(new_task.length != 0){
            console.log(new_task)
        }else{
            console.log("Can't find it!")
        }
        
    
    }

    deleteTask(){

    }

    completeTask(){

    }
    
}