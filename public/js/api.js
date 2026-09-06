//Custom fetch including error handling
//Returns response JSON or null on failure
async function fetchAPI(url, options) {
  try {
    const response = await fetch(url, options);

    if (!response.ok) {
      showError(`Request failed (${response.status}). Please try again.`);
      return null;
    }

    return await response.json();
  } catch (error) {
    console.error("Network error:", err);
    showError(
      "Can't reach the server. Please check your connection and try again.",
    );
    return null;
  }
}

async function loadTasks() {
  const response = await fetch("http://localhost:3000/api/tasks", {
    method: "GET",
    credentials: "include",
  });

  const result = await response.json();
  return result;
}

async function deleteAllTasks() {
  const response = await fetch("http://localhost:3000/api/tasks", {
    method: "DELETE",
    credentials: "include",
  });

  const result = await response.json();
  console.log(result);
}

async function deleteTask(taskID) {
  const response = await fetch(`http://localhost:3000/api/tasks/${taskID}`, {
    method: "DELETE",
    credentials: "include",
  });

  const result = await response.json();
}

async function markCompleted(taskID, statusId) {
  const payload = { statusId: statusId };

  const response = await fetch(`http://localhost:3000/api/tasks/${taskID}`, {
    method: "PATCH",
    credentials: "include",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload),
  });

  const result = await response.json();
}
