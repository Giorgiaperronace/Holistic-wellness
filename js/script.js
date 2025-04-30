function goToHome() {
    window.location.href = "index.html"; // Redirects to homepage
}

function updateValue(spanId, value) {
    document.getElementById(spanId).textContent = value;
}

window.onload = function () {
    document.getElementById("sleepHours").value = localStorage.getItem("sleepHours") || 0;
    document.getElementById("sleepQuality").value = localStorage.getItem("sleepQuality") || 0;
    document.getElementById("nightDisruptions").value = localStorage.getItem("nightDisruptions") || 0;

    // Update displayed values
    updateValue("sleepHoursValue", document.getElementById("sleepHours").value);
    updateValue("sleepQualityValue", document.getElementById("sleepQuality").value);
    updateValue("nightDisruptionsValue", document.getElementById("nightDisruptions").value);
};

document.querySelector(".dropbtn").addEventListener("click", function() {
    const dropdownContent = document.querySelector(".dropdown-content");
    dropdownContent.style.display = (dropdownContent.style.display === "block") ? "none" : "block";
});
