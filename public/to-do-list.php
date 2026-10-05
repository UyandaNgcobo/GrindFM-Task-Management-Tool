<?php
    session_start();
?>

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
        <div class="container">
                <div class="to-do-list-title">
                To-Do-Tasks
            </div>
            <div class="tasks-filter-tab">
                <div class="to-do">To do</div>
                <div class="completed">Completed</div>
            </div>
            <div id="tasks-container">
                <div class="task-checkbox-container">
                    <p id="task">Task</p>
                    <input type="checkbox" name="" id="task-checkbox">
                </div>
                <div class="task-checkbox-container">
                    <p id="task">Task</p>
                    <input type="checkbox" name="" id="task-checkbox">
                </div>
                <div class="task-checkbox-container">
                    <p id="task">Task</p>
                    <input type="checkbox" name="" id="task-checkbox">
                </div>
                <div class="task-checkbox-container">
                    <p id="task">Task</p>
                    <input type="checkbox" name="" id="task-checkbox">
                </div>
                <div class="task-checkbox-container">
                    <p id="task">Task</p>
                    <input type="checkbox" name="" id="task-checkbox">
                </div>
            </div>
        </div>
    </main>
    <?php include 'components/navbar.php'; ?>
   
     <script src="js/auth-guard.js"></script>
     <script src="js/api.js"></script>
      <script >
        requireLogin();
    </script>
    <script>

        async function render(){
            const result = await loadTasks();

            // const toDoCount = document.getElementById('todoCount');
            // const completedTotal = document.getElementById('completedCount');
            const container = document.getElementById("tasks-container");

            let html = "";

            for (const task of result.tasks) {
                const isChecked = task.status_id === 2 ? "checked" : "";
                html += `
                                <div class="task-checkbox-container" data-task-id="${task.task_id}>
                                    <p id="task">${task.title}</p>
                                    <input type="checkbox" name="" id="task-checkbox" ${isChecked}>
                                </div>`;
            }

            container.innerHTML = html;

        }

        async function init() {
            await requireLogin();
            await render();
        }

        // async function deleteAndRefresh(taskID){
        //     await deleteTask(taskID);
        //     await render();
        // }

        // async function deleteAllAndRefresh(){
        //     await deleteAllTasks();
        //     await render();
        // }

        // document.getElementById('clearBtn').addEventListener('click', async () => {
        //     console.log('DELETE PRESSED')
        //     deleteAllAndRefresh();
        // })

        // document.getElementById('task-to-do-list').addEventListener('click', (e) => {
        //     if (e.target.classList.contains('deleteBtn')) {
        //         const taskDiv = e.target.closest('.task-to-do-cont');
        //         const taskId = taskDiv.dataset.taskId;
        //         deleteAndRefresh(taskId);
        //     }
        // });

        document.getElementById('tasks-container').addEventListener('change', (e) => {
            if (e.target.type === 'checkbox') {
                const taskDiv = e.target.closest('.task-checkbox-container');
                const taskId = taskDiv.dataset.taskId;
                const isChecked = e.target.checked;

                const statusId = isChecked ? 2 : 1; // adjust to your actual "Completed"/"In Progress" status_id values
                markCompleted(taskId, statusId);
            }
        });

        init();
        render();
   
    </script>
</body>
</html>