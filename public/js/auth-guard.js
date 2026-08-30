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
    window.location.replace("login.php");
  } else {
    return me;
  }
}

async function redirectIfLoggedIn() {
  const me = await getCurrentUser();
  if (me.user_id) {
    window.location.replace("index.php");
  } else {
    return me;
  }
}
