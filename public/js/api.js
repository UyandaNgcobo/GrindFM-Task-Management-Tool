var API_BASE_URL = `http://${window.location.hostname}:4000/api`;

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

//-----------------------TO DO TASKS-----------------------
async function loadTasks() {
  const response = await fetch(`${API_BASE_URL}/tasks`, {
    method: "GET",
    credentials: "include",
  });

  const result = await response.json();
  console.log(result)
  return result;
}

async function deleteAllTasks() {
  console.log("API SAYS DELETE TRIGGERED!");
  const response = await fetch(`${API_BASE_URL}/tasks`, {
    method: "DELETE",
    credentials: "include",
  });

  const result = await response.json();
  console.log(result);
}

async function deleteTask(taskID) {
  const response = await fetch(`${API_BASE_URL}/tasks/${taskID}`, {
    method: "DELETE",
    credentials: "include",
  });

  const result = await response.json();
}

async function markCompleted(taskID, statusId) {
  const payload = { statusId: statusId };

  const response = await fetch(`${API_BASE_URL}/tasks/${taskID}`, {
    method: "PATCH",
    credentials: "include",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload),
  });

  const result = await response.json();
}

// ----------------- REMINDERS ---------------------

async function loadReminders() {
  const response = await fetch(`${API_BASE_URL}/reminders`, {
    method: "GET",
    credentials: "include",
    headers: { "Content-Type": "application/json" },
  });

  const result = await response.json();
  console.log(result);
  return result;
  // console.log("FROM API: ", result)
}

async function deleteReminder(taskID) {
  const payload = {};

  const response = await fetch(`${API_BASE_URL}/reminders/${taskID}`, {
    method: "DELETE",
    credentials: "include",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload),
  });

  const result = await response.json();
}

async function deleteAllReminders() {
  const payload = {};

  const response = await fetch(`${API_BASE_URL}/reminders`, {
    method: "DELETE",
    credentials: "include",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload),
  });

  const result = await response.json();
}
