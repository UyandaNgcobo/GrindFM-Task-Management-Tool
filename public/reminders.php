<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Review and manage your reminders.">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/reminders.css">
    <title>Reminders | GrindFM</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main class="reminders-main">
        <section class="reminders-heading" aria-labelledby="reminders-title">
            <div>
                <p class="reminders-eyebrow">AT THE RIGHT MOMENT</p>
                <h1 id="reminders-title">Your reminders</h1>
                <p class="reminders-intro">A little nudge for the things you don't want to forget.</p>
            </div>
            <a class="reminder-add-button" href="create-page.php">
                <i class="bi bi-plus-lg" aria-hidden="true"></i>
                Create something
            </a>
        </section>

        <section class="reminders-panel" aria-label="Reminder list">
            <div class="reminders-toolbar">
                <div class="reminder-filters" role="group" aria-label="Filter reminders">
                    <button class="reminder-filter is-active" type="button" data-filter="all" aria-pressed="true">
                        All <span class="filter-count" data-count="all">0</span>
                    </button>
                    <button class="reminder-filter" type="button" data-filter="upcoming" aria-pressed="false">
                        Upcoming <span class="filter-count" data-count="upcoming">0</span>
                    </button>
                    <button class="reminder-filter" type="button" data-filter="past" aria-pressed="false">
                        Past <span class="filter-count" data-count="past">0</span>
                    </button>
                </div>
                <button id="clearBtn" class="clear-reminders-button" type="button" disabled>
                    Clear all
                </button>
            </div>
            <p id="reminders-status" class="reminders-status" role="status" aria-live="polite"></p>
            <div id="reminders-list" class="reminders-list" aria-live="polite">
                <p class="reminders-state">Loading reminders…</p>
            </div>
        </section>
    </main>
    <?php include 'components/navbar.php'; ?>

    <script src="js/auth-guard.js"></script>
    <script src="js/api.js"></script>
    <script src="js/reminders.js"></script>
</body>
</html>
