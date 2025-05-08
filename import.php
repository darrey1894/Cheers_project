<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$conn = new mysqli("localhost", "root", "", "energy_management_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$file = fopen("random_sample.csv", "r");

$header = fgetcsv($file); // skip header

while (($data = fgetcsv($file)) !== FALSE) {
    if (count($data) !== 92) {
        echo "Row skipped. Found " . count($data) . " columns\n";
        continue;
    }
    foreach ($data as $i => $value) {
        if ($value === "") {
            $data[$i] = null;
        }
    }
    
    $placeholders = rtrim(str_repeat('?,', 92), ',');
    $sql = "INSERT INTO properties VALUES ($placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat("s", 92), ...$data);
    try {
        $stmt->execute();
    } catch (mysqli_sql_exception $e) {
        echo "Duplicate or error on row with lmk_key: " . $data[0] . " – " . $e->getMessage() . "\n";
    }
    
}


fclose($file);
$conn->close();
?>