<header>
    <nav>
        <a id="logo" href="/">Grind.<span id="logo-fm">FM</span></a>

        <ul>
            <li><a href="/about.php">About</a></li>

            <!-- <li><a href="/dashboard.php">Dashboard</a></li> -->

            <li class="dropdown">
                <a href="#">Tools</a>

                <ul class="dropdown-content">
                    <li><a href="/to-do-list.php">To-Do List</a></li>
                    <li><a href="/reminders.php">Reminders</a></li>
                    <li><a href="/analytics.php">Analytics</a></li>
                    <li><a href="/admin.php">Admin</a></li>
                </ul>
            </li>

            <?php
                if(isset($_SESSION['user_id'])){
                ?>
                    <button onclick="logout()">Log out</button>
            <?php
                }else{
                ?>
                    <button onclick="window.location.replace('login.php')">Log in</button>
                <?php
                }
            ?>
            

            
        </ul>
    </nav>
    <div id="notificationContainer"></div>
    <script src="/public/js/auth-guard.js"></script>
    <script>
        async function logout() {
            try {
                const response = await fetch("http://localhost:3000/api/logout", {
                    method: "POST",
                    credentials: "include"
                });
                    const result = await response.json();
                    console.log("Logout response:", result);
            } catch (err) {
                console.error("Logout request failed:", err);
            }
            
            window.location.replace("login.php");
        }
    </script>
</header>