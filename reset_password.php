<?php
require_once 'db.php';
$token = $_GET['token'] ?? ($_POST['token'] ?? '');
$show_form = true;
if ($token) {
    // Check if token exists and is not expired
    $stmt = $conn->prepare('SELECT * FROM password_resets WHERE token = ?');
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if (strtotime($row['expires_at']) < time()) {
            echo '<div style="color: red;">This reset link has expired.</div>';
            $show_form = false;
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $password = $_POST['password'] ?? '';
                $confirm = $_POST['confirm'] ?? '';
                if ($password !== $confirm) {
                    echo '<div style="color: red;">Passwords do not match.</div>';
                } else {
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $role = $row['role'];
                    $email = $row['email'];
                    if ($role === 'admin') {
                        $stmt2 = $conn->prepare('UPDATE users SET password = ? WHERE email = ?');
                        $stmt2->bind_param('ss', $hashed, $email);
                    } elseif ($role === 'student') {
                        $stmt2 = $conn->prepare('UPDATE students SET password = ? WHERE email = ?');
                        $stmt2->bind_param('ss', $hashed, $email);
                    } elseif ($role === 'security') {
                        $stmt2 = $conn->prepare('UPDATE security SET password = ? WHERE email = ?');
                        $stmt2->bind_param('ss', $hashed, $email);
                    } else {
                        echo '<div style="color: red;">Invalid role for password reset.</div>';
                        $show_form = false;
                        goto endform;
                    }
                    $stmt2->execute();
                    // Invalidate token
                    $stmt3 = $conn->prepare('DELETE FROM password_resets WHERE token = ?');
                    $stmt3->bind_param('s', $token);
                    $stmt3->execute();
                    echo '<div style="color: green;">Your password has been reset. You may now <a href="index.php">login</a>.</div>';
                    $show_form = false;
                }
            }
        }
    } else {
        echo '<div style="color: red;">Invalid or used reset link.</div>';
        $show_form = false;
    }
}
endform:
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <h2>Reset Password</h2>
    <?php if ($show_form): ?>
    <form method="POST" action="">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <label for="password">New Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <label for="confirm">Confirm Password:</label><br>
        <input type="password" id="confirm" name="confirm" required><br><br>
        <button type="submit">Reset Password</button>
    </form>
    <?php endif; ?>
    <a href="index.php">Back to Login</a>
</body>
</html> 