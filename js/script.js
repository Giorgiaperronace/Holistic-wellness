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

function addFood() {
    const name = document.getElementById("foodName").value;
    const quantity = parseFloat(document.getElementById("quantity").value);
    const unit = document.getElementById("unit").value;
  
    if (name && quantity) {
      const item = { name, quantity, unit };
      foodItems.push(item);
      updateFoodList();
    }
  }
  
  function updateFoodList() {
    const ul = document.getElementById("foodList");
    ul.innerHTML = "";
    foodItems.forEach((item) => {
      const li = document.createElement("li");
      li.textContent = `${item.name} - ${item.quantity} ${item.unit}`;
      ul.appendChild(li);
    });
  }
  
  function saveData() {
    const satisfaction = parseInt(document.getElementById("satisfaction").value);
    const id_user = 1; // Replace with logged-in user ID if available
  
    fetch("save.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ food: foodItems, satisfaction, id_user })
    })
    .then(res => res.text())
    .then(data => {
      document.getElementById("history").innerHTML += `<p>${data}</p>`;
      foodItems = [];
      updateFoodList();
      document.getElementById("satisfaction").value = "";
    });
  }
  