const body = document.querySelector("body"),
    sidebar = body.querySelector(".sidebar"),
    // toggle = body.querySelector(".toggle"),
    searchBtn = body.querySelector(".search-box"),
    // modeSwitch = body.querySelector(".toggle-switch"),
    // modeText = body.querySelector(".mode-text"),
    logoutBtn = document.getElementById("logoutBtn"),
    logoutForm = document.getElementById("logoutForm");

// window.addEventListener("load", () => {
//     // Ellenőrizzük, hogy van-e már mentett beállítás a tárolóban
//     const darkModeEnabled = localStorage.getItem("darkModeEnabled");

//     // Ha van mentett beállítás, alkalmazzuk azt
//     if (darkModeEnabled === "true") {
//         body.classList.add("dark");
//         modeText.innerText = "Light Mode";
//     } else {
//         body.classList.remove("dark");
//         modeText.innerText = "Dark Mode";
//     }
// });

// toggle.addEventListener("click", () => {
//     sidebar.classList.toggle("close");
// });

// modeSwitch.addEventListener("click", () => {
//     body.classList.toggle("dark");

//     const darkModeEnabled = body.classList.contains("dark");
//     localStorage.setItem("darkModeEnabled", darkModeEnabled);

//     modeText.innerText = darkModeEnabled ? "Light Mode" : "Dark Mode";
// });

logoutBtn.addEventListener("click", () => {
    document.getElementById("logoutForm").submit();
});
