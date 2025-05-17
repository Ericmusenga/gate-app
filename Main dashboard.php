<?php include("auth/session_check.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Gate Entry Dashboard - UR CE Rukara</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { margin: 0; font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; }
    .sidebar {
      width: 260px;
      background-color: #003366;
      color: white;
      height: 100vh;
      position: fixed;
      padding: 20px;
    }
    .sidebar h5 { font-weight: bold; }
    .sidebar a {
      color: white;
      display: block;
      margin: 15px 0;
      text-decoration: none;
    }
    .sidebar a:hover { text-decoration: underline; }
    .main {
      margin-left: 280px;
      padding: 30px;
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .header h3 { margin: 0; }
    .card { margin-top: 20px; }
  </style>
</head>
<body>

  <div class="sidebar">
    <h5>UR CE Rukara</h5>
    <a href="index.php?page=user">User Account</a>
    <a href="index.php?page=report">View Report</a>
    <a href="index.php?page=visitor">Visitor</a>
    <a href="index.php?page=register">Register Student</a>
    <a href="index.php?page=update">Update Info</a>
    <a href="index.php?page=lend">Lend Computer</a>
    <!-- <a href="index.php?page=login">Login</a> -->
    <a href="login.php?page=logout">Logout</a>
  </div>

  <div class="main">
    <div class="header mb-4">
      <h3>Smart Gate Entry Management System</h3>
      <!-- <span><strong>Academic Year:</strong> 2024 - 2025</span> -->
    </div>

    <div id="content">
      <?php
        $page = $_GET['page'] ?? '';
        switch ($page) {
          case 'user': include("includes/user_account.php"); break;
          case 'report': include("includes/report.php"); break;
          case 'visitor': include("includes/visitor.php"); break;
          case 'register': include("includes/register_student.php"); break;
          case 'update': include("includes/update_info.php"); break;
          case 'lend': include("includes/lend_computer.php"); break;
        //   case 'login': include("includes/login.php"); break;
          case 'logout': include("includes/logout.php"); break;
          default:
            echo '<div class="card border-primary">
                    <div class="card-header bg-primary text-white">Dashboard</div>
                    <div class="card-body">
                      <p>Welcome to the dashboard for monitoring and managing student entry and exit at UR CE Rukara using RFID technology and machine monitoring.</p>
                    </div>
                  </div>';
        }
      ?>
    </div>
  </div>
</body>
</html>
