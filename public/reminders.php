<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/reminders.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Reminders</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
        <main>
            <div id="reminders-header">
            Reminders
        </div>
        <div id="create-new-reminder">
            <div id="reminder-list-cont">
                <div id="create-new-reminder-controls">
                    <a id="addBtn" href="reminders-create-page.php">Add Reminder</a>
                    <button id="clearBtn">Clear All</button>
                </div>

                <div id="reminders-list">
                    <div class="reminder-cont">
                        
                    </div>
                </div>
            </div>
        </div>
        <div id="notificationContainer"></div>
        </main>

        <script src="js/api.js"></script>
        <script src="js/ui.js"></script>
        <script src="js/auth-guard.js"></script>
        <script src="js/auth-helpers.js"></script>
        <script src="js/reminders.js"></script>

</body>
</html>