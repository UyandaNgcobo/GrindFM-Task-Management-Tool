<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/to-do-list.css">
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main>
        <div id="to-do-list-header">
            To-Do List
        </div>
        <div id="create-new-task">
            <div id="task-to-do-list-cont">
                <div id="create-new-task-controls">
                    <a id="addBtn" href="to-do-list-create-page.php">Add Task</a>
                    <button id="clearBtn">Clear All</button>
                </div>

               
                <div id="task-to-do-list">
                </div>
            </div>
            <div id="task-to-do-list-actions">
                <div class="to-do-action">
                    <div class="action-stat">65</div>
                    <div class="action-label">To-Do</div>
                </div>
                <div class="to-do-action">
                    <div class="action-stat">254</div>
                    <div class="action-label">Completed</div>
                </div>
                <div class="to-do-action">
                    <div class="action-icon"><img src="/Images/pdfIcon-word.svg" alt="" srcset=""></div>
                    <div class="action-label">Export</div>
                </div>
                <div class="to-do-action">
                    <div class="action-icon"><img src="/Images/doc.svg" alt="" srcset=""></div>
                    <div class="action-label">History</div>
                </div>
            </div>
        </div>
    </main>

     <script src="js/auth-guard.js"></script>
    <script>

        const clearBtn = document.getElementById('clearBtn');
        clearBtn.addEventListener('click', () => {
            clearAllAndRefresh(taskID);
        })

        document.getElementById('task-to-do-list').addEventListener('click', (e) => {
            if (e.target.classList.contains('deleteBtn')) {
                const taskDiv = e.target.closest('.task-to-do-cont');
                const taskId = taskDiv.dataset.taskId;
                deleteAndRefresh(taskId);
            }
        });

        async function init() {
            await requireLogin();
            await loadTasks();
        }

        async function deleteAndRefresh(taskID){
            await deleteTask(taskID);
            await loadTasks();
        }

        async function clearAllAndRefresh(taskID){
            await clearAll(taskID);
            await loadTasks();
        }

        init();

       async function loadTasks(){
            const response = await fetch('http://localhost:3000/api/tasks', {
                method: 'GET',
                credentials: "include"
            })

            const result = await response.json();

            const list = document.getElementById('task-to-do-list');
            console.log(result)
            let tasks = result.tasks;

            let html = '';
            
            for (const task of tasks){
                html+=`
                    <div class="task-to-do-cont data-task-id="${task.task_id}">
                        <div class="task">${task.title}</div>
                        <input type="checkbox" name="" id="">
                    </div>`;
                }

                list.innerHTML = html;
        }

        async function clearAll(){

            const response = await fetch('http://localhost:3000/api/tasks', {
                method: "DELETE",
                credentials: 'include'
            })

            const result = await response.json();
        }

        async function deleteTask(taskID){
            const response = await fetch(`http://localhost:3000/api/tasks/${taskID}`, {
                method: "DELETE",
                credentials: 'include'
            })

            const result = await response.json();
        }

        async function markCompleted(taskID){
            const response = await fetch(`http://localhost:3000/api/tasks/${taskID}`, {
                method: "PATCH",
                credentials: 'include'
            })

            const result = await response.json();
        }
            
    </script>
</body>
</html>