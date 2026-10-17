<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/create-form.css">
    <title>New reminder | GrindFM</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main class="create-form-main">
        <a class="back-to-types" href="create-page.php"><i class="bi bi-arrow-left" aria-hidden="true"></i> All creation types</a>
        <section class="create-form-heading">
            <span class="form-type-icon"><i class="bi bi-bell" aria-hidden="true"></i></span>
            <div>
                <p class="form-eyebrow">REMINDER</p>
                <h1>Set a reminder</h1>
                <p class="form-intro">Add as many reminders as you need. Choose Done when you're finished.</p>
            </div>
        </section>

        <form id="createReminderForm" class="creation-form">
            <div class="form-field">
                <label for="nameInput">Reminder name <span class="required-marker" aria-hidden="true">*</span></label>
                <input id="nameInput" name="title" type="text" maxlength="255" placeholder="What should you remember?" required>
            </div>
            <div class="form-field">
                <label for="descInput">Description <span class="optional-label">Optional</span></label>
                <textarea id="descInput" name="description" rows="3" placeholder="Add a few details"></textarea>
            </div>
            <div class="form-field">
                <label for="reminderDate">Date and time <span class="required-marker" aria-hidden="true">*</span></label>
                <input id="reminderDate" name="trigger_at" type="datetime-local" step="60" required>
            </div>
            <div class="form-actions">
                <button class="button button-secondary" id="doneBtn" type="button">Done</button>
                <button class="button button-primary" type="submit">Add reminder <i class="bi bi-plus-lg" aria-hidden="true"></i></button>
            </div>
            <p id="creation-status" class="creation-status" role="status" aria-live="polite"></p>
        </form>
    </main>
    <?php include 'components/navbar.php'; ?>
    <script src="js/auth-guard.js"></script>
    <script>
        requireLogin();

        const reminderForm = document.getElementById("createReminderForm");
        const reminderDate = document.getElementById("reminderDate");
        const reminderStatus = document.getElementById("creation-status");

        function toLocalDateTimeValue(date) {
            const offset = date.getTimezoneOffset() * 60000;
            return new Date(date.getTime() - offset).toISOString().slice(0, 16);
        }

        reminderDate.min = toLocalDateTimeValue(new Date());

        document.getElementById("doneBtn").addEventListener("click", () => {
            window.location.assign("reminders.php");
        });

        reminderForm.addEventListener("submit", async (event) => {
            event.preventDefault();
            reminderStatus.textContent = "";

            try {
                const response = await fetch(`${API_BASE_URL}/reminders`, {
                    method: "POST",
                    credentials: "include",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        title: document.getElementById("nameInput").value.trim(),
                        description: document.getElementById("descInput").value.trim(),
                        trigger_at: reminderDate.value
                    })
                });
                const result = await response.json();

                if (!response.ok || result.status !== "success") {
                    throw new Error(result.message || "The reminder could not be created. Please try again.");
                }

                reminderForm.reset();
                reminderDate.min = toLocalDateTimeValue(new Date());
                reminderStatus.textContent = "Reminder added. Add another or choose Done to view your reminders.";
            } catch (error) {
                reminderStatus.textContent = error.message || "The server could not be reached. Please try again.";
            }
        });
    </script>
</body>
</html>
