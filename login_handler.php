<?php
session_start();
include 'db.php';

$role = $_POST['role'] ?? '';
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Check if inputs are filled
if (!$role || !$username || !$password) {
    header("Location: index.php?error=Please+fill+in+all+fields");
    exit();
}

// Role-based login logic
if ($role === 'admin') {
    $stmt = $conn->prepare("SELECT id, Username, password, Role FROM users WHERE Username = ?");
} elseif ($role === 'student') {
    $stmt = $conn->prepare("SELECT id, Registration_Number, password, Name, email, Department, Program, Class, Laptop_SerialNumber, laptop_status, studentcard_Id, photo FROM students WHERE Registration_Number = ?");
} elseif ($role === 'security') {
    $stmt = $conn->prepare("SELECT id, Username, password, Name, Security_ID FROM security WHERE Username = ?");
} else {
    header("Location: index.php?error=Invalid+role+selected");
    exit();
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: index.php?error=User+not+found+or+multiple+accounts");
    exit();
}

$user = $result->fetch_assoc();

// Plain password check (if not hashed yet)
if ($password !== $user['password']) {
    header("Location: index.php?error=Incorrect+password");
    exit();
}

// Set session variables and redirect
if ($role === 'admin') {
    $_SESSION['admin_username'] = $user['Username'];
    $_SESSION['role'] = $user['Role'];
    header("Location: index.php?success=Login+Successful&dashboard=admin/admin_dashboard.php");
    exit();
} elseif ($role === 'student') {
    $_SESSION['student_reg'] = $user['Registration_Number'];
    $_SESSION['student_name'] = $user['Name'];
    $_SESSION['photo'] = $user['photo']; // Optional use
    header("Location: index.php?success=Login+Successful&dashboard=student/student_dashboard.php?reg={$user['Registration_Number']}");
    exit();
} elseif ($role === 'security') {
    $_SESSION['security_username'] = $user['Username'];
    $_SESSION['security_id'] = $user['Security_ID'];
    $_SESSION['security_name'] = $user['Name'];
    header("Location: index.php?success=Login+Successful&dashboard=standard/standard_dashboard.php");
    exit();
}
?>
