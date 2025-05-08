<?php
$conn = new mysqli("localhost", "root", "", "energy_management_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>