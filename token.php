<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
};

function refreshAccessToken() {
    $client_id = "1072410217387-aega3uvlapjubfsrs6dfj1q5msim06g9.apps.googleusercontent.com";
    $client_secret = "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";
    $refresh_token = $_SESSION['refresh_token'];

    $post_fields = http_build_query([
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'refresh_token' => $refresh_token,
        'grant_type' => 'refresh_token'
    ]);

    $ch = curl_init("https://oauth2.googleapis.com/token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['access_token'])) {
        $_SESSION['access_token'] = $data['access_token'];
        $_SESSION['expires_in'] = time() + $data['expires_in'];
        return true;
    } else {
        return false;
    }
}
