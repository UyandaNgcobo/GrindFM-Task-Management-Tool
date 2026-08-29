<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form id="loginForm">
         <h1>Sign up for GrindFM!</h1>

         <div>
            <label for="username">Username</label>
            <input
                id="username"
                type="text"
                placeholder="Enter your username"
                required
            >
        </div>

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

        <button type="submit">Sign Up</button>

    </form>

    <div id="result"></div>
</body>
<script>
     const form = document.getElementById("loginForm");
        const result = document.getElementById("result");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const payload = {
                username: document.getElementById("username").value,
                email: document.getElementById("email").value,
                password: document.getElementById("password").value
            };

            const response = await fetch("http://localhost:3000/api/signup", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            console.log(data);

            result.textContent = data.message;
        });
</script>
</html>