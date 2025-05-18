<!-- 
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
    <a href="#" onclick="loadContent('report.php')">View Report</a>
    <a href="#" onclick="loadContent('visitor.php')">Visitor</a>
    <a href="#" onclick="loadContent('lend.php')">Lend Computer</a>
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

    // function loadContent(tab) {
    //   let content = '';

    //   if (tab === 'report') {
    //     content = `
    //       <div class="card border-info">
    //         <div class="card-header bg-info text-white">View Report</div>
    //         <div class="card-body">
    //           <p>Check gate entry logs, machine capture images, and verification statuses.</p>
    //         </div>
    //       </div>`;
    //   } else if (tab === 'visitor') {
    //     content = `
    //       <div class="card border-warning">
    //         <div class="card-header bg-warning text-dark">Visitor</div>
    //         <div class="card-body">
    //           <p>Register a new visitor, Register He/she Details.</p>
    //           <button class="btn btn-dark">Register A visitor Here</button>
    //         </div>
    //       </div>`;
    //   } else if (tab === 'lend') {
    //     content = `
    //       <div class="card border-dark">
    //         <div class="card-header bg-dark text-white">Lend Computer</div>
    //         <div class="card-body">
    //           <p>Allow a student to temporarily lend their computer to another student.</p>
    //           <button class="btn btn-dark">Open Lending Form</button>
    //         </div>
    //       </div>`;
    //   }

    //   document.getElementById('content').innerHTML = content;
    // }
  </script>

</body>
</html> -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'standard') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin standard Dashboard</title>
  <link href="../css/style.css" rel="stylesheet">
</head>
<body>

<h1>Welcome To The Smart Gate Entry Management System</h1>
<button class="toggle-btn" onclick="toggleSidebar()">☰</button>
<a href="../logout.php" class="btn btn-danger logout-btn">Logout</a>

<div class="sidebar" id="sidebar">
  <h5>UR CE Rukara Gate Security</h5>
  <a href="#" onclick="loadContent('visitor_report.php')">View Vistor Report</a>
  <a href="#" onclick="loadContent('../visitor.php')">Visitor</a>
  <a href="#" onclick="loadContent('../lend.php')">Lend Computer</a>
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
</script>

</body>
</html>
