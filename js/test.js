import { TaskManager } from './TaskManager.js';

const manager = new TaskManager();

let t1 = "iron my shirt"
let t2 = "cook food"
let t3 = "kms"
let t4 = ""

manager.createTask(t1)
manager.createTask(t2)
manager.createTask(t3)
manager.createTask(t4)


console.log(manager.tasks);
manager.editTask(2, 'swim');
console.log(manager.tasks);
manager.tasks[2].isCompleted = true;
manager.deleteTask(2);

manager.completeTask(3)
console.log(manager.tasks);