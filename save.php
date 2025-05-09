<?php
$mysqli = new mysqli("localhost", "root", "", "holistic_wellness");

if ($mysqli->connect_error) {
    http_response_code(500);
    echo "Database connection failed: " . $mysqli->connect_error;
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$foods = $data["food"];
$satisfaction = intval($data["satisfaction"]);
$id_user = intval($data["id_user"]);

$errors = [];
foreach ($foods as $item) {
    $name = $mysqli->real_escape_string($item["name"]);
    $quantity = floatval($item["quantity"]);
    $unit = $mysqli->real_escape_string($item["unit"]);

    $query = "INSERT INTO food_log (id_user, food_name, quantity, unit, satisfaction)
              VALUES ($id_user, '$name', $quantity, '$unit', $satisfaction)";
    
    if (!$mysqli->query($query)) {
        $errors[] = $mysqli->error;
    }
}

if (empty($errors)) {
    echo "Entries saved successfully.";
} else {
    http_response_code(500);
    echo "Errors occurred: " . implode("; ", $errors);
}
?>
