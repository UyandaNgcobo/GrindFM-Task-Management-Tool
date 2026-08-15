export class Task{

    constructor(task_id, task, time, isCompleted){
        this.id = task_id
        this.task = task
        this.createdAt = time
        this.isCompleted = false
    }
}