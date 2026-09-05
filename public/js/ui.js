
const days = [
  "Sunday",
  "Monday",
  "Tuesday",
  "Wednesday",
  "Thursday",
  "Friday",
  "Saturday",
];

const months = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];

//Access the element holding clock's text content and change it to time now
function updateClock(){
    
    const time = new Date();
    document.getElementById('clock').textContent = time.toLocaleTimeString('en-GB', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
    });

    const date = time.getDate();
    const month = months[time.getMonth()];

    document.getElementById("date").textContent =
      `${date} ${month},`;

    document.getElementById("day").textContent = days[time.getDay()];
}

//runs update every 60 second
function startClock(){

    updateClock();
    setInterval(updateClock, 60000);
}