<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css/header.css"> -->
    <link rel="stylesheet" href="css/header.css">
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

        <button id="logInBtn" type="submit">Log in</button>

    </form>

    <div id="result"></div>

    <script src="js/auth-guard.js"></script>
    <script>
        async function fecthAPI(url, options){
            try {
                const response = await fetch(url, options);

                if(!response.ok){
                    showError(`Request failed (${response.status}). Please try again.`);
                    return null;
                }

                const results = await response.json();

            } catch (error) {
                console.error("Network error:", err);
                showError("Can't reach the server. Please check your connection and try again.");
                return null;
            }
        }

        function showError(message) {
            let banner = document.getElementById('error-banner');
            if (!banner) {
                banner = document.createElement('div');
                banner.id = 'error-banner';
                banner.style.cssText = 'background:#c0392b;color:white;padding:10px;text-align:center;';
                document.body.prepend(banner);
            }
            banner.textContent = message;
            banner.style.display = 'block';
        }

        redirectIfLoggedIn();

        const form = document.getElementById("loginForm");
        const result = document.getElementById("result");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const payload = {
                email: document.getElementById("email").value,
                password: document.getElementById("password").value
            };

            const response = await fecthAPI("http://localhost:3000/api/login", {
                method: "POST",
                credentials: "include",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (response.ok && (data.status === "success" || data.status === "already_logged_in")) {
                window.location.replace("index.php");
                return;
            }

            result.textContent = data.message || "Login failed. Please try again.";
        });
    </script>

</body>
</html>