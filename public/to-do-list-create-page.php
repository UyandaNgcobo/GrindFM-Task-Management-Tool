<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/to-do-list-create.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main>
        <div id="header-and-doneBtn">
            <div id="to-do-list-create-page-header">To-Do List</div>
            <Button id="cancelBtn">Cancel</Button>
        </div>
        <form id="createTaskForm" method="post">
            <div id="name-input-cont">
                <label for="nameInput">Task Name</label>
                <input id="nameInput" type="text" placeholder="Enter Task name" required>
            </div>
            <div id="desc-input-cont">
                <label for="descInput">Description</label>
                <input id="descInput" type="text" placeholder="Enter Description">
            </div>
            <div id="formBtn">
                <input type="submit" id="submitBtn" value="Create Task">
                <button id="doneBtn">Done</button>
            </div>
        </form>

        <div id="results"></div>
    </main>
     <script src="js/auth-guard.js"></script>
     <script src="js/api.js"></script>
     <script src="js/ui.js"></script>
    <script>
       requireLogin();

const form = document.getElementById("createTaskForm");
const result = document.getElementById("results");
const doneBtn = document.getElementById("doneBtn");

doneBtn.addEventListener('click', () => {
    window.location.replace("to-do-list.php");
})

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const payload = {
        title: document.getElementById("nameInput").value,
        description: document.getElementById("descInput").value
    };

    const response = await fetch("http://localhost:3000/api/tasks", {
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

    </script>
</body>
</html>