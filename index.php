<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Gate Access System - Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .login-box {
      background: #fff;
      padding: 30px;
      width: 350px;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
    .login-box h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #006699;
    }
    .login-box label {
      font-size: 14px;
      display: block;
    }
    .login-box input,
    .login-box select {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .login-box button {
      width: 100%;
      padding: 10px;
      background: #006699;
      border: none;
      color: #fff;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
    }
    .login-box button:hover {
      background: #005580;
    }
    .message {
      text-align: center;
      margin-bottom: 15px;
      font-weight: bold;
    }
    .error { color: #a94442; }
    .success { color: #155724; }
  </style>
</head>
<body>

<div class="login-box">
  <?php if(isset($_GET['error'])): ?>
    <div class="message error"><?php echo htmlspecialchars($_GET['error']); ?></div>
  <?php endif; ?>
  <?php if(isset($_GET['success']) && isset($_GET['dashboard'])): ?>
    <div class="message success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <!-- NO eval, NO unsafe inline JS -->
    <noscript><meta http-equiv="refresh" content="2;url=<?php echo htmlspecialchars($_GET['dashboard']); ?>"></noscript>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const urlParams = new URLSearchParams(window.location.search);
        const redirect = urlParams.get("dashboard");
        if (redirect) {
          setTimeout(() => {
            window.location.href = redirect;
          }, 2000);
        }
      });
    </script>
  <?php endif; ?>

  <h2>Gate System Login</h2>
  <form action="login_handler.php" method="POST">
    <label for="role">Login As:</label>
    <select name="role" id="role" autocomplete="off" required>
      <option value="">-- Select User Type --</option>
      <option value="admin">Admin</option>
      <option value="student">Student</option>
      <option value="security">Security</option>
    </select>

    <label for="username">Username or Reg Number:</label>
    <input type="text" name="username" id="username" autocomplete="username" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" autocomplete="current-password" required>

    <button type="submit">Login</button>

    <a href="forgot_password.php" style="display:block;text-align:center;margin-top:10px;text-decoration:none;background:#eee;color:#006699;padding:10px;border-radius:5px;">
      Forgot Password?
    </a>
  </form>
</div>

</body>
</html>
