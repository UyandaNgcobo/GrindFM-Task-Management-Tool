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
function updateClock() {
  const time = new Date();
  document.getElementById("clock").textContent = time.toLocaleTimeString(
    "en-GB",
    {
      hour: "2-digit",
      minute: "2-digit",
      hour12: false,
    },
  );

  const date = time.getDate();
  const month = months[time.getMonth()];

  document.getElementById("date").textContent = `${date} ${month},`;

  document.getElementById("day").textContent = days[time.getDay()];
}

function updateTimeline() {
  const today = new Date();

  const dateCollection = document.querySelectorAll(".date-num");
  const dayCollection = document.querySelectorAll(".rem-day");

  let counter = 0;

  for (let i = -2; i <= 2; i++) {
    const offsetDate = new Date(
      today.getFullYear(),
      today.getMonth(),
      today.getDate() + i,
    );

    const index = i + 2; // shift -2..2 into array index 0..4
    dateCollection[index].textContent = `${offsetDate.getDate()}`;
    dayCollection[index].textContent =
      `${days[offsetDate.getDay()].substring(0, 3)}`;
  }
}

//runs update every 60 second
function startClock() {
  updateClock();
  setInterval(updateClock, 60000);
}

function displayInternalNotification(data) {
  const container = document.getElementById("toastContainer");

  const toast = document.createElement("div");
  toast.className = `toast ${data.status === "success" ? "success" : "error"}`;

  const icon =
    data.status === "success"
      ? "tick-circle-svgrepo-com.svg"
      : "error-circle-svgrepo-com.svg";

  toast.innerHTML = `
        <img src="/Images/${icon}" alt="" class="completedIcon">
        <div class="notification-message">${data.message}</div>
    `;

  container.appendChild(toast);

  setTimeout(() => {
    toast.remove();
  }, 3000);
}