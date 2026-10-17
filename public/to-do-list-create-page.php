<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/create-form.css">
    <title>New to-do task | GrindFM</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main class="create-form-main">
        <a class="back-to-types" href="create-page.php"><i class="bi bi-arrow-left" aria-hidden="true"></i> All creation types</a>
        <section class="create-form-heading">
            <span class="form-type-icon"><i class="bi bi-check2-square" aria-hidden="true"></i></span>
            <div>
                <p class="form-eyebrow">TO-DO TASK</p>
                <h1>Add to your list</h1>
                <p class="form-intro">Add as many tasks as you need. When you're finished, choose Done.</p>
            </div>
        </section>

        <form id="createTaskForm" class="creation-form">
            <div class="form-field">
                <label for="nameInput">Task name <span class="required-marker" aria-hidden="true">*</span></label>
                <input id="nameInput" name="title" type="text" maxlength="255" placeholder="What needs to get done?" required>
            </div>
            <div class="form-field">
                <label for="descInput">Description <span class="optional-label">Optional</span></label>
                <textarea id="descInput" name="description" rows="4" placeholder="Add a few details"></textarea>
            </div>
            <div class="form-actions">
                <button class="button button-secondary" id="doneBtn" type="button">Done</button>
                <button class="button button-primary" type="submit">Add task <i class="bi bi-plus-lg" aria-hidden="true"></i></button>
            </div>
            <p id="creation-status" class="creation-status" role="status" aria-live="polite"></p>
        </form>
    </main>
    <?php include 'components/navbar.php'; ?>
    <script src="js/auth-guard.js"></script>
    <script src="js/api.js"></script>
    <script>
        requireLogin();

        const taskForm = document.getElementById("createTaskForm");
        const taskStatus = document.getElementById("creation-status");

        document.getElementById("doneBtn").addEventListener("click", () => {
            window.location.assign("to-do-list.php");
        });

        taskForm.addEventListener("submit", async (event) => {
            event.preventDefault();
            taskStatus.textContent = "";

            try {
                const response = await fetch(`${API_BASE_URL}/tasks`, {
                    method: "POST",
                    credentials: "include",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        title: document.getElementById("nameInput").value.trim(),
                        description: document.getElementById("descInput").value.trim()
                    })
                });
                const result = await response.json();

                if (!response.ok || result.status !== "success") {
                    throw new Error(result.message || "The task could not be created. Please try again.");
                }

                taskForm.reset();
                taskStatus.textContent = "Task added. Add another or choose Done to view your list.";
            } catch (error) {
                taskStatus.textContent = error.message || "The server could not be reached. Please try again.";
            }
        });
    </script>
</body>
</html>
