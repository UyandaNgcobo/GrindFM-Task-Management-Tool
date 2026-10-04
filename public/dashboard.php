<?php
    session_start();

    // if (!isset($_SESSION['user_id'])) {
    //     header("Location: login.php");
    //     exit;
    // }else{

    // }
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
        <div class="dashboard-elements-container">
            <div class="completed-to-do-container">
                <div class="dashboard-tile-container">
                    <div class="dashboard-tile">
                        <div class="dashboard-tile-title"></div>
                        <div class="dashbaord-title-value" id="completed-tasks-value"></div>
                    </div>
                    <div class="dashboard-tile">
                        <div class="dashboard-tile-title"></div>
                        <div class="dashbaord-title-value" id="to-do-tasks-value"></div>
                    </div>
                </div>
                <div class="dashboard-timeline-container"></div>
                <div class="dashboard-summary-container">
                    <div class="dashboard-graph"></div>
                    <div class="dashboard-graph-description"></div>
                </div>

            </div>
        </div>
    </main>

    <script src="js/auth-guard.js"></script>
    <script src="js/api.js"></script>
    <script src="js/ui.js"></script>
        <script >
        requireLogin();
    </script>
    <script>

        const taskToDoContainer = document.getElementById('tasks-to-do-count');
        const taskCompletedContainer = document.getElementById('task-completed-count');
        const allTasksContainer = document.getElementById('tasks-all-tasks-count');
        const list = document.getElementById('tasks-list-cont');
        const rem_list = document.getElementById('tasks-reminders-overview-cont');
        startClock();

        async function render(){
            const result = await loadTasks();
            const reminders = await loadReminders();

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

            if(html == ''){
                list.innerHTML = "Nothing to report here...";
            }else{
                list.innerHTML = html;
            }
            

            let rem_html = ''

            for (let i = 0; i < reminders.reminders.length; i++) {
                // console.log(reminders.reminders)

                let d = new Date(reminders.reminders[i].trigger_at)
                let hours = String(d.getHours()).padStart(2, "0");
                let minutes = String(d.getMinutes()).padStart(2, "0");
                let trigger_at = `${hours}:${minutes}`
                rem_html += `
                    <div class="latest-task">${trigger_at} · ${reminders.reminders[i].title}</div>`;
            }

            rem_list.innerHTML = rem_html;
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

        updateTimeline();

        render();
        
    </script>
</body>
</html>