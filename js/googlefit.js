window.addEventListener("DOMContentLoaded", () => {
  const accessToken = "4/0AUJR-x4hpvv6V1p1g2NzcLHlskIVlBA5LV8cFG8oYKlWdiHvBNGbXJWHLY1mRXeR8_3uYA";

  const now = Date.now();
  const oneDayAgo = now - 86400000; // 24 ore fa

  // === PASSI ===
  const stepsBody = {
    aggregateBy: [{
      dataTypeName: "com.google.step_count.delta",
      dataSourceId: "derived:com.google.step_count.delta:com.google.android.gms:estimated_steps"
    }],
    bucketByTime: { durationMillis: 86400000 },
    startTimeMillis: oneDayAgo,
    endTimeMillis: now
  };

  fetch("https://www.googleapis.com/fitness/v1/users/me/dataset:aggregate", {
    method: "POST",
    headers: {
      "Authorization": `Bearer ${accessToken}`,
      "Content-Type": "application/json"
    },
    body: JSON.stringify(stepsBody)
  })
  .then(res => res.json())
  .then(data => {
    console.log("Dati passi:", data);
    let steps = 0;
    if (data.bucket) {
      data.bucket.forEach(bucket => {
        bucket.dataset.forEach(dataset => {
          dataset.point.forEach(point => {
            point.value.forEach(val => {
              steps += val.intVal || 0;
            });
          });
        });
      });
    }

    document.getElementById("StepsTakenValue").innerText = steps;
    document.querySelector("input[oninput*='StepsTakenValue']").value = steps;
  })
  .catch(err => console.error("Errore Google Fit - passi:", err));

  // === CALORIE ===
  const caloriesBody = {
    aggregateBy: [{
      dataTypeName: "com.google.calories.expended"
    }],
    bucketByTime: { durationMillis: 86400000 },
    startTimeMillis: oneDayAgo,
    endTimeMillis: now
  };

  fetch("https://www.googleapis.com/fitness/v1/users/me/dataset:aggregate", {
    method: "POST",
    headers: {
      "Authorization": `Bearer ${accessToken}`,
      "Content-Type": "application/json"
    },
    body: JSON.stringify(caloriesBody)
  })
  .then(res => res.json())
  .then(data => {
    console.log("Dati calorie:", data);
    let calories = 0;
    if (data.bucket) {
      data.bucket.forEach(bucket => {
        bucket.dataset.forEach(dataset => {
          dataset.point.forEach(point => {
            point.value.forEach(val => {
              calories += val.fpVal || 0;
            });
          });
        });
      });
    }

    const roundedCalories = Math.round(calories);
    document.getElementById("CaloriesBurned").innerText = roundedCalories;
    document.querySelector("input[oninput*='CaloriesBurned']").value = roundedCalories;
  })
  .catch(err => console.error("Errore Google Fit - calorie:", err));
});