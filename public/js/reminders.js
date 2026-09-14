requireLogin();

async function editReminderDescription(description, reminderId){

    const payload = {
        description: description
    }
    const response = await fetchAPI(`http://localhost:3000//api/tasks/${reminderId}`, {
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

rem_list.addEventListener('click', (event) => {

    if (event.target.classList.contains('deleteRemBtn')) {
        const card = event.target.closest('.extraInfo');
        const reminderId = card.dataset.reminderId;
        deleteReminder(description, reminderId);
        return;
    }

    if (event.target.classList.contains('modifyDescBtn')) {
        const card = event.target.closest('.extraInfo');
        const reminderId = card.dataset.reminderId;

        const descElement = card.querySelector(".reminder-description");
        const currentDesc = descElement.innerText;

        const newDesc = prompt("Update description: ", currentDesc)

        if(newDesc == null) return;
        
        editReminderDescription(reminderId);
        return;
    }
    
    const clickedCard = event.target.closest('.reminder-cont');
    if (clickedCard) {
        const reminderId = clickedCard.dataset.reminderId;
        const extraInfo = document.querySelector(`.extraInfo[data-reminder-id="${reminderId}"]`);
        if (extraInfo) {
            extraInfo.classList.toggle('hidden');
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
                            <button id="modifyDescBtn">Edit</button>
                            <button id="deleteRemBtn">Delete Reminder</button>
                        </div>
                    </div>
                </div>
            </div>       
        `;
    }

    rem_list.innerHTML = html;

}

render();