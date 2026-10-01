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
<style>
    input{
    padding: 1rem;
    background-color: #F7F7F7;
    border-radius: 3rem;
    color: #B3B3B3;
    font-size: 16px;
    border: none;
}
</style>
</head>
<body>

<main>
    <p class="auth-subheading">Create an account <br> and start Grinding<br> Today.</p>
    <!-- <a href="/" class="auth-logo">Grind.<span>FM</span></a> -->

    <form id="loginForm">
        <div class="login-auth-field-cont">
            <div class="log-up-cont">
                <h1 class="auth-heading">Sign up</h1>
                <p class="auth-switch">Already have an account? <a id="sign-up-link" href="login.php">Log in</a></p>
            </div>
            <div class="auth-field-cont">
                    <div class="auth-field">
                        <input id="email" type="email" placeholder="example@gmail.com" required>
                        <input id="username" type="text" placeholder="Jane Doe" required>
                        <input id="password" type="password" placeholder="............" required>
                    </div>
                    <div class="auth-field-extra">
                        <a href="#" id="remember-me">Remember Me</a>
                        <a href="#" id="forgot-password">Forgot Password</a>
                    </div>
            </div>
        </div>

        <button id="submitBtn" class="auth-submit" type="submit">Sign Up</button>
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
