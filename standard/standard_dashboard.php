<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
// if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'standard') {
//     header("Location: ../index.html");
//     exit();
// }
?>
<!DOCTYPE html>
<html>
<head>
  <title>standard Dashboard</title>
  <link href="../css/style.css" rel="stylesheet">
</head>
<body>
  <a href="../logout.php" class="btn">Logout</a>
  <h1 class="fixed-header">Welcome To The Smart Gate Entry Management System </h1>

<div class="sidebar" id="sidebar">
  <h5>UR CE Rukara Gate Security</h5>
  <a href="#" onclick="loadContent('visitor_report.php')">View Vistor Report</a>
  <a href="#" onclick="loadContent('../visitor.php')">Visitor</a>
  <!-- <a href="#" onclick="loadContent('../lend.php')">Lend Computer</a> -->
</div>

<div class="main">
  <div id="content">
    <div class="card">
      <div class="card-header bg-primary">Dashboard</div>
      <div class="card-body">
        <p>Welcome to the dashboard managing Visitors entry at UR CE Rukara using RFID technology.</p>
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
</script>

</body>
</html>
