<?php
include 'db.php';

$role = $_POST['role'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($role && $username && $password) {
    if ($role === 'admin') {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    } elseif ($role === 'student') {
        $stmt = $conn->prepare("SELECT * FROM students WHERE Registration_Number = ? AND password = ?");
    } elseif ($role === 'security') {
        $stmt = $conn->prepare("SELECT * FROM security WHERE username = ? AND password = ?");
    } else {
        die("Invalid role.");
    }

    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Redirect to dashboard
        if ($role === 'admin') {
            header("Location: admin/admin_dashboard.php");
        } elseif ($role === 'student') {
            header("Location: student/student_dashboard.php?reg=$username");
        } elseif ($role === 'security') {
            header("Location: standard/standard_dashboard.php");
        }
        exit();
    } else {
        echo "Invalid credentials!";
    }
} else {
    echo "Please fill in all fields.";
}
?>
