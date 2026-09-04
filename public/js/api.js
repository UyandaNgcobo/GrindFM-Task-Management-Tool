async function loadTasks() {
  const response = await fetch("http://localhost:3000/api/tasks", {
    method: "GET",
    credentials: "include",
  });

    const result = await response.json();
    return result;
}

async function deleteAll() {
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
