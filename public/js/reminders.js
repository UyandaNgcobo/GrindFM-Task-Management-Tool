requireLogin();

async function editReminderDescription(description, reminderId){

    const payload = {
      description: description,
    };
    const response = await fetchAPI(`http://localhost:3000/api/reminders/${reminderId}`, {
      method: "PATCH",
      credentials: "include",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload),
    });

    console.log(response)
}

const rem_list = document.getElementById('reminders-list');
document.getElementById('clearBtn').addEventListener('click', ()=>{
    deleteAllRemindersAndRefresh();
})

rem_list.addEventListener("click", (event) => {
  // DELETE BUTTON
  if (event.target.classList.contains("deleteRemBtn")) {
    const card = event.target.closest(".extraInfo");
    const reminderId = card.dataset.reminderId;
    deleteReminder(reminderId); // Fixed: removed undefined 'description' variable
    return;
  }

  // EDIT/SAVE BUTTON
  if (event.target.classList.contains("modifyDescBtn")) {
    const btn = event.target;
    const card = btn.closest(".extraInfo");
    const reminderId = card.dataset.reminderId;
    console.log("REMINDER ID: ", reminderId)
    const descElement = card.querySelector(".reminder-description");

    if (btn.innerText === "Edit") {
      // 1. Turn on editing mode
      descElement.contentEditable = "true";
      descElement.style.borderBottom = "2px solid #000"; // visual cue that it's editable
      descElement.style.outline = "none";
      descElement.focus();
      btn.innerText = "Save"; // Change button text
    } else {
      // 2. Turn off editing mode and Save
      descElement.contentEditable = "false";
      descElement.style.borderBottom = "none";
      btn.innerText = "Edit";

      // 3. Grab the typed text and send it to your backend
      const newDesc = descElement.innerText;
      editReminderDescription(newDesc, reminderId);
    }
    return;
  }

  // EXPAND CARD
  const clickedCard = event.target.closest(".reminder-cont");
  if (clickedCard) {
    const reminderId = clickedCard.dataset.reminderId;
    const extraInfo = document.querySelector(
      `.extraInfo[data-reminder-id="${reminderId}"]`,
    );
    if (extraInfo) {
      extraInfo.classList.toggle("hidden");
    }
  }
});

async function deleteAllRemindersAndRefresh(){
    await deleteAllReminders();
    await render();
}

async function render(){
    const result = await loadReminders();
    console.log(result);

    let html = '';
    for (const reminder of result.reminders) {

        let d = new Date(reminder.trigger_at);

        let hours = String(d.getHours()).padStart(2, '0');
        let minutes = String(d.getMinutes()).padStart(2, '0');
        let trigger_at = `${hours}:${minutes}`

        html += `
            <div>
                <div class="reminder-cont" data-reminder-id="${reminder.reminder_id}">
                    <div class="date-info-cont">
                        <div class="date">${d.getDate()}</div>
                        <div class="day">${months[d.getMonth()].substring(0, 3)}</div>
                    </div>
                    <div id="reminder-content-cont">
                        <div class="title">${reminder.title}</div>
                        <div class="time"> Remind at: <span>${trigger_at}</span></div>
                    </div>
                </div> 

                <div class="extraInfo hidden" data-reminder-id="${reminder.reminder_id}">
                    <div class="extraInfo-inner">
                        <div class="reminder-description">${reminder.description === null ? "No description available" : reminder.description}</div>
                        <div id="editBtns">
                            <button class="modifyDescBtn">Edit</button>
                            <button class="deleteRemBtn">Delete Reminder</button>
                        </div>
                    </div>
                </div>
            </div>       
        `;
    }

    rem_list.innerHTML = html;

}

render();