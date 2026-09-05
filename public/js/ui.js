function updateClock(){
    const now = new Date();
    document.getElementById('clock').textContent = now.toLocaleTimeString();
}

function startClock(){
    updateClock();
    setInterval(updateClock, 1000);
}