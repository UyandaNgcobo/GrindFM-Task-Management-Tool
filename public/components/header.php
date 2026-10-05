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
        <!-- <div class="profile-dropdown-container"> -->
            <!-- <a href="#" id="profile-img-name"> -->
                <!-- <img id="profile-pic" src="/Images/RandomSir.jpeg" alt=""> -->
        <div id="profile-username">Hi, Uyanda Ngcobo</div>
            <!-- </a> -->
        <!-- </div> -->

        <div class="profile-dropdown-container">
            <img id="profile-pic" src="/Images/RandomSir.jpeg" alt="">
            <i id="caret" class="bi bi-caret-down"></i>

            <div class="profile-dropdown-menu">
                <div id="profile-img-name">
                    <img id="profile-pic" src="/Images/RandomSir.jpeg" alt="">
                    <div id="profile-name-email">
                        <p id="username">Uyanda Ngcobo</p>
                        <p id="email">example@gmail.com</p>
                    </div>
                </div>
                <hr>
                <a href="#"><i class="bi bi-person"></i>Profile</a>
                <a href="#"><i class="bi bi-person-gear"></i>Account Settings</a>
                <a href="#" id="logout-btn"><i class="bi bi-box-arrow-left"></i>Log Out</a>
            </div>
        </div>

        <!-- <a href="#" id="notifications"><i class="bi bi-app-indicator"></i></a> -->

    </div>
</header>

<script src="/public/js/auth-guard.js"></script>
<script>

    document.addEventListener('click', (e) => {
        const dropdownContainer = document.querySelector('.profile-dropdown-container');

        const clickedProfilePic = e.target.closest('#profile-pic');
        const clickedLogOutBtn = e.target.closest('#logout-btn');

        if(clickedProfilePic){
            dropdownContainer.classList.toggle('active');
        } else if (!e.target.closest('.profile-dropdown-menu')) {
            dropdownContainer.classList.remove('active');
        }

        if(clickedLogOutBtn){
            logout();
        }
    });

    logout()
</script>