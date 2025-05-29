<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include 'fitdata.php';  // qui si assegnano $steps e $calories dai dati Google Fit

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sleep Tracker</title>
    <link rel="stylesheet" href="static/styles.css" />
    <script>
        // Funzione JS per aggiornare il valore visualizzato accanto allo slider
        function updateValue(id, val) {
            document.getElementById(id).textContent = val;
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Holistic Wellness</h1>
            <div class="profile">
                <a href="#to do">Maria Rossi</a>
                <img src="images/profilepic.png" alt="Profile Picture" />
            </div>
        </div>
        
        <section class="card">
            <h1>Track today's activity!</h1>
        </section>

        <div class="card-container">
            <div class="card">
                <div class="section-title"><b> Active Calories Burned </b></div>
                <p><?= round($activeCalories) ?> kcal</p>
            </div>
            <div class="card">
                <div class="section-title"> <b> Distance Covered Today </b> </div>
                <p><?= round($distance / 1000, 2) ?> km</p>
            </div>
            <div class="card">
                <div class="section-title"><b>Exercise Minutes </b></div>
                <p><?= $exerciseMinutes ?> min</p>
            </div>
        </div>
            


        <div class="card">
            <div class="section-title">Type of Workout:</div>
            <select>
                <option>None</option>
                <option>MMA</option>
                <option>Yoga</option>
                <option>Pilates</option>
                <option>Run</option>
                <option>Hiit</option>
                <option>Crossfit</option>
                <option>Body Pump</option>
                <option>Boxing</option>
                <option>Spinning</option>
            </select>
        </div>


        <div class="card">
            <div class="section-title">Perceived effort of your workout:</div>
            <span id="WorkoutEffort">2.5</span>
            <input 
                type="range" min="0" max="10" step="0.1" value="2.5" 
                oninput="updateValue('WorkoutEffort', this.value)" 
            />
        </div>

        <a href="index.html"><button type="submit" class="okay-btn">Save</button></a>
    </div>
</body>
</html>
