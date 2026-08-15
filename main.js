document.addEventListener('DOMContentLoaded', () => {
    const addButton = document.querySelector('.wrapper-create button');
    const inputField = document.querySelector('.wrapper-create input');
    const pillsContainer = document.querySelector('.wrapper-notes-pills');

    // Load saved pills from localStorage and display them
    const savedPills = JSON.parse(localStorage.getItem('savedPills')) || [];
    savedPills.forEach(pillData => createPill(pillData.text, pillData.time));

    addButton.addEventListener('click', () => {
        const pillText = inputField.value.trim();
        if (pillText === '') {
            alert('Please enter a task!');
            return;
        }

        const now = new Date();
        const timeText = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        
        createPill(pillText, timeText); // Create and display the new pill

        // Save the new pill to localStorage
        savedPills.push({ text: pillText, time: timeText });
        localStorage.setItem('savedPills', JSON.stringify(savedPills));

        inputField.value = ''; // Clear the input field
    });


    function createPill(pillText, timeText) {
        // Create a new pill
        const pillWrap = document.createElement('div');
        pillWrap.className = 'pill-wrap';

        const pill = document.createElement('div');
        pill.className = 'pill';
        
        const pillContent = document.createElement('p');
        pillContent.className = 'text';
        pillContent.textContent = pillText;
        
        const time = document.createElement('div');
        time.className = 'time';
        time.textContent = timeText;

        const iconsWrap = document.createElement('div');
        iconsWrap.className = 'iconWrap';

        const deleteIcon = document.createElement('i');
        deleteIcon.className = 'fa-solid fa-trash';
        deleteIcon.addEventListener('click', () => {
            pillsContainer.removeChild(pillWrap);
            // Remove from localStorage
            const updatedPills = savedPills.filter(pill => pill.text !== pillText);
            localStorage.setItem('savedPills', JSON.stringify(updatedPills));
        });

        const editIcon = document.createElement('i');
        editIcon.className = 'fa-solid fa-pen';
        editIcon.addEventListener('click', () => {
            if (pillContent.isContentEditable) {
                saveNote();
            } else {
                pillContent.contentEditable = true;
                pillContent.focus();
                pill.style.backgroundColor = 'rgba(246, 243, 207, 0.8)';
                editIcon.className = 'fa-solid fa-x';

                pillContent.addEventListener('keypress', function onKeyPress(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault(); // Prevent newline insertion
                        saveNote();
                        pillContent.removeEventListener('keypress', onKeyPress); // Clean up event listener
                    }
                });
            }

            // Save note function
            function saveNote() {
                pillContent.contentEditable = false;
                pill.style.backgroundColor = '#fff';
                editIcon.className = 'fa-solid fa-pen';
                
                // Update localStorage after editing
                const pillIndex = savedPills.findIndex(pill => pill.text === pillText);
                savedPills[pillIndex].text = pillContent.textContent;
                localStorage.setItem('savedPills', JSON.stringify(savedPills));
                alert('Note saved!');
            }
        });

        // Append elements
        pill.appendChild(pillContent);
        pill.appendChild(iconsWrap);
        iconsWrap.appendChild(editIcon);
        iconsWrap.appendChild(deleteIcon);
        pillWrap.appendChild(pill);
        pillWrap.appendChild(time);
        pillsContainer.appendChild(pillWrap); // Append the new pillWrap to the container
    }
});
