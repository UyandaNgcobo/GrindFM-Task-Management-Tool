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
                <div class="to-do active">To do</div>
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
     <script src="js/auth-helpers.js"></script>
     <script src="js/api.js"></script>
      <script >
        requireLogin();
    </script>
    <script>

        let currentTab = 'todo';
        async function render(){
            const result = await loadTasks();
            const container = document.getElementById("tasks-container");

            const filteredTasks = result.tasks.filter(task => {
                if(currentTab === 'todo'){
                    return Number(task.status_id) === 1;
                }else{
                    return Number(task.status_id) === 2;
                }
            });

            const taskElements = document.createDocumentFragment();
            for (const task of filteredTasks) {
                const taskElement = document.createElement("div");
                taskElement.className = "task-checkbox-container";
                taskElement.dataset.taskId = task.task_id;

                const title = document.createElement("p");
                title.className = "task-title";
                title.textContent = task.title;

                const checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.className = "task-checkbox";
                checkbox.checked = Number(task.status_id) === 2;

                taskElement.append(title, checkbox);
                taskElements.append(taskElement);
            }

            container.replaceChildren(taskElements);

            const todoTab = document.querySelector('.to-do');
            const completedTab = document.querySelector('.completed');

            todoTab.addEventListener('click', () => {
                currentTab = 'todo';
                
                // Move the active class visually
                todoTab.classList.add('active');
                completedTab.classList.remove('active');
                
                // Instantly wipe and redraw the screen with the new filter
                render();
            });

            completedTab.addEventListener('click', () => {
                currentTab = 'completed';
                
                // Move the active class visually
                completedTab.classList.add('active');
                todoTab.classList.remove('active');
                
                // Instantly wipe and redraw the screen with the new filter
                render();
            });


            //--------------- NEED TO UNDERSTAND -----------------

            // 5. Handle checkbox clicks (Moved classes instead of IDs to prevent duplicates)
            document.getElementById('tasks-container').addEventListener('change', async (e) => {
                if (e.target.classList.contains('task-checkbox')) {
                    const taskDiv = e.target.closest('.task-checkbox-container');
                    const taskId = taskDiv.dataset.taskId;
                    const isChecked = e.target.checked;

                    const statusId = isChecked ? 2 : 1; 
                    await markCompleted(taskId, statusId);
                    render(); 
                }
            });

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

         async function init() {
            await requireLogin();
            await render();
        }

        init();
   
    </script>
</body>
</html>