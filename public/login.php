<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/auth.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
<title>Log in — Grind.FM</title>
</head>
<body>

<main>
    <p class="auth-subheading">Login to <br> get back on <br> the grind.</p>
    <!-- <a href="/" class="auth-logo">Grind.<span>FM</span></a> -->

    <form id="loginForm">
        <div class="login-auth-field-cont">
            <div class="log-up-cont">
                <h1 class="auth-heading">log in</h1>
                <p class="auth-switch">Don't have an account? <a id="sign-up-link" href="signup.php">Sign up</a></p>
            </div>
            <div class="auth-field-cont">
                    <div class="auth-field">
                        <input id="email" type="email" placeholder="example@gmail.com" required>
                        <input id="password" type="password" placeholder="............" required>
                    </div>
                    <div class="auth-field-extra">
                        <a href="#" id="remember-me">Remember Me</a>
                        <a href="#" id="forgot-password">Forgot Password</a>
                    </div>
            </div>
        </div>

        <button id="submitBtn" class="auth-submit" type="submit">Log in</button>
    </form>
<script src="js/auth-guard.js"></script>
<script src="js/auth-helpers.js"></script>
<script>
    const inputs = document.querySelectorAll('input');

inputs.forEach(input => {
    input.addEventListener('blur', () => {
        // Forces iOS to recalculate the page position
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
    redirectIfLoggedIn();

    const form = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    const errorBox = document.getElementById('authError');

    // function showAuthError(message) {
    //     errorBox.textContent = message;
    //     errorBox.classList.add('visible');
    // }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        submitBtn.disabled = true;
        submitBtn.textContent = 'Logging in...';

        const payload = {
            email: document.getElementById('email').value,
            password: document.getElementById('password').value
        };

        const data = await fetchAPI(`http://${window.location.hostname}:4000/api/login`, {
            method: 'POST',
            credentials: 'include',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        submitBtn.disabled = false;
        submitBtn.textContent = 'Log in';

        if (data && (data.status === 'success' || data.status === 'already_logged_in')) {
            window.location.replace('dashboard.php');
            return;
        }

        // showAuthError(data?.message || 'Login failed. Please try again.');
    });
</script>

</body>
</html>
