<?php
require_once 'db.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'] ?? '';
    $email = $_POST['email'] ?? '';
    $table = '';
    $email_column = 'email';
    if ($role === 'admin') {
        $table = 'users';
    } elseif ($role === 'student') {
        $table = 'students';
    } elseif ($role === 'security') {
        $table = 'security';
    }
    if ($table) {
        $stmt = $conn->prepare("SELECT * FROM $table WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Email exists, generate token
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', time() + 3600); // 1 hour expiry
            // Store in password_resets (store role for later)
            $stmt2 = $conn->prepare('INSERT INTO password_resets (email, token, expires_at, role) VALUES (?, ?, ?, ?)');
            $stmt2->bind_param('ssss', $email, $token, $expires, $role);
            $stmt2->execute();
            // Display reset link (for development)
            $reset_link = "http://localhost/Project_capstone/reset_password.php?token=$token";
            $message = '<div style="color: green; text-align:center; margin-bottom:20px;">Reset link (for testing): <a href="' . $reset_link . '">' . $reset_link . '</a></div>';
        } else {
            $message = '<div style="color: red; text-align:center; margin-bottom:20px;">Email not found for this role.</div>';
        }
    } else {
        $message = '<div style="color: red; text-align:center; margin-bottom:20px;">Invalid role selected.</div>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link href="css/style.css" rel="stylesheet">
    <style>
        body {
            background: #f2f2f2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .forgot-card {
            background: #fff;
            padding: 32px 28px 24px 28px;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
        .forgot-card h2 {
            text-align: center;
            color: #006699;
            margin-bottom: 18px;
        }
        .forgot-card label {
            font-weight: 500;
            margin-bottom: 6px;
            display: block;
        }
        .forgot-card input, .forgot-card select {
            width: 100%;
            padding: 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .forgot-card button {
            width: 100%;
            padding: 10px;
            background: #006699;
            border: none;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
        .forgot-card button:hover {
            background: #005580;
        }
        .forgot-card .back-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: #006699;
            text-decoration: none;
        }
        .forgot-card .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="forgot-card">
        <?php if ($message) echo $message; ?>
        <h2>Forgot Password</h2>
        <form method="POST" action="">
            <label for="role">Select your role:</label>
            <select id="role" name="role" required>
                <option value="">-- Select Role --</option>
                <option value="admin">Admin</option>
                <option value="student">Student</option>
                <option value="security">Security</option>
            </select>
            <label for="email">Enter your email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Send Reset Link</button>
        </form>
        <a href="index.php" class="back-link">Back to Login</a>
    </div>
</body>
</html> 