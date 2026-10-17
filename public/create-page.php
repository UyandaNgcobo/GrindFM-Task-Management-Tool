<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/create-page.css">
    <title>Create something | GrindFM</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main class="create-page-main">
        <section class="create-intro" aria-labelledby="create-title">
            <p class="create-eyebrow">MAKE IT HAPPEN</p>
            <h1 id="create-title">What are we <span>creating?</span></h1>
            <p class="create-description">Choose what you want to add. You can keep creating until you're ready to head back.</p>
        </section>

        <section class="create-options" aria-label="Choose what to create">
            <a class="create-option create-option-todo" href="to-do-list-create-page.php">
                <span class="option-icon"><i class="bi bi-check2-square" aria-hidden="true"></i></span>
                <span class="option-copy">
                    <span class="option-title">To-do task</span>
                    <span class="option-description">Capture something you need to get done.</span>
                </span>
                <i class="bi bi-arrow-up-right option-arrow" aria-hidden="true"></i>
            </a>
            <a class="create-option create-option-reminder" href="reminders-create-page.php">
                <span class="option-icon"><i class="bi bi-bell" aria-hidden="true"></i></span>
                <span class="option-copy">
                    <span class="option-title">Reminder</span>
                    <span class="option-description">Pick a date and time to be reminded.</span>
                </span>
                <i class="bi bi-arrow-up-right option-arrow" aria-hidden="true"></i>
            </a>
            <a class="create-option create-option-schedule" href="schedule-create-page.php">
                <span class="option-icon"><i class="bi bi-calendar-week" aria-hidden="true"></i></span>
                <span class="option-copy">
                    <span class="option-title">Schedule event</span>
                    <span class="option-description">Set aside time for what's coming up.</span>
                </span>
                <i class="bi bi-arrow-up-right option-arrow" aria-hidden="true"></i>
            </a>
        </section>
    </main>
    <?php include 'components/navbar.php'; ?>
</body>
</html>
