<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "❌ Please fill in the login form first.";
    exit();
}

if (empty($_POST['username']) || empty($_POST['password'])) {
    echo "❌ Username or password not provided.";
    exit();
}

// Database config
$host = "localhost";
$user = "root";
$pass = "";
$db = "gate";

// DB connection
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Inputs
$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Query user by username
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Compare password (plain or hashed)
    if (password_verify($password, $user['password']) || $password === $user['password']) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_type'] = $user['role'];

        // Redirect by role
        switch ($user['role']) {
            case 'admin':
                header("Location: admin/admin_dashboard.php");
                break;
            case 'standard':
                header("Location: standard/standard_dashboard.php");
                break;
            case 'student':
                header("Location: student/student_dashboard.php");
                break;
            default:
                echo "❌ Unknown role.";
        }
        exit();
    } else {
        echo "❌ Incorrect password.";
    }
} else {
    echo "❌ Invalid username.";
}

$conn->close();
?>
