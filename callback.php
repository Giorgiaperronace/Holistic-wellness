<?php
session_start();

$client_id = "1072410217387-aega3uvlapjubfsrs6dfj1q5msim06g9.apps.googleusercontent.com";
$client_secret = "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";
$redirect_uri = "http://localhost/holistic/callback.php";

if (!isset($_GET['code'])) {
    die("Errore: nessun codice di autorizzazione ricevuto");
}

$code = $_GET['code'];

$post_fields = http_build_query([
    'code' => $code,
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri' => $redirect_uri,
    'grant_type' => 'authorization_code'
]);

$ch = curl_init("https://oauth2.googleapis.com/token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if (isset($data['error'])) {
    die("Errore nello scambio token: " . $data['error_description']);
}

$_SESSION['access_token'] = $data['access_token'];
$_SESSION['refresh_token'] = $data['refresh_token'];
$_SESSION['expires_in'] = time() + $data['expires_in'];

header("Location: fitdata.php");
exit;
