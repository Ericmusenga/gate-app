<?php
session_start();
include '../db.php';

$reg = $_POST['Registration_Number'] ?? '';
$pass = $_POST['password'] ?? '';

$query = "SELECT * FROM students WHERE Registration_Number = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $reg);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $student = $result->fetch_assoc();
    if (password_verify($pass, $student['password'])) {
        $_SESSION['Registration_Number'] = $reg;
        header("Location: student_dashboard.php");
    } else {
        echo "❌ Invalid credentials.";
    }
} else {
    echo "❌ Invalid credentials.";
}
?>
