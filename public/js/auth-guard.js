async function getCurrentUser() {
  try {
    const res = await fetch("http://localhost:3000/api/me", {
      credentials: "include",
    });

    return await res.json();
  } catch (error) {
    console.error("Failed to check auth status:", error);
    return { user_id: null };
  }
}

async function requireLogin() {
  const me = await getCurrentUser();
  if (!me.user_id) {
    console.log("No user id found in session, login required");
    window.location.replace("login.php");
  } else {
    console.log("User id found in session, login NOT required");
    return me;
  }
}

async function redirectIfLoggedIn() {
  const me = await getCurrentUser();
  if (me.user_id) {
    console.log("Already logged in!")
    window.location.replace("index.php");
  } else {
    console.log("Not logged in!");
    return me;
  }
}
