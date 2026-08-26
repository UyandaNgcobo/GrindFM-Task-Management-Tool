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
        <table id="users"></table>
    </main>
    <div id="users"></div>

<script>
    const usersContainer = document.getElementById("users");

    async function loadUsers() {
        const response = await fetch("http://localhost:3000/api/users");

        const result = await response.json();

        let table = `
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
        `;

        for (const user of result.users) {
            table += `
                <tr>
                    <td>${user.user_id}</td>
                    <td>${user.username}</td>
                    <td>${user.email}</td>
                </tr>
            `;
        }

        table += `
                </tbody>
            </table>
        `;

        usersContainer.innerHTML = table;
    }

    loadUsers();
</script>
</body>
</html>