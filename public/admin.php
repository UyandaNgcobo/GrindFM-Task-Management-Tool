<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main>
        <div id="users"></div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            loadUsers();
        });

    const usersContainer = document.getElementById("users");

        async function loadUsers() {
            const response = await fetch("http://localhost:3000/api/users");

            const result = await response.json();

            console.log("PHP RESPONSE:", result);

            for (const user of result.users) {
                usersContainer.innerHTML += `
                    <div class="user-cont">
                        <div class="name">${user.username}</div>
                        <div class="email">${user.email}</div>
                    </div>
                `;
            }
        }
</script>
</body>
</html>