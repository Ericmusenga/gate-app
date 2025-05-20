<?php
session_start();
include '../db.php'; // Include your DB connection

$regNumber = $_SESSION['Registration_Number']; // Assuming user session holds reg_number
$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];

// Validate current password
$query = "SELECT password FROM students WHERE Registration_Number = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $regNumber);
$stmt->execute();
$stmt->bind_result($dbPassword);
$stmt->fetch();
$stmt->close();

if ($currentPassword !== $dbPassword) {
    echo "Current password is incorrect!";
    exit();
}

// Update password
$update = "UPDATE students SET password = ? WHERE Registration_Number = ?";
$stmt = $conn->prepare($update);
$stmt->bind_param("ss", $newPassword, $regNumber);

if ($stmt->execute()) {
    echo "Password changed successfully.";
} else {
    echo "Failed to change password.";
}
$stmt->close();
$conn->close();
?>
