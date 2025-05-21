<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
// if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
//     header("Location: login.html");
//     exit();
// }
?> 
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link href="../css/style.css" rel="stylesheet">
</head>
<body>
  <div class="head">
  <h1 class="fixed-header">Welcome To The Smart Gate Entry Management System</h1>
  <a href="../logout.php" class="btn">Logout</a>
  </div>
  <div style="padding-top: 80px;">
    <!-- Your student registration form -->
</div>

<div class="sidebar">
  <h4>UR CE Rukara</h4>
  <!-- <a href="#" onclick="loadContent('userAccount.php')">User Account</a> -->
  <a href="#" onclick="loadContent('register.html')">Register Student</a>
  <a href="#" onclick="loadContent('../visitor.php')">Visitor</a>
  <a href="#" onclick="loadContent('../lend.php')">Security Register</a>
  <a href="#" onclick="loadContent('update.php')">Update Info</a>
  <a href="#" onclick="loadContent('report.php')">View Report</a>
</div>

<div class="main">
  <div id="content">
    <div class="card">
      <div class="card-header bg-primary">Dashboard</div>
      <div class="card-body">
        <p>Welcome to the dashboard managing student entry and exit at UR CE Rukara using RFID technology.</p>
      </div>
    </div>
  </div>
</div>

<script>
  function loadContent(file) {
    fetch(file)
      .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.text();
      })
      .then(html => {
        document.getElementById('content').innerHTML = html;
      })
      .catch(error => {
        document.getElementById('content').innerHTML = `<div class="card"><div class="card-body">Error loading content: ${error}</div></div>`;
      });
  }
    window.onload = function() {
    window.scrollTo(0, 0);
  };
</script>

</body>
</html>
