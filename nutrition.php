
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Nutrition Tracker</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;700&family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="/static/styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Holistic Wellness</h1>
            <div class="profile">
                <a href="#to do">Maria Rossi</a>
                <img src="images/profilepic.png">
            </div>
        </div>



        <?php
$response = file_get_contents("http://127.0.0.1:5000/genera_dieta?query=create%20diet%20woman");

// Proviamo a decodificare come JSON
$responseData = json_decode($response, true);

// Se è JSON valido
if ($responseData !== null) {
    // Mostra tutta la struttura per capire cosa c'è dentro
    echo "<pre>";
    print_r($responseData);
    echo "</pre>";
} else {
    // Altrimenti stampa il testo così com’è
    echo $response;
}

?>
       


        <!-- Form Section -->
        <div class="form-section">
            <h2>Track Your Nutrition</h2>
            <form action="#" method="post">
                <!-- Food Intake Section -->
                <div class="form-group">
                    <label for="breakfast">Breakfast:</label>
                    <input type="text" id="breakfast" name="breakfast" placeholder="What did you eat for breakfast?">
                </div>

                <div class="form-group">
                    <label for="lunch">Lunch:</label>
                    <input type="text" id="lunch" name="lunch" placeholder="What did you eat for lunch?">
                </div>

                <div class="form-group">
                    <label for="dinner">Dinner:</label>
                    <input type="text" id="dinner" name="dinner" placeholder="What did you eat for dinner?">
                </div>

                <div class="form-group">
                    <label for="snacks">Snacks:</label>
                    <input type="text" id="snacks" name="snacks" placeholder="Any snacks today?">
                </div>

                <!-- Hydration Section -->
                <div class="form-group">
                    <label for="water">Water Intake (in liters):</label>
                    <input type="number" id="water" name="water" step="0.1" placeholder="How much water did you drink today?">
                </div>


                <div class="form-group">
                    <label for="notes">Additional Notes:</label>
                    <textarea id="notes" name="notes" rows="4" placeholder="Any specific feelings or emotions related to your food intake?"></textarea>
                </div>
            </form>
        </div>
        
    </div>
    <a href="index.html"><button type="submit" class="okay-btn">Save</button></a>
</body>
</html>