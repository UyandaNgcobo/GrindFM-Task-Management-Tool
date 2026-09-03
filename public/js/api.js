async function loadTasks() {
  const response = await fetch("http://localhost:3000/api/tasks", {
    method: "GET",
    credentials: "include",
  });

  const result = await response.json();

  const list = document.getElementById("task-to-do-list");
  console.log(result);
  let tasks = result.tasks;

  const count = result.count;
  const completedCount = result.completedCount;

  todoCount.textContent = count;
  completedTotal.textContent = completedCount;

  let html = "";

  for (const task of tasks) {
    const isChecked = task.status_id === 2 ? "checked" : "";
    html += `
                    <div class="task-to-do-cont" data-task-id="${task.task_id}">
                        <div class="task">${task.title}</div>
                        <input type="checkbox" name="" ${isChecked}>
                    </div>`;
  }

  list.innerHTML = html;
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
