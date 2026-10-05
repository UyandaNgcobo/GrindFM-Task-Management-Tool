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
            <h1 id="dashboard-title">A quick overview <br>at your <span>productivity</span></h1>
            <div class="dashboard-tile-container">
                <div class="dashboard-tile">
                    <div class="dashboard-tile-title"><i class="bi bi-check-circle-fill"></i>Completed</div>
                    <div class="dashbaord-title-value" id="completed-tasks-value">254</div>
                </div>
                <div class="dashboard-tile">
                    <div class="dashboard-tile-title">To-do</div>
                    <div class="dashbaord-title-value" id="to-do-tasks-value">63</div>
                </div>
            </div>
            <div class="dashboard-heatmap-container" id="heatmap"></div>

            <div class="dashboard-summary-container">
                <div class="circular-progress-container">
                <!-- The viewBox keeps the internal math locked at 120x120 -->
                <svg class="progress-ring" viewBox="0 0 120 120">
                    <circle class="progress-track" stroke="#ebedf0" stroke-width="12" fill="transparent" r="50" cx="60" cy="60"/>
                    <circle class="progress-fill" stroke="#a855f7" stroke-width="12" fill="transparent" r="50" cx="60" cy="60"/>
                </svg>
                
                <div class="progress-text" id="progress-percent">0%</div>
                </div>
                <div class="dashboard-graph-description"><span id="message">Good</span> completion rate,<br>keep it up</div>
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
        // Accept the activity dictionary as an argument
        function renderHeatmap(activityData) {
            const container = document.getElementById('heatmap');
            container.innerHTML = ''; // Clear container to prevent duplicate renders
            
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
                const currentDate = new Date(startDate);
                currentDate.setDate(startDate.getDate() + i);
                
                const dateString = currentDate.toISOString().split('T')[0];
                
                // Grab the count safely from the passed-in dictionary
                const taskCount = (activityData && activityData[dateString]) ? activityData[dateString] : 0;
                const level = getLevel(taskCount);

                const block = document.createElement('div');
                block.classList.add('day-block');
                block.setAttribute('data-level', level);
                block.title = `${taskCount} tasks on ${dateString}`;

                container.appendChild(block);
            }
        }

        async function render(){
            const completedCount = document.getElementById('completed-tasks-value');
            const toDoCount = document.getElementById('to-do-tasks-value');
            const message = document.getElementById('message');
            const result = await loadTasks(); // Assuming this hits /api/tasks via api.js
            const reminders = await loadReminders();

            // 1. Render the Heatmap using the activity data from result
            if (result && result.activity) {
                completedCount.textContent = result.completedCount;
                toDoCount.textContent = result.count;
                let target = result.completedCount / (result.completedCount + result.count) * 100

                if(target <= 20){
                    message.textContent = 'Decent'
                }
                else if(target <= 40){
                    message.textContent = 'Good'
                }       
                else if(target <= 60){
                    message.textContent = 'Great'
                }
                else if(target <= 80){
                    message.textContent = 'Excellent'
                }
                else{
                    message.textContent = 'Outstanding'
                }
                renderHeatmap(result.activity);

                updateCircularProgress(target);
            }

        }

        render();

        function updateCircularProgress(percent) {
            const circle = document.querySelector('.progress-fill');
            const text = document.getElementById('progress-percent');
            
            // 1. Get the radius from the HTML (50)
            const radius = circle.r.baseVal.value;
            
            // 2. Calculate the exact circumference (2 * pi * r)
            const circumference = radius * 2 * Math.PI;
            
            // 3. Set the dash length to the exact circumference
            circle.style.strokeDasharray = `${circumference} ${circumference}`;
            
            // 4. Calculate how much of the line to hide based on the percentage
            const offset = circumference - (percent / 100) * circumference;
            
            // 5. Apply the offset to trigger the CSS transition
            circle.style.strokeDashoffset = offset;
            
            // 6. Update the text in the middle
            text.textContent = `${Math.round(percent)}%`;
        }
    </script>
</body>
</html>