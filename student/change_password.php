<?php
session_start();
include '../db.php';

if (!isset($_SESSION['Registration_Number'])) {
    echo "❌ Session expired. Please log in again.";
    exit();
}

$regNumber = $_SESSION['Registration_Number'];
$currentPassword = $_POST['currentPassword'] ?? '';
$newPassword = $_POST['newPassword'] ?? '';

if (empty($currentPassword) || empty($newPassword)) {
    echo "❌ All fields are required.";
    exit();
}

// Validate current password
$query = "SELECT password FROM students WHERE Registration_Number = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $regNumber);
$stmt->execute();
$stmt->bind_result($dbPassword);
$stmt->fetch();
$stmt->close();

if ($currentPassword !== $dbPassword) {
    echo "❌ Current password is incorrect!";
    exit();
}

// Update password
$update = "UPDATE students SET password = ? WHERE Registration_Number = ?";
$stmt = $conn->prepare($update);
$stmt->bind_param("ss", $newPassword, $regNumber);

if ($stmt->execute()) {
    echo "✅ Password updated successfully.";
} else {
    echo "❌ Failed to update password.";
}
$stmt->close();
$conn->close();
?>
