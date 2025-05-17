<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "❌ Please fill in the login form first.";
    exit();
}

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    echo "❌ Email or password not set.";
    exit();
}

// Connection settings
$host = "localhost";
$user = "root";
$pass = "";
$db = "gate";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Clean inputs
$email = trim($_POST['email']);
$password = trim($_POST['password']);

// Check user
$sql = "SELECT * FROM users1 WHERE email=? AND password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $_SESSION['email'] = $user['email'];
    $_SESSION['user_type'] = $user['user_type'];

    if ($user['user_type'] === 'admin') {
        header("Location: admin_dashboard.php");
        exit();
    } elseif ($user['user_type'] === 'standard') {
        header("Location: standard_dashboard.php");
        exit();
    } else {
        echo "❌ Unknown role: " . htmlspecialchars($user['user_type']);
    }
} else {
    echo "❌ Invalid email or password.";
}

$conn->close();
?>
