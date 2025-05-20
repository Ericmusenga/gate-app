<?php
include '../db.php';
// session_start();

// Use session to protect the dashboard and fetch student info
// if (!isset($_SESSION['Registration_Number'])) {
//     header("Location: ../index.html");
//     exit();
// }

$regNo = $_GET['reg'] ?? '';

$student = null;

if ($regNo) {
    $stmt = $conn->prepare("SELECT * FROM students WHERE Registration_Number = ?");
    $stmt->bind_param("s", $regNo);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <style>
    .sidebar {
      min-height: 100vh;
      border-right: 1px solid #2b7603;
    }
    .nav-link.active {
      background-color: #a8bdffdb;
      color: #4d8a9c !important;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">

      <!-- Sidebar -->
      <div class="col-md-3 sidebar bg-light p-4">
        <h4>🎓 Student Dashboard</h4>
        <ul class="nav flex-column nav-pills" id="sidebarTabs">
          <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="pill" href="#profile">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="pill" href="#changePassword">Change Password</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="pill" href="#lendLaptop">Lend Laptop</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="pill" href="#returnLaptop">Return Laptop</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="pill" href="#securityRegister">Security Register</a>
          </li>
          <li class="nav-item mt-4">
            <a class="btn btn-danger w-100" href="../logout.php">Logout</a>
          </li>
        </ul>
      </div>

      <!-- Main Content -->
      <div class="col-md-9 p-4">
        <div class="tab-content" id="tabContent">

          <!-- Profile -->
          <div class="tab-pane fade show active" id="profile">
            <div class="header">UR CE - RUKARA<br>STUDENT INFO</div>
            <div class="info">
              <div class="details" id="student-details">
                <p><strong>Names:</strong> <span id="names"><?php echo htmlspecialchars($student['Name'] ?? ''); ?></span></p>
                <p><strong>Reg No:</strong> <span id="regno"><?php echo htmlspecialchars($student['Registration_Number'] ?? ''); ?></span></p>
                <p><strong>Year of Study:</strong> <span id="year"><?php echo htmlspecialchars($student['Class'] ?? ''); ?></span></p>
                <p><strong>Department:</strong> <span id="dept"><?php echo htmlspecialchars($student['Department'] ?? ''); ?></span></p>
                <p><strong>Program:</strong> <span id="program"><?php echo htmlspecialchars($student['Program'] ?? ''); ?></span></p>
                <p><strong>Study Mode:</strong> <span id="mode"><?php echo htmlspecialchars($student['Study_Mode'] ?? ''); ?></span></p>
                <p><strong>Serial Number:</strong> <span id="serial"><?php echo htmlspecialchars($student['Laptop_SerialNumber'] ?? ''); ?></span></p>
              </div>
              <div class="photo" id="photo-box">
                <?php
                  if (!empty($student['photo'])) {
                    echo '<img src="../upload/' . htmlspecialchars($student['photo']) . '" alt="Student Photo" width="100" height="120">';
                  } else {
                    echo 'No Photo';
                  }
                ?>
              </div>
            </div>
          </div>

          <!-- Change Password -->
          <div class="tab-pane fade" id="changePassword">
            <div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
              <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
                <h4 class="mb-4 text-center">Change Password</h4>
                <form action="change_password.php" method="POST">
                  <div class="mb-3">
                    <label for="currentPassword" class="form-label">Current Password</label>
                    <input type="password" name="currentPassword" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label for="newPassword" class="form-label">New Password</label>
                    <input type="password" name="newPassword" class="form-control" required>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Lend Laptop -->
          <div class="tab-pane fade" id="lendLaptop">
            <div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
              <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
                <h4 class="mb-4 text-center">Lend a Laptop</h4>
                <form action="lend_laptop.php" method="POST">
                  <div class="mb-3">
                    <label for="text" class="form-label">Registration Number</label>
                    <input type="text" name="Registration_Number" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label for="text" class="form-label">Laptop SerialNumber</label>
                    <input type="text" name="Laptop_SerialNumber" class="form-control" required>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Lend Laptop</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Return Laptop -->
          <div class="tab-pane fade" id="returnLaptop">
            <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
              <div class="card p-4 shadow" style="width: 100%; max-width: 500px;">
                <h4 class="text-center mb-3">Return Laptop</h4>
                <form action="return_laptop.php" method="POST">
                  <div class="mb-3">
                    <label for="Registration_Number" class="form-label">Registration Number</label>
                    <input type="text" name="Registration_Number" class="form-control" value="<?php echo htmlspecialchars($student['Registration_Number']); ?>" readonly>
                  </div>
                  <div class="mb-3">
                    <label for="serialNumberReturn" class="form-label">Laptop Serial Number</label>
                    <input type="text" name="serialNumberReturn" class="form-control" required>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-warning">Request Return</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Security Register -->
          <div class="tab-pane fade" id="securityRegister">
            <div class="card border-dark">
              <div class="card-header bg-dark text-white">Security Register</div>
              <div class="card-body">
                <form action="lend_process.php" method="post">
                  <div class="mb-3">
                    <label for="lender_id" class="form-label">Lender ID</label>
                    <input type="text" name="lender_id" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label for="borrower_id" class="form-label">Borrower ID</label>
                    <input type="text" name="borrower_id" class="form-control" required>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-success">Lend</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
