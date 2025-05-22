<?php
include '../db.php';
session_start();

//Use session to protect the dashboard and fetch student info
if (!isset($_SESSION['Registration_Number'])) {
    header("Location: ../index.html");
    exit();
}

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
// <input type="hidden" name="borrower" value="<?php echo $_SESSION['Registration_Number']; 
// ?>">

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
      /* color:rgb(155, 173, 178) !important; */
    }

  .header {
    font-weight: bold;
    font-size: 1.2rem;
    margin-bottom: 15px;
  }
  .info {
    display: flex;
    justify-content: space-between;
    gap: 40px;
  }
  .details {
    flex: 1;
  }
  .photo img {
    border-radius: 10px;
    border: 1px solid #ccc;
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

          <!-- Lend Laptop --><div class="tab-pane fade" id="lendLaptop">
  <div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
      <h4 class="mb-4 text-center">Approve Laptop Lending</h4>
      <form action="lend_laptop.php" method="POST">
        <!-- Hidden input for original owner (from session) -->
        <input type="hidden" name="original_owner" value="<?php echo htmlspecialchars($_SESSION['Registration_Number']); ?>">

        <div class="mb-3">
          <label for="borrower" class="form-label">Borrower's Registration Number</label>
          <input type="text" name="borrower" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="laptop_serial" class="form-label">Laptop Serial Number</label>
          <input type="text" name="laptop_serial" class="form-control" required>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary">Approve Lending</button>
        </div>
      </form>
    </div>
  </div>
</div>

          <!-- Return Laptop -->
          <div class="tab-pane fade" id="returnLaptop">
  <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card p-4 shadow" style="width: 100%; max-width: 500px;">
      <h4 class="text-center mb-3">Request to Return Laptop</h4>
      <form action="return_laptop.php" method="POST">
        <!-- Borrower Registration Number (readonly from session/profile) -->
        <div class="mb-3">
          <label for="Registration_Number" class="form-label">Your Registration Number</label>
          <input type="text" name="borrower" class="form-control" value="<?php echo htmlspecialchars($student['Registration_Number']); ?>" readonly>
        </div>

        <!-- Laptop Serial Number -->
        <div class="mb-3">
          <label for="Laptop_SerialNumber" class="form-label">Laptop Serial Number</label>
          <input type="text" name="laptop_serial" class="form-control" required>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
          <button type="submit" class="btn btn-warning">Request Return</button>
        </div>
      </form>
    </div>
  </div>
</div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
