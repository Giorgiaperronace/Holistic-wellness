<?php

// Configurazioni
$client_id = "1072410217387-aega3uvlapjubfsrs6dfj1q5msim06g9.apps.googleusercontent.com";
$redirect_uri = "http://localhost/holistic/callback.php"; // Cambia se hai un altro indirizzo locale

$scopes = [
    "https://www.googleapis.com/auth/fitness.activity.read",
    "https://www.googleapis.com/auth/fitness.activity.write",
    "https://www.googleapis.com/auth/fitness.location.read",
    "https://www.googleapis.com/auth/fitness.location.write",
    "https://www.googleapis.com/auth/fitness.body.read",
    "https://www.googleapis.com/auth/fitness.heart_rate.read",
    "https://www.googleapis.com/auth/fitness.sleep.read",
    "https://www.googleapis.com/auth/fitness.nutrition.read",
    
];

$scope = implode(' ', $scopes);

$auth_url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
    'response_type' => 'code',
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'scope' => $scope,
    'access_type' => 'offline',
    'prompt' => 'consent'
]);

header("Location: $auth_url");
exit();
