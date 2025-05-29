<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'token.php';

// Controlla se access token esiste
if (!isset($_SESSION['access_token'])) {
    header("Location: auth.php");
    exit;
}

// Controlla se token è scaduto e rinfrescalo
if ($_SESSION['expires_in'] < time()) {
    if (!refreshAccessToken()) {
        header("Location: auth.php");
        exit;
    }
}

$access_token = $_SESSION['access_token'];
$now = round(microtime(true) * 1000);
$oneDayAgo = $now - 86400000;

// Corpi delle richieste
$bodies = [
    'steps' => [
        "aggregateBy" => [[
            "dataTypeName" => "com.google.step_count.delta",
            "dataSourceId" => "derived:com.google.step_count.delta:com.google.android.gms:estimated_steps"
        ]],
        "bucketByTime" => ["durationMillis" => 86400000],
        "startTimeMillis" => $oneDayAgo,
        "endTimeMillis" => $now
    ],
    'calories' => [
        "aggregateBy" => [[
            "dataTypeName" => "com.google.calories.expended"
        ]],
        "bucketByTime" => ["durationMillis" => 86400000],
        "startTimeMillis" => $oneDayAgo,
        "endTimeMillis" => $now
    ],
    'activeCalories' => [
        "aggregateBy" => [[
            "dataTypeName" => "com.google.calories.expended",
            "dataSourceId" => "derived:com.google.calories.expended:com.google.android.gms:from_activities"
        ]],
        "bucketByTime" => ["durationMillis" => 86400000],
        "startTimeMillis" => $oneDayAgo,
        "endTimeMillis" => $now
    ],
    'distance' => [
        "aggregateBy" => [[
            "dataTypeName" => "com.google.distance.delta"
        ]],
        "bucketByTime" => ["durationMillis" => 86400000],
        "startTimeMillis" => $oneDayAgo,
        "endTimeMillis" => $now
    ],
    'exerciseMinutes' => [
        "aggregateBy" => [[
            "dataTypeName" => "com.google.active_minutes"
        ]],
        "bucketByTime" => ["durationMillis" => 86400000],
        "startTimeMillis" => $oneDayAgo,
        "endTimeMillis" => $now
    ],
];

// Funzione per chiamare Google Fit API
function fetchGoogleFitData($access_token, $body) {
    $ch = curl_init("https://www.googleapis.com/fitness/v1/users/me/dataset:aggregate");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $access_token",
        "Content-Type: application/json"
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Funzione per estrarre il totale da risposta API
function extractTotal($data, $valueKey = 'intVal') {
    $total = 0;
    if (isset($data['bucket'])) {
        foreach ($data['bucket'] as $bucket) {
            foreach ($bucket['dataset'] as $dataset) {
                if (!empty($dataset['point'])) {
                    foreach ($dataset['point'] as $point) {
                        foreach ($point['value'] as $val) {
                            $total += $val[$valueKey] ?? 0;
                        }
                    }
                }
            }
        }
    }
    return $total;
}

// Esegui le chiamate API
$stepsData = fetchGoogleFitData($access_token, $bodies['steps']);
$caloriesData = fetchGoogleFitData($access_token, $bodies['calories']);
$activeCaloriesData = fetchGoogleFitData($access_token, $bodies['activeCalories']);
$distanceData = fetchGoogleFitData($access_token, $bodies['distance']);
$exerciseMinutesData = fetchGoogleFitData($access_token, $bodies['exerciseMinutes']);

// Estrai i dati con la funzione (per fpVal uso valueKey = 'fpVal')
$steps = extractTotal($stepsData, 'intVal');
$calories = extractTotal($caloriesData, 'fpVal');
$activeCalories = extractTotal($activeCaloriesData, 'fpVal');
$distance = extractTotal($distanceData, 'fpVal');
$exerciseMinutes = extractTotal($exerciseMinutesData, 'intVal');

