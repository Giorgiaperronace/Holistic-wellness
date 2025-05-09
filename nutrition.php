
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
      
  

    <a href="index.html"><button type="submit" class="okay-btn">Save</button></a>
</body>
</html>