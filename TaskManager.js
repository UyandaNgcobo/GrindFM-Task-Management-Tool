import { Task } from './Task.js'

class TaskManager{
    tasks = []
    now = new Date;

    createTask(){

        task = new Task()
        if(task != "" || tasks != NULL){
            this.tasks.append(task)
        }
        
    }

    ediTask(){
        
    }

    deleteTask(){

    }
    
}

manager = new TaskManager;

time = manager.now().toLocaleString('en-US');
console.log(time)