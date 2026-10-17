<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/create-form.css">
    <title>Schedule an event | GrindFM</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main class="create-form-main">
        <a class="back-to-types" href="create-page.php"><i class="bi bi-arrow-left" aria-hidden="true"></i> All creation types</a>
        <section class="create-form-heading">
            <span class="form-type-icon"><i class="bi bi-calendar-week" aria-hidden="true"></i></span>
            <div>
                <p class="form-eyebrow">SCHEDULE EVENT</p>
                <h1>Make time for it</h1>
                <p class="form-intro">Add as many events as you need. Choose Done when you're finished.</p>
            </div>
        </section>

        <form id="createScheduleForm" class="creation-form">
            <div class="form-field">
                <label for="scheduleTitle">Event name <span class="required-marker" aria-hidden="true">*</span></label>
                <input id="scheduleTitle" name="title" type="text" maxlength="255" placeholder="What do you have planned?" required>
            </div>
            <div class="form-field">
                <label for="scheduleDescription">Description <span class="optional-label">Optional</span></label>
                <textarea id="scheduleDescription" name="description" rows="3" placeholder="Add a few details"></textarea>
            </div>
            <div class="form-field">
                <label for="scheduleStart">Starts <span class="required-marker" aria-hidden="true">*</span></label>
                <input id="scheduleStart" name="starts_at" type="datetime-local" step="60" required>
            </div>
            <div class="form-field">
                <label for="scheduleEnd">Ends <span class="optional-label">Optional</span></label>
                <input id="scheduleEnd" name="ends_at" type="datetime-local" step="60">
            </div>
            <div class="form-actions">
                <button class="button button-secondary" id="doneBtn" type="button">Done</button>
                <button class="button button-primary" type="submit">Add event <i class="bi bi-plus-lg" aria-hidden="true"></i></button>
            </div>
            <p id="creation-status" class="creation-status" role="status" aria-live="polite"></p>
        </form>
    </main>
    <?php include 'components/navbar.php'; ?>
    <script src="js/auth-guard.js"></script>
    <script>
        requireLogin();

        const scheduleForm = document.getElementById("createScheduleForm");
        const scheduleStart = document.getElementById("scheduleStart");
        const scheduleEnd = document.getElementById("scheduleEnd");
        const scheduleStatus = document.getElementById("creation-status");

        function toLocalDateTimeValue(date) {
            const offset = date.getTimezoneOffset() * 60000;
            return new Date(date.getTime() - offset).toISOString().slice(0, 16);
        }

        scheduleStart.min = toLocalDateTimeValue(new Date());
        scheduleStart.addEventListener("input", () => {
            scheduleEnd.min = scheduleStart.value;
            if (scheduleEnd.value && scheduleEnd.value < scheduleStart.value) {
                scheduleEnd.value = "";
            }
        });

        document.getElementById("doneBtn").addEventListener("click", () => {
            window.location.assign("schedule.php");
        });

        scheduleForm.addEventListener("submit", async (event) => {
            event.preventDefault();
            scheduleStatus.textContent = "";

            try {
                const response = await fetch(`${API_BASE_URL}/schedules`, {
                    method: "POST",
                    credentials: "include",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        title: document.getElementById("scheduleTitle").value.trim(),
                        description: document.getElementById("scheduleDescription").value.trim(),
                        starts_at: scheduleStart.value,
                        ends_at: scheduleEnd.value || null
                    })
                });
                const result = await response.json();

                if (!response.ok || result.status !== "success") {
                    throw new Error(result.message || "The event could not be created. Please try again.");
                }

                scheduleForm.reset();
                scheduleEnd.min = "";
                scheduleStart.min = toLocalDateTimeValue(new Date());
                scheduleStatus.textContent = "Event added. Add another or choose Done to view your schedule.";
            } catch (error) {
                scheduleStatus.textContent = error.message || "The server could not be reached. Please try again.";
            }
        });
    </script>
</body>
</html>
