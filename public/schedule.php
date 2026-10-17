<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/schedule.css">
    <title>Schedule | GrindFM</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main class="schedule-main">
        <div class="schedule-heading">
            <div>
                <p class="schedule-eyebrow">PLAN AHEAD</p>
                <h1>Your schedule</h1>
                <p class="schedule-intro">A clear view of what's coming up.</p>
            </div>
            <a class="schedule-add-button" href="schedule-create-page.php"><i class="bi bi-plus-lg" aria-hidden="true"></i> Add event</a>
        </div>
        <p id="schedule-status" class="schedule-status" role="status" aria-live="polite"></p>
        <section id="schedule-list" class="schedule-list" aria-label="Scheduled events"></section>
    </main>
    <?php include 'components/navbar.php'; ?>
    <script src="js/auth-guard.js"></script>
    <script>
        requireLogin();

        const scheduleList = document.getElementById("schedule-list");
        const scheduleStatus = document.getElementById("schedule-status");

        function formatScheduleDate(value, options) {
            const date = new Date(String(value).replace(" ", "T"));
            if (Number.isNaN(date.getTime())) {
                return "Date unavailable";
            }
            return new Intl.DateTimeFormat(undefined, options).format(date);
        }

        function createScheduleCard(event) {
            const card = document.createElement("article");
            card.className = "schedule-card";

            const dateBadge = document.createElement("div");
            dateBadge.className = "schedule-date";
            const dateDay = document.createElement("span");
            dateDay.className = "schedule-date-day";
            dateDay.textContent = formatScheduleDate(event.starts_at, { day: "2-digit" });
            const dateMonth = document.createElement("span");
            dateMonth.className = "schedule-date-month";
            dateMonth.textContent = formatScheduleDate(event.starts_at, { month: "short" });
            dateBadge.append(dateDay, dateMonth);

            const details = document.createElement("div");
            details.className = "schedule-details";
            const title = document.createElement("h2");
            title.textContent = event.title;
            const time = document.createElement("p");
            time.className = "schedule-time";
            const startText = formatScheduleDate(event.starts_at, {
                weekday: "short",
                hour: "numeric",
                minute: "2-digit"
            });
            const endText = event.ends_at
                ? formatScheduleDate(event.ends_at, { hour: "numeric", minute: "2-digit" })
                : "";
            time.textContent = endText ? `${startText} – ${endText}` : startText;
            details.append(title, time);

            if (event.description) {
                const description = document.createElement("p");
                description.className = "schedule-description";
                description.textContent = event.description;
                details.append(description);
            }

            const deleteButton = document.createElement("button");
            deleteButton.className = "schedule-delete";
            deleteButton.type = "button";
            deleteButton.dataset.scheduleId = event.schedule_id;
            deleteButton.setAttribute("aria-label", `Delete ${event.title}`);
            deleteButton.innerHTML = '<i class="bi bi-trash3" aria-hidden="true"></i>';
            card.append(dateBadge, details, deleteButton);
            return card;
        }

        async function loadSchedule() {
            scheduleStatus.textContent = "";
            scheduleList.replaceChildren();

            try {
                const response = await fetch(`${API_BASE_URL}/schedules`, {
                    credentials: "include"
                });
                const result = await response.json();
                if (!response.ok || result.status !== "success") {
                    throw new Error(result.message || "Your schedule could not be loaded.");
                }

                if (result.schedules.length === 0) {
                    const emptyState = document.createElement("p");
                    emptyState.className = "schedule-empty";
                    emptyState.textContent = "No events yet. Add one to start planning.";
                    scheduleList.append(emptyState);
                    return;
                }

                result.schedules.forEach((event) => scheduleList.append(createScheduleCard(event)));
            } catch (error) {
                scheduleStatus.textContent = error.message || "The server could not be reached. Please try again.";
            }
        }

        scheduleList.addEventListener("click", async (event) => {
            const deleteButton = event.target.closest(".schedule-delete");
            if (!deleteButton) {
                return;
            }

            try {
                const response = await fetch(
                    `${API_BASE_URL}/schedules/${deleteButton.dataset.scheduleId}`,
                    { method: "DELETE", credentials: "include" }
                );
                const result = await response.json();
                if (!response.ok || result.status !== "success") {
                    throw new Error(result.message || "The event could not be deleted.");
                }
                await loadSchedule();
            } catch (error) {
                scheduleStatus.textContent = error.message || "The server could not be reached. Please try again.";
            }
        });

        loadSchedule();
    </script>
</body>
</html>
