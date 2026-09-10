<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/reminders-create.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Document</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main>
        <div id="reminders-create-page-header">
            Reminders
        </div>
        <div id="container">
            <form id="createReminderForm" method="post">
                <div id="name-input-cont">
                    <label for="nameInput">Task Name</label>
                    <input id="nameInput" type="text" placeholder="Enter reminder" required>
                </div>
                <div id="desc-input-cont">
                    <label for="descInput">Description</label>
                    <input id="descInput" type="text" placeholder="Enter Description">
                </div>
                <input type="text" id="reminderDate" placeholder="Pick a date..." required>
                <div id="formBtnCont">
                    <input type="submit" id="submitBtn" value="Create Reminder">
                    <button id="doneBtn">Done</button>
                </div>
            </form>
            
        </div>
           
    </main>
    

    <script src="js/auth-guard.js"></script>
    <script src="js/ui.js"></script>
    <script>
        requireLogin();
        flatpickr("#reminderDate", {
            enableTime: true,
            enableSeconds: true,
            dateFormat: "Y-m-d H:i:S",
            minDate: "today",
            inline: true,
        });

        const form = document.getElementById('createReminderForm');
        const doneBtn = document.getElementById('doneBtn');

        doneBtn.addEventListener('click', () => {
            window.location.replace("reminders.php");
        });

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const trigger_at = document.getElementById('reminderDate').value;

            const payload = {
                title: document.getElementById("nameInput").value,
                description: document.getElementById("descInput").value,
                trigger_at: trigger_at
            };

            const response = await fetch("http://localhost:3000/api/reminders", {
                method: "POST",
                credentials: "include",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (response.ok) {
                displayInternalNotification(data);
                setTimeout(() => {
                    form.reset();
                }, 1500); // give the toast a moment to actually be seen before navigating away
                return;
            }


        });
    </script>
</body>
</html>