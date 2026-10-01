<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/landing-page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <main>
            <a id="logo" href="/">Grind.<span id="logo-fm">FM</span></a>

            <div class="slogan-wrapper">
                <div class="slogan-primary">Let’s spend less time <span class="slogan-emphasis">planning,</span><br>more time <span class="slogan-emphasis">doing</span></div>
                <div class="slogan-secondary">Plan once. Grind forever.</div>
            </div>
           
            <div class="features-wrapper">
                <div class="features-wrapper-track">
                    <div class="feature-icon-desc-cont">
                        <img class="feature-icon" src="Images/spotify.svg" alt="">
                        <div class="feature-name">Listen to Music</div>
                    </div>
                    <div class="feature-icon-desc-cont">
                        <img class="feature-icon" src="Images/list-check-svgrepo-com.svg" alt="">
                        <div class="feature-name">Create To-do lists</div>
                    </div>
                    <div class="feature-icon-desc-cont">
                        <img class="feature-icon" src="Images/graph-svgrepo-com.svg" alt="">
                        <div class="feature-name">See Insights on your Grind</div>
                    </div>
                    <div class="feature-icon-desc-cont">
                        <img class="feature-icon" src="Images/spotify.svg" alt="">
                        <div class="feature-name">Listen to Music</div>
                    </div>
                    <div class="feature-icon-desc-cont">
                        <img class="feature-icon" src="Images/list-check-svgrepo-com.svg" alt="">
                        <div class="feature-name">Create To-do lists</div>
                    </div>
                    <div class="feature-icon-desc-cont">
                        <img class="feature-icon" src="Images/graph-svgrepo-com.svg" alt="">
                        <div class="feature-name">See Insights on your Grind</div>
                    </div>
                </div>
                
            </div>
            
            <div class="features-wrapper">
                <div class="features-wrapper-track">
                    <div class="feature-icon-desc-cont">
                        <img class="feature-icon" src="Images/bell-svgrepo-com-4.svg" alt="">
                        <div class="feature-name">See Insights on your Grind</div>
                    </div>
                    <div class="feature-icon-desc-cont">
                        <img class="feature-icon" src="Images/acrobat-logo.svg" alt="">
                        <div class="feature-name">Export tasks to PDF</div>
                    </div>
                    <div class="feature-icon-desc-cont">
                        <div class="feature-icon">i</div>
                        <div class="feature-name">name</div>
                    </div>
                    <div class="feature-icon-desc-cont">
                        <img class="feature-icon" src="Images/bell-svgrepo-com-4.svg" alt="">
                        <div class="feature-name">Set Reminders</div>
                    </div>
                    <div class="feature-icon-desc-cont">
                        <img class="feature-icon" src="Images/acrobat-logo.svg" alt="">
                        <div class="feature-name">Export tasks to PDF</div>
                    </div>
                    <div class="feature-icon-desc-cont">
                        <div class="feature-icon">i</div>
                        <div class="feature-name">name</div>
                    </div>
                </div>
                
            </div>

            <div class="access-actions">
                <button id="getStartedBtn">Get Started</button>
                <a href="login.php">I already have an Account</a>
            </div>
           
        </main>
    </div>
    <script src="js/auth-guard.js"></script>
    <script>
        const getStartedBtn = document.getElementById('getStartedBtn');
        getStartedBtn.addEventListener('click', () => {
            window.location.href = "signup.php";
        });

    </script>
</body>
</html>