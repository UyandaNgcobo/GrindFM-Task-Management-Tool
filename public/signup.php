<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/auth.css">
<title>Sign up — Grind.FM</title>
</head>
<body>

<div class="auth-shell">
    <div class="auth-panel">
        <a href="/" class="auth-logo">Grind.<span>FM</span></a>

        <h1 class="auth-heading">Sign up</h1>
        <p class="auth-subheading">Welcome to GrindFM - lets create an account.</p>

        <div id="authError" class="auth-error"></div>

        <form id="signupForm">
            <div class="auth-field">
                <label for="username">Username</label>
                <input id="username" type="text" placeholder="Uyanda Ngcobo" required>
            </div>

            <div class="auth-field">
                <label for="email">Email</label>
                <input id="email" type="email" placeholder="example@gmail.com" required>
            </div>

            <div class="auth-field">
                <label for="password">Password</label>
                <input id="password" type="password" placeholder="............" required minlength="8">
            </div>

            <div class="auth-field">
                <label for="confirmPassword">Confirm Password</label>
                <input id="confirmPassword" type="password" placeholder="............" required minlength="8">
            </div>

            <button id="submitBtn" class="auth-submit" type="submit">Sign Up</button>
        </form>

        <p class="auth-switch">Already have an account? <a href="login.php">Log In</a></p>
    </div>

    <!-- <div class="auth-visual" aria-hidden="true">
        <svg viewBox="0 0 600 800" preserveAspectRatio="xMidYMid slice">
            <polygon points="0,420 300,220 600,420 600,800 0,800" fill="#c3c6cd" />
            <polygon points="0,420 300,220 300,800 0,800" fill="#b6b9c1" opacity="0.6" />
            <polygon points="300,220 600,420 300,800" fill="#aeb1ba" opacity="0.5" />
            <polygon points="0,0 600,0 600,300 300,120 0,260" fill="#eceef1" />
        </svg>
    </div> -->
</div>

<script src="js/auth-guard.js"></script>
<script src="js/auth-helpers.js"></script>
<script>
    redirectIfLoggedIn();

    const form = document.getElementById('signupForm');
    const submitBtn = document.getElementById('submitBtn');
    const errorBox = document.getElementById('authError');

    function showAuthError(message) {
        errorBox.textContent = message;
        errorBox.classList.add('visible');
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        errorBox.classList.remove('visible');

        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (password !== confirmPassword) {
            showAuthError('Passwords do not match.');
            return;
        }

        submitBtn.disabled = true;
        submitBtn.textContent = 'Creating account...';

        const payload = {
            username: document.getElementById('username').value,
            email: document.getElementById('email').value,
            password: password
        };

        const data = await fetchAPI('http://localhost:3000/api/signup', {
            method: 'POST',
            credentials: 'include',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        submitBtn.disabled = false;
        submitBtn.textContent = 'Sign Up';

        if (data && data.status === 'success') {
            window.location.replace('login.php');
            return;
        }

        showAuthError(data?.message || 'Signup failed. Please try again.');
    });
</script>

</body>
</html>
