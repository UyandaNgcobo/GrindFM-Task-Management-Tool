requireLogin();

const reminderList = document.getElementById("reminders-list");
const reminderStatus = document.getElementById("reminders-status");
const clearRemindersButton = document.getElementById("clearBtn");
const reminderFilters = [...document.querySelectorAll(".reminder-filter")];
let reminders = [];
let activeFilter = "all";

async function requestReminderApi(path, options = {}) {
  const response = await fetch(`${API_BASE_URL}${path}`, {
    credentials: "include",
    ...options,
  });

  let result;
  try {
    result = await response.json();
  } catch {
    throw new Error("The server returned an unreadable response. Please try again.");
  }

  if (!response.ok || result.status !== "success") {
    throw new Error(result.message || "The request could not be completed. Please try again.");
  }

  return result;
}

function getReminderDate(reminder) {
  const date = new Date(String(reminder.trigger_at).replace(" ", "T"));
  return Number.isNaN(date.getTime()) ? null : date;
}

function isReminderPast(reminder, now = new Date()) {
  const date = getReminderDate(reminder);
  return date !== null && date < now;
}

function formatReminderTime(date) {
  return new Intl.DateTimeFormat(undefined, {
    hour: "numeric",
    minute: "2-digit",
  }).format(date);
}

function formatGroupHeading(date, isPast) {
  if (!date) {
    return "Date unavailable";
  }

  const today = new Date();
  const dateAtMidnight = new Date(date.getFullYear(), date.getMonth(), date.getDate());
  const todayAtMidnight = new Date(today.getFullYear(), today.getMonth(), today.getDate());
  const dayOffset = Math.round((dateAtMidnight - todayAtMidnight) / 86400000);

  if (dayOffset === 0) {
    return isPast ? "Earlier today" : "Today";
  }
  if (dayOffset === 1) {
    return "Tomorrow";
  }
  if (dayOffset === -1) {
    return "Yesterday";
  }

  return new Intl.DateTimeFormat(undefined, {
    weekday: "long",
    month: "long",
    day: "numeric",
    year: date.getFullYear() === today.getFullYear() ? undefined : "numeric",
  }).format(date);
}

function createActionButton(label, icon, className) {
  const button = document.createElement("button");
  button.type = "button";
  button.className = `reminder-action ${className}`;
  button.innerHTML = `<i class="bi ${icon}" aria-hidden="true"></i><span>${label}</span>`;
  return button;
}

function createReminderCard(reminder, now) {
  const date = getReminderDate(reminder);
  const past = isReminderPast(reminder, now);
  const card = document.createElement("article");
  card.className = `reminder-card${past ? " is-past" : ""}`;
  card.dataset.reminderId = reminder.reminder_id;

  const dateBadge = document.createElement("div");
  dateBadge.className = "reminder-date";
  if (date) {
    const day = document.createElement("span");
    day.className = "reminder-date-day";
    day.textContent = new Intl.DateTimeFormat(undefined, { day: "numeric" }).format(date);
    const month = document.createElement("span");
    month.className = "reminder-date-month";
    month.textContent = new Intl.DateTimeFormat(undefined, { month: "short" }).format(date);
    dateBadge.append(day, month);
  } else {
    dateBadge.textContent = "—";
    dateBadge.setAttribute("aria-label", "Date unavailable");
  }

  const copy = document.createElement("div");
  copy.className = "reminder-copy";
  const title = document.createElement("h2");
  title.className = "reminder-title";
  title.textContent = reminder.title;

  const meta = document.createElement("div");
  meta.className = "reminder-meta";
  const time = document.createElement("span");
  time.className = "reminder-time";
  const clockIcon = document.createElement("i");
  clockIcon.className = "bi bi-clock";
  clockIcon.setAttribute("aria-hidden", "true");
  time.append(clockIcon, document.createTextNode(date ? formatReminderTime(date) : "Time unavailable"));
  meta.append(time);

  if (past) {
    const status = document.createElement("span");
    status.textContent = "Past";
    meta.append(status);
  }

  copy.append(title, meta);
  if (reminder.description) {
    const description = document.createElement("p");
    description.className = "reminder-description";
    description.textContent = reminder.description;
    copy.append(description);
  }

  const actions = document.createElement("div");
  actions.className = "reminder-actions";
  actions.append(
    createActionButton("Edit", "bi-pencil", "reminder-action-edit"),
    createActionButton("Delete", "bi-trash3", "reminder-action-delete"),
  );

  card.append(dateBadge, copy, actions);
  return card;
}

function renderReminders() {
  const now = new Date();
  const upcoming = reminders.filter((reminder) => !isReminderPast(reminder, now));
  const past = reminders.filter((reminder) => isReminderPast(reminder, now));

  document.querySelector('[data-count="all"]').textContent = reminders.length;
  document.querySelector('[data-count="upcoming"]').textContent = upcoming.length;
  document.querySelector('[data-count="past"]').textContent = past.length;
  clearRemindersButton.disabled = reminders.length === 0;

  const visibleReminders = activeFilter === "upcoming"
    ? upcoming
    : activeFilter === "past"
      ? past
      : reminders;

  reminderList.replaceChildren();
  if (visibleReminders.length === 0) {
    const emptyState = document.createElement("p");
    emptyState.className = "reminders-state";
    emptyState.textContent = reminders.length === 0
      ? "No reminders yet. Create one when you want a timely nudge."
      : `No ${activeFilter} reminders. Try another filter or create a new reminder.`;
    reminderList.append(emptyState);
    return;
  }

  const sorted = [...visibleReminders].sort((first, second) => {
    const firstTime = getReminderDate(first)?.getTime() ?? Number.MAX_SAFE_INTEGER;
    const secondTime = getReminderDate(second)?.getTime() ?? Number.MAX_SAFE_INTEGER;
    return firstTime - secondTime;
  });

  const groups = new Map();
  for (const reminder of sorted) {
    const date = getReminderDate(reminder);
    const groupKey = date
      ? `${date.getFullYear()}-${date.getMonth()}-${date.getDate()}`
      : "unknown-date";
    if (!groups.has(groupKey)) {
      groups.set(groupKey, { date, reminders: [] });
    }
    groups.get(groupKey).reminders.push(reminder);
  }

  for (const group of groups.values()) {
    const section = document.createElement("section");
    section.className = "reminder-date-group";
    const heading = document.createElement("h2");
    heading.className = "reminder-date-heading";
    heading.textContent = formatGroupHeading(group.date, group.date ? group.date < now : false);
    section.append(heading);
    group.reminders.forEach((reminder) => section.append(createReminderCard(reminder, now)));
    reminderList.append(section);
  }
}

async function loadReminders() {
  reminderStatus.textContent = "";
  reminderList.replaceChildren();
  const loading = document.createElement("p");
  loading.className = "reminders-state";
  loading.textContent = "Loading reminders…";
  reminderList.append(loading);

  try {
    const result = await requestReminderApi("/reminders");
    reminders = Array.isArray(result.reminders) ? result.reminders : [];
    renderReminders();
  } catch (error) {
    reminders = [];
    renderReminders();
    reminderStatus.textContent = error.message || "The server could not be reached. Please try again.";

    const errorState = document.createElement("p");
    errorState.className = "reminders-state";
    errorState.textContent = "Your reminders couldn't load. Check your connection and try again.";

    const retryButton = document.createElement("button");
    retryButton.className = "reminder-retry-button";
    retryButton.type = "button";
    retryButton.textContent = "Try again";
    retryButton.addEventListener("click", loadReminders);
    reminderList.replaceChildren(errorState, retryButton);
  }
}

reminderFilters.forEach((button) => {
  button.addEventListener("click", () => {
    activeFilter = button.dataset.filter;
    reminderFilters.forEach((filter) => {
      const isActive = filter === button;
      filter.classList.toggle("is-active", isActive);
      filter.setAttribute("aria-pressed", String(isActive));
    });
    renderReminders();
  });
});

clearRemindersButton.addEventListener("click", async () => {
  if (reminders.length === 0 || !window.confirm("Delete all reminders? This can't be undone.")) {
    return;
  }

  clearRemindersButton.disabled = true;
  reminderStatus.textContent = "";
  try {
    await requestReminderApi("/reminders", { method: "DELETE" });
    reminders = [];
    renderReminders();
  } catch (error) {
    reminderStatus.textContent = error.message || "Reminders could not be cleared. Please try again.";
    clearRemindersButton.disabled = false;
  }
});

reminderList.addEventListener("click", async (event) => {
  const button = event.target.closest("button.reminder-action");
  if (!button) {
    return;
  }

  const card = button.closest(".reminder-card");
  const reminderId = card?.dataset.reminderId;
  const reminder = reminders.find((item) => String(item.reminder_id) === reminderId);
  if (!reminder) {
    reminderStatus.textContent = "That reminder could not be found. Refresh and try again.";
    return;
  }

  if (button.classList.contains("reminder-action-delete")) {
    if (!window.confirm(`Delete “${reminder.title}”?`)) {
      return;
    }

    button.disabled = true;
    try {
      await requestReminderApi(`/reminders/${encodeURIComponent(reminderId)}`, {
        method: "DELETE",
      });
      reminders = reminders.filter((item) => String(item.reminder_id) !== reminderId);
      reminderStatus.textContent = "";
      renderReminders();
    } catch (error) {
      button.disabled = false;
      reminderStatus.textContent = error.message || "The reminder could not be deleted.";
    }
    return;
  }

  const copy = card.querySelector(".reminder-copy");
  if (copy.querySelector(".reminder-edit-form")) {
    return;
  }

  const editForm = document.createElement("form");
  editForm.className = "reminder-edit-form";
  const descriptionInput = document.createElement("textarea");
  descriptionInput.className = "reminder-edit-input";
  descriptionInput.name = "description";
  descriptionInput.maxLength = 5000;
  descriptionInput.setAttribute("aria-label", `Description for ${reminder.title}`);
  descriptionInput.value = reminder.description || "";

  const editActions = document.createElement("div");
  editActions.className = "reminder-edit-actions";
  const saveButton = document.createElement("button");
  saveButton.className = "reminder-action is-active";
  saveButton.type = "submit";
  saveButton.textContent = "Save description";
  const cancelButton = document.createElement("button");
  cancelButton.className = "reminder-action";
  cancelButton.type = "button";
  cancelButton.textContent = "Cancel";
  editActions.append(saveButton, cancelButton);
  editForm.append(descriptionInput, editActions);
  copy.append(editForm);
  descriptionInput.focus();

  cancelButton.addEventListener("click", () => renderReminders());
  editForm.addEventListener("submit", async (submitEvent) => {
    submitEvent.preventDefault();
    saveButton.disabled = true;
    reminderStatus.textContent = "";

    try {
      await requestReminderApi(`/reminders/${encodeURIComponent(reminderId)}`, {
        method: "PATCH",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ description: descriptionInput.value.trim() }),
      });
      reminder.description = descriptionInput.value.trim();
      renderReminders();
    } catch (error) {
      saveButton.disabled = false;
      reminderStatus.textContent = error.message || "The description could not be saved.";
    }
  });
});

loadReminders();
