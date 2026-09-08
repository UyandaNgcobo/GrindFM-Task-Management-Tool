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
                        <div class="date-info-cont">
                            <div class="date">19</div>
                            <div class="day">Wed</div>
                        </div>
                        <div id="reminder-content-cont">
                            <div class="title">George's Birthday Birthday</div>
                            <div class="time">18:00</div>
                        </div>
                    </div>
                    <div class="reminder-cont">
                        <div class="date-info-cont">
                            <div class="date">19</div>
                            <div class="day">Wed</div>
                        </div>
                        <div id="reminder-content-cont">
                            <div class="title">George's Birthday Birthday</div>
                            <div class="time">18:00</div>
                        </div>
                    </div>
                    <div class="reminder-cont">
                        <div class="date-info-cont">
                            <div class="date">19</div>
                            <div class="day">Wed</div>
                        </div>
                        <div id="reminder-content-cont">
                            <div class="title">George's Birthday Birthday</div>
                            <div class="time">18:00</div>
                        </div>
                    </div>
                    <div class="reminder-cont">
                        <div class="date-info-cont">
                            <div class="date">19</div>
                            <div class="day">Wed</div>
                        </div>
                        <div id="reminder-content-cont">
                            <div class="title">George's Birthday Birthday</div>
                            <div class="time">18:00</div>
                        </div>
                    </div>
                    <div class="reminder-cont">
                        <div class="date-info-cont">
                            <div class="date">19</div>
                            <div class="day">Wed</div>
                        </div>
                        <div id="reminder-content-cont">
                            <div class="title">George's Birthday</div>
                            <div class="time">18:00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        <div class="reminder-cont">
                            <div class="date-info-cont">
                                <div class="date">${d.getDate()}</div>
                                <div class="day">${months[d.getMonth()].substring(0, 3)}</div>
                            </div>
                            <div id="reminder-content-cont">
                                <div class="title">${reminder.title}</div>
                                <div class="time"> Remind at: <span>${trigger_at}</span></div>
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