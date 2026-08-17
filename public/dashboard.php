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
                <div id="tasks-completed"></div>
                <div id="tasks-to-do"></div>
                <div id="tasks-all-tasks"></div>
                <div id="tasks-reminders"></div>
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

            <div id="reminders-cont">Reminders</div>
            <div id="tasks-cont">
                <div id="tasks-heading">
                    To-Do List
                </div>
                <div id="tasks-list-cont">
                    list
                </div>
            </div>
            
       </div>
    </main>
</body>
</html>