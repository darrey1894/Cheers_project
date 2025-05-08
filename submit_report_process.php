<?php
include_once("db.php");
include_once("session.php");

$user_id = $_SESSION['user_id'];
$property_lmk_key = $_POST['property_lmk_key'];
$issue_type = $_POST['issue_type'];
$description = $_POST['description'];
$photo_path = '';
$video_path = '';

if ($_FILES['photo']['name']) {
    $photo_path = "uploads/" . basename($_FILES['photo']['name']);
    move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
}

if ($_FILES['video']['name']) {
    $video_path = "uploads/" . basename($_FILES['video']['name']);
    move_uploaded_file($_FILES['video']['tmp_name'], $video_path);
}

$sql = "INSERT INTO reports (user_id, property_lmk_key, issue_type, description, photo_path, video_path) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssss", $user_id, $property_lmk_key, $issue_type, $description, $photo_path, $video_path);

if ($stmt->execute()) {
    header("Location: view_reports.php?success=1");
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>