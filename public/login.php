<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css/header.css"> -->
    <link rel="stylesheet" href="css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <title>Login</title>
</head>

<body>

   

    <form id="loginForm">
         <h1>Log into GrindFM</h1>

        <div>
            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                placeholder="Enter your email"
                required
            >
        </div>

        <div>
            <label for="password">Password</label>
            <input
                id="password"
                type="password"
                placeholder="Enter your password"
                required
            >
        </div>

        <button type="submit">Log in</button>

    </form>

    <div id="result"></div>

    <script>
        const form = document.getElementById("loginForm");
        const result = document.getElementById("result");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const payload = {
                email: document.getElementById("email").value,
                password: document.getElementById("password").value
            };

            const response = await fetch("http://localhost:3000/api/login", {
                method: "POST",
                credentials: "include",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(payload)
            });

            const data = await response.text();

            console.log(data);

            result.textContent = data.message;
        });
    </script>

</body>
</html>