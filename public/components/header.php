<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/../css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
</head>

<header>
    <!-- <div id="notificationContainer"></div> -->
    <div class="header-nav-container">
        <a href="#" id="profile-img-name">
            <img id="profile-pic" src="/Images/RandomSir.jpeg" alt="">
            <div id="profile-username">Hi, Uyanda Ngcobo</div>
        </a>
        <a href="#" id="notifications"><i class="bi bi-app-indicator"></i></a>
    </div>
</header>

<script src="/public/js/auth-guard.js"></script>
<script>
    // async function logout() {
    //     try {
    //         const response = await fetch(`http://${window.location.hostname}:4000/api/logout`, {
    //             method: "POST",
    //             credentials: "include"
    //         });
    //             const result = await response.json();
    //             console.log("Logout response:", result);
    //     } catch (err) {
    //         console.error("Logout request failed:", err);
    //     }
        
    //     window.location.replace("login.php");
    // }
</script>