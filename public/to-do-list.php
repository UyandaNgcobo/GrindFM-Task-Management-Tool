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
        async function init() {
            await requireLogin();
            await loadTasks();
        }

        init();

       async function loadTasks(){
            const response = await fetch('http://localhost:3000/api/task', {
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
                    <div class="task-to-do-cont">
                        <div class="task">${task.title}</div>
                        <input type="checkbox" name="" id="">
                    </div>`;
                }

                list.innerHTML = html;
        }

        async function clearAll(){

            const response = await fetch('http://localhost:3000/api/task', {
                method: "DELETE",
                credentials: 'include'
            })

            const result = await response.json();
        }
            
    </script>
</body>
</html>