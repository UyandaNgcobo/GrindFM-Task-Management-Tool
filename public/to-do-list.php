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
                    <div class="action-stat" id="todoCount">0</div>
                    <div class="action-label">To-Do</div>
                </div>
                <div class="to-do-action">
                    <div class="action-stat" id="completedCount">0</div>
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
     <script src="js/api.js"></script>
    <script>

        let toDoCount = document.getElementById('todoCount');
        let completedTotal = document.getElementById('completedCount');

        const clearBtn = document.getElementById('clearBtn');
        clearBtn.addEventListener('click', () => {
            deleteAllAndRefresh();
        })

        document.getElementById('task-to-do-list').addEventListener('click', (e) => {
            if (e.target.classList.contains('deleteBtn')) {
                const taskDiv = e.target.closest('.task-to-do-cont');
                const taskId = taskDiv.dataset.taskId;
                deleteAndRefresh(taskId);
            }
        });

        document.getElementById('task-to-do-list').addEventListener('change', (e) => {
            if (e.target.type === 'checkbox') {
                const taskDiv = e.target.closest('.task-to-do-cont');
                const taskId = taskDiv.dataset.taskId;
                const isChecked = e.target.checked;

                const statusId = isChecked ? 2 : 1; // adjust to your actual "Completed"/"In Progress" status_id values
                markCompleted(taskId, statusId);
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

        async function deleteAllAndRefresh(){
            await deleteAll();
            await loadTasks();
        }

        init();
   
    </script>
</body>
</html>