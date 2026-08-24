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
        <form action="" method="post">
            <div id="name-input-cont">
                <label for="nameInput">Task Name</label>
                <input id="nameInput" type="text" placeholder="Enter Task name">
            </div>
            <div id="desc-input-cont">
                <label for="descInput">Description</label>
                <input id="descInput" type="text" placeholder="Enter Description">
            </div>
        </form>
    </main>
</body>
</html>