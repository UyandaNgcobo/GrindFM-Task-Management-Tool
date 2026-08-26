<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
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
                <input id="nameInput" type="text" placeholder="Enter Task name">
            </div>
            <div id="desc-input-cont">
                <label for="descInput">Description</label>
                <input id="descInput" type="text" placeholder="Enter Description">
            </div>
            <input type="submit" id="submitBtn" value="Create Task">
        </form>

        <div id="results"></div>
    </main>
    <script>
        const output = document.getElementById("results");

        document.getElementById("createTaskForm").addEventListener ('submit', async (e) =>{

            e.preventDefault()

            const payload = {
                username: "juju",
                email: "examp@icloud.com",
                password: "12345"
            };

            const response = await fetch('http://localhost:3000/api/users', {
                method: 'POST',
                headers: { 'Content-Type' : 'application/json'},
                body: JSON.stringify(payload)
            });

            const result = await response.json();
            console.log("RAW RESPONSE FROM NODE:", result);

            output.innerHTML = result.message;

        });

    </script>
</body>
</html>