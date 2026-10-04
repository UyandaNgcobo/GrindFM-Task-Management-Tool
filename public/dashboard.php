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
    <?php include 'components/navbar.php'; ?>
    <main>
        <div class="dashboard-elements-container">
            <h1 id="dashboard-title">A quick overview <br>at your productivity</h1>
            <div class="dashboard-tile-container">
                <div class="dashboard-tile">
                    <div class="dashboard-tile-title">Completed</div>
                    <div class="dashbaord-title-value" id="completed-tasks-value">254</div>
                </div>
                <div class="dashboard-tile">
                    <div class="dashboard-tile-title">To-do</div>
                    <div class="dashbaord-title-value" id="to-do-tasks-value">63</div>
                </div>
            </div>
            <div class="dashboard-heatmap-container" id="heatmap">

            </div>
            <div class="dashboard-summary-container">
                <div class="dashboard-graph"></div>
                <div class="dashboard-graph-description"></div>
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

        // const taskToDoContainer = document.getElementById('tasks-to-do-count');
        // const taskCompletedContainer = document.getElementById('task-completed-count');
        // const allTasksContainer = document.getElementById('tasks-all-tasks-count');
        // const list = document.getElementById('tasks-list-cont');
        // const rem_list = document.getElementById('tasks-reminders-overview-cont');
        // startClock();

        async function renderHeatmap() {
    const container = document.getElementById('heatmap');
    
    // Fetch your grouped data from the API
    // Assuming fetchAPI() returns the JSON dictionary mapped above
    const activityData = await fetchAPI('http://localhost:4000/api/tasks/activity'); 

    // Determine color level based on task count
    function getLevel(count) {
        if (count === 0) return 0;
        if (count <= 2) return 1;
        if (count <= 4) return 2;
        if (count <= 6) return 3;
        return 4;
    }

    // Generate 365 days, starting from exactly one year ago
    const today = new Date();
    const startDate = new Date();
    startDate.setDate(today.getDate() - 364);

    for (let i = 0; i <= 364; i++) {
        // Create the current date in the loop
        const currentDate = new Date(startDate);
        currentDate.setDate(startDate.getDate() + i);
        
        // Format to YYYY-MM-DD to match the database output
        const dateString = currentDate.toISOString().split('T')[0];
        
        // Check if this date exists in our backend data, default to 0
        const taskCount = activityData[dateString] || 0;
        const level = getLevel(taskCount);

        // Create the HTML block
        const block = document.createElement('div');
        block.classList.add('day-block');
        block.setAttribute('data-level', level);
        
        // Optional: Add a standard tooltip
        block.title = `${taskCount} tasks on ${dateString}`;

        container.appendChild(block);
    }
}

        async function render(){
            const result = await loadTasks();
            const reminders = await loadReminders();

            // taskToDoContainer.textContent = result.count;
            // taskCompletedContainer.textContent = result.completedCount;
            // allTasksContainer.textContent = result.count + result.completedCount;

            // let html = '';

            // for (const task of result.tasks) {
            //     const isChecked = task.status_id === 2 ? "checked" : "";
            //     html += `
            //             <div class="task" data-task-id="${task.task_id}">
            //                 <div class="task-title">${task.title}</div>
            //                 <input class="task-checkbox" type="checkbox" ${isChecked}></input>
            //             </div>`;
            // }

            // if(html == ''){
            //     list.innerHTML = "Nothing to report here...";
            // }else{
            //     list.innerHTML = html;
            // }
            

            // let rem_html = ''

            // for (let i = 0; i < reminders.reminders.length; i++) {
            //     // console.log(reminders.reminders)

            //     let d = new Date(reminders.reminders[i].trigger_at)
            //     let hours = String(d.getHours()).padStart(2, "0");
            //     let minutes = String(d.getMinutes()).padStart(2, "0");
            //     let trigger_at = `${hours}:${minutes}`
            //     rem_html += `
            //         <div class="latest-task">${trigger_at} · ${reminders.reminders[i].title}</div>`;
            // }

            // rem_list.innerHTML = rem_html;
        }

        // document.getElementById('tasks-list-cont').addEventListener('change', (e) => {
        //     if (e.target.type === 'checkbox') {
        //         const taskDiv = e.target.closest('.task');
        //         const taskId = taskDiv.dataset.taskId;
        //         const isChecked = e.target.checked;

        //         const statusId = isChecked ? 2 : 1; // adjust to your actual "Completed"/"In Progress" status_id values
        //         markCompleted(taskId, statusId);
        //     }
        // });

        // updateTimeline();

        renderHeatmap()
        render();
        
    </script>
</body>
</html>