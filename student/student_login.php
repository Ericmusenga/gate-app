<?php
session_start();
include '../db.php';

$reg = $_POST['Registration_Number'] ?? '';
$pass = $_POST['password'] ?? '';

$query = "SELECT * FROM students WHERE Registration_Number = ? AND password = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $reg, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $_SESSION['Registration_Number'] = $reg;
    header("Location: student_dashboard.php");
} else {
    echo "❌ Invalid credentials.";
}
?>
