<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/auth.css">
<title>Log in — Grind.FM</title>
</head>
<body>

<div class="auth-shell">
    <div class="auth-panel">
        <a href="/" class="auth-logo">Grind.<span>FM</span></a>

        <h1 class="auth-heading">log in</h1>
        <p class="auth-subheading">Welcome back to GrindFM</p>

        <div id="authError" class="auth-error"></div>

        <form id="loginForm">
            <div class="auth-field">
                <label for="email">Email</label>
                <input id="email" type="email" placeholder="example@gmail.com" required>
            </div>

            <div class="auth-field">
                <label for="password">Password</label>
                <input id="password" type="password" placeholder="............" required>
            </div>

            <button id="submitBtn" class="auth-submit" type="submit">Log in</button>
        </form>

        <p class="auth-switch">Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>

    <div class="auth-visual" aria-hidden="true">
        <svg viewBox="0 0 600 800" preserveAspectRatio="xMidYMid slice">
            <polygon points="0,420 300,220 600,420 600,800 0,800" fill="#c3c6cd" />
            <polygon points="0,420 300,220 300,800 0,800" fill="#b6b9c1" opacity="0.6" />
            <polygon points="300,220 600,420 300,800" fill="#aeb1ba" opacity="0.5" />
            <polygon points="0,0 600,0 600,300 300,120 0,260" fill="#eceef1" />
        </svg>
    </div>
</div>

<script src="js/auth-guard.js"></script>
<script src="js/auth-helpers.js"></script>
<script>
    redirectIfLoggedIn();

    const form = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    const errorBox = document.getElementById('authError');

    function showAuthError(message) {
        errorBox.textContent = message;
        errorBox.classList.add('visible');
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        errorBox.classList.remove('visible');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Logging in...';

        const payload = {
            email: document.getElementById('email').value,
            password: document.getElementById('password').value
        };

        const data = await fetchAPI('http://localhost:3000/api/login', {
            method: 'POST',
            credentials: 'include',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        submitBtn.disabled = false;
        submitBtn.textContent = 'Log in';

        if (data && (data.status === 'success' || data.status === 'already_logged_in')) {
            window.location.replace('index.php');
            return;
        }

        showAuthError(data?.message || 'Login failed. Please try again.');
    });
</script>

</body>
</html>
