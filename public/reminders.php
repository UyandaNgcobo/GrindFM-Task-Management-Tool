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
        <script>
            requireLogin();

            const rem_list = document.getElementById('reminders-list');
            document.getElementById('clearBtn').addEventListener('click', ()=>{
                deleteAllRemindersAndRefresh();
            })

            rem_list.addEventListener('click', (event) => {
                const clickedCard = event.target.closest('.reminder-cont');

                const reminderId = clickedCard.dataset.reminderId;
                const extraInfo = document.querySelector(`.extraInfo[data-reminder-id="${reminderId}"]`);
                if (extraInfo) {
                    extraInfo.classList.toggle('hidden');
                }
            });

            async function deleteAllRemindersAndRefresh(){
                await deleteAllReminders();
                await render();
            }

            async function render(){
                const result = await loadReminders();
                console.log(result);

                let html = '';
                for (const reminder of result.reminders) {

                    let d = new Date(reminder.trigger_at);

                    let hours = String(d.getHours()).padStart(2, '0');
                    let minutes = String(d.getMinutes()).padStart(2, '0');
                    let trigger_at = `${hours}:${minutes}`

                    html += `
                        <div>
                            <div class="reminder-cont" data-reminder-id="${reminder.reminder_id}">
                                <div class="date-info-cont">
                                    <div class="date">${d.getDate()}</div>
                                    <div class="day">${months[d.getMonth()].substring(0, 3)}</div>
                                </div>
                                <div id="reminder-content-cont">
                                    <div class="title">${reminder.title}</div>
                                    <div class="time"> Remind at: <span>${trigger_at}</span></div>
                                </div>
                            </div> 

                            <div class="extraInfo hidden" data-reminder-id="${reminder.reminder_id}">
                                <div class="extraInfo-inner">
                                    <div class="reminder-description">${reminder.description === null ? "No description available" : reminder.description}</div>
                                    <div id="editBtns">
                                        <button id="modifyDescBtn">Edit</button>
                                        <button id="deleteRemBtn">Delete Reminder</button>
                                    </div>
                                </div>
                            </div>
                        </div>       
                    `;
                }

                rem_list.innerHTML = html;

            }

            render();
        
        </script>

</body>
</html>