<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }else{

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main>
        <h1>Overview</h1>
       <div id="grid-container">

            <!-- Summary and Stats -->
            <div id="stats-cont">
                <div id="tasks-completed">
                    <div id="tasks-completed-cont">
                        <div id="task-completed-count">254</div>
                        <div id="task-completed-label">Tasks Completed</div>
                    </div>
                    <div class="giant-check"><img src="/Images/check.svg" alt="" srcset=""></div>
                </div>
                <div id="tasks-to-do">
                    <div id="tasks-to-do-count">65</div>
                    <div id="tasks-to-do-label"><a href="to-do-list.php">Task To-Do</a></div>
                </div>
                <div id="tasks-all-tasks">
                    <div id="tasks-all-tasks-count">319</div>
                    <div id="tasks-all-tasks-label">All Tasks</div>
                </div>
                <div id="tasks-reminders">
                    <div id="tasks-reminders-bell"><img src="/Images/bell.svg" alt=""></div>
                    <div id="tasks-reminders-overview-cont">
                        <div class="latest-task">17:00 · Bath</div>
                        <div class="latest-task">19:30 · Maths Study</div>
                        <div class="latest-task">20:15 · Gym</div>
                    </div>
                </div>
            </div>

            <div id="time-cont-wrapper">
                <div id="time-cont">
                    <div id="clock">16:54</div>
                    <div id="date-cont">
                        <div id="date">21 Aug,</div>
                        <div id="day">Thursday</div>
                    </div>
                </div>
            </div>

            <div id="reminders-cont">
                <div id="reminders-heading">
                    Reminders
                </div>
                <div id="dates-row">
                    <div class="date">
                        <div class="date-num">19</div>
                        <div class="day">Wed</div>
                    </div>
                    <div class="date">
                        <div class="date-num">19</div>
                        <div class="day">Wed</div>
                    </div>
                    <div class="date">
                        <div class="date-num">19</div>
                        <div class="day">Wed</div>
                    </div>
                    <div class="date">
                        <div class="date-num">19</div>
                        <div class="day">Wed</div>
                    </div>
                    <div class="date">
                        <div class="date-num">19</div>
                        <div class="day">Wed</div>
                    </div>
                </div>
                <div id="reminders-list-cont">
                        <div class="reminder-task-cont">
                            <div class="icon"><img src="/Images/Alert-circle.svg" alt=""></div>
                            <div class="reminder-task-wrap">
                                <div class="reminder-task">Cook for myself</div>
                                <div class="reminder-time-set">17:00 - 18:00</div>
                            </div>
                        </div>
                        <div class="reminder-task-cont">
                            <div class="icon"><img src="/Images/Alert-circle.svg" alt=""></div>
                            <div class="reminder-task-wrap">
                                <div class="reminder-task">Cook for myself</div>
                                <div class="reminder-time-set">17:00 - 18:00</div>
                            </div>
                        </div>
                        <div class="reminder-task-cont">
                            <div class="icon"><img src="/Images/Alert-circle.svg" alt=""></div>
                            <div class="reminder-task-wrap">
                                <div class="reminder-task">Cook for myself</div>
                                <div class="reminder-time-set">17:00 - 18:00</div>
                            </div>
                        </div>
                </div>
            </div>
            <div id="tasks-cont">
                <div id="tasks-heading">
                    To-Do List
                </div>
                <div id="tasks-list-cont">
                    <div class="task">
                        <div class="task-title">Buy teabags</div>
                        <input class="task-checkbox" type="checkbox"></input>
                    </div>
                    <div class="task">
                        <div class="task-title">Grab batteries by Uya</div>
                        <input class="task-checkbox" type="checkbox"></input>
                    </div>
                    <div class="task">
                        <div class="task-title">Hook up the TV cables</div>
                        <input class="task-checkbox" type="checkbox"></input>
                    </div>
                    <div class="task">
                        <div class="task-title">Get new remote</div>
                        <input class="task-checkbox" type="checkbox"></input>
                    </div>
                    <div class="task">
                        <div class="task-title">Buy flowers for nobody</div>
                        <input class="task-checkbox" type="checkbox"></input>
                    </div>
                </div>
            </div>
            
       </div>
    </main>
    <script src="js/auth-guard.js"></script>
    <script src="js/api.js"></script>
    <script src="js/ui.js"></script>
    <script>
        requireLogin();

        const taskToDoContainer = document.getElementById('tasks-to-do-count');
        const taskCompletedContainer = document.getElementById('task-completed-count');
        const allTasksContainer = document.getElementById('tasks-all-tasks-count');
        const list = document.getElementById('tasks-list-cont');
        startClock();
        
        async function render(){
            const result = await loadTasks();
            taskToDoContainer.textContent = result.count;
            taskCompletedContainer.textContent = result.completedCount;
            allTasksContainer.textContent = result.count + result.completedCount;

            let html = '';

            for (const task of result.tasks) {
                const isChecked = task.status_id === 2 ? "checked" : "";
                html += `
                        <div class="task" data-task-id="${task.task_id}">
                            <div class="task-title">${task.title}</div>
                            <input class="task-checkbox" type="checkbox" ${isChecked}></input>
                        </div>`;
            }

            list.innerHTML = html;
        }

        document.getElementById('tasks-list-cont').addEventListener('change', (e) => {
            if (e.target.type === 'checkbox') {
                const taskDiv = e.target.closest('.task');
                const taskId = taskDiv.dataset.taskId;
                const isChecked = e.target.checked;

                const statusId = isChecked ? 2 : 1; // adjust to your actual "Completed"/"In Progress" status_id values
                markCompleted(taskId, statusId);
            }
        });

        render();
        
    </script>
</body>
</html>