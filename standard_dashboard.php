<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'Standard') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Gate Entry Dashboard - UR CE Rukara</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
  <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>

  <div class="sidebar" id="sidebar">
    <h5>UR CE Rukara Gate Security</h5>
    <a href="#" onclick="loadContent('report')">View Report</a>
    <a href="#" onclick="loadContent('visitor')">Visitor</a>
    <a href="#" onclick="loadContent('lend')">Lend Computer</a>
  </div>

  <div class="main" id="main">
    <div class="header mb-4">
      <h3>Smart Gate Entry Management System</h3>
    </div>

    <div id="content">
      <div class="card border-primary">
        <div class="card-header bg-primary text-white">Dashboard</div>
        <div class="card-body">
          <p>Welcome to the dashboard for monitoring and managing student entry and exit at UR CE Rukara using RFID technology.</p>
        </div>
      </div>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('collapsed');
      document.getElementById('main').classList.toggle('collapsed');
    }

    function loadContent(tab) {
      let content = '';

      if (tab === 'report') {
        content = `
          <div class="card border-info">
            <div class="card-header bg-info text-white">View Report</div>
            <div class="card-body">
              <p>Check gate entry logs, machine capture images, and verification statuses.</p>
            </div>
          </div>`;
      } else if (tab === 'visitor') {
        content = `
          <div class="card border-warning">
            <div class="card-header bg-warning text-dark">Visitor</div>
            <div class="card-body">
              <p>Register a new visitor, Register He/she Details.</p>
              <button class="btn btn-dark">Register A visitor Here</button>
            </div>
          </div>`;
      } else if (tab === 'lend') {
        content = `
          <div class="card border-dark">
            <div class="card-header bg-dark text-white">Lend Computer</div>
            <div class="card-body">
              <p>Allow a student to temporarily lend their computer to another student.</p>
              <button class="btn btn-dark">Open Lending Form</button>
            </div>
          </div>`;
      }

      document.getElementById('content').innerHTML = content;
    }
  </script>

</body>
</html>
