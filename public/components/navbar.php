<?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    $isCreatePage = in_array($currentPage, [
        'create-page.php',
        'to-do-list-create-page.php',
        'reminders-create-page.php',
        'schedule-create-page.php',
    ], true);
?>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/../css/navbar.css">
</head>
    <nav class="floating-nav">
        <!-- <a id="logo" href="/">Grind.<span id="logo-fm">FM</span></a> -->

        <!-- <ul> -->
            <!-- <li><a href="/about.php">About</a></li> -->

            <!-- <li><a href="/dashboard.php">Dashboard</a></li> -->

                <ul class="dropdown-content">
                    <li><a href="/dashboard.php" class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>" <?= $currentPage === 'dashboard.php' ? 'aria-current="page"' : '' ?> aria-label="Dashboard"><i class="bi bi-house"></i></a></li>
                    <li><a href="/to-do-list.php" class="<?= in_array($currentPage, ['to-do-list.php', 'to-do-list-create-page.php'], true) ? 'active' : '' ?>" <?= $currentPage === 'to-do-list.php' ? 'aria-current="page"' : '' ?> aria-label="To-do tasks"><i class="bi bi-list-check"></i></a></li>
                    <li><a href="/create-page.php" class="<?= $isCreatePage ? 'active' : '' ?>" <?= $currentPage === 'create-page.php' ? 'aria-current="page"' : '' ?> aria-label="Create"><i class="bi bi-plus-circle-fill"></i></a></li>
                    <li><a href="/reminders.php" class="<?= in_array($currentPage, ['reminders.php', 'reminders-create-page.php'], true) ? 'active' : '' ?>" <?= $currentPage === 'reminders.php' ? 'aria-current="page"' : '' ?> aria-label="Reminders"><i class="bi bi-bell"></i></a></li>
                    <li><a href="/schedule.php" class="<?= in_array($currentPage, ['schedule.php', 'schedule-create-page.php'], true) ? 'active' : '' ?>" <?= $currentPage === 'schedule.php' ? 'aria-current="page"' : '' ?> aria-label="Schedule"><i class="bi bi-calendar-week"></i></a></li>
                    <!-- <li><a href="/admin.php">Admin</a></li> -->
                </ul>

            <!-- <?php
                // if(isset($_SESSION['user_id'])){
                ?>
                    <button onclick="logout()">Log out</button>
            <?php
                // }else{
                ?>
                    <button onclick="window.location.replace('login.php')">Log in</button>
                <?php
                // }
            ?> -->
            

            
        <!-- </ul> -->
    </nav>
    <div id="notificationContainer"></div>
    <script src="js/auth-guard.js"></script>
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