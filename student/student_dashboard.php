<?php
// session_start();
// if (!isset($_SESSION['student_id'])) {
//     header("Location: login.php");
//     exit();
// }

require_once '../db.php';

// $studentId = $_SESSION['student_id'];
// $query = "SELECT * FROM students WHERE reg_number = '$studentId'";
// $result = mysqli_query($conn, $query);
// $student = mysqli_fetch_assoc($result);
// 
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
                <p><strong>Names:</strong> <span id="names">___________________________</span></p>
                <p><strong>Reg No:</strong> <span id="regno">___________________________</span></p>
                <p><strong>Year of Study:</strong> <span id="year">_____________________</span></p>
                <p><strong>Department:</strong> <span id="dept">______________________</span></p>
                <p><strong>Program:</strong> <span id="program">_______________________</span></p>
                <p><strong>Study Mode:</strong> <span id="mode">______________________</span></p>
                <p><strong>Serial Number:</strong> <span id="serial">____________________</span></p>
            </div>
            <div class="photo" id="photo-box">
                <!-- Optional photo will appear here -->
                Photo
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
                <h4 class="mb-4 text-center">Lend Laptop</h4>
                <form action="lend_laptop.php" method="POST">
                  <div class="mb-3">
                    <label for="regNumber" class="form-label">Registration Number</label>
                    <input type="text" name="regNumber" class="form-control" value="<?php echo htmlspecialchars($student['reg_number']); ?>" readonly>
                  </div>
                  <div class="mb-3">
                    <label for="serialNumber" class="form-label">Laptop Serial Number</label>
                    <input type="text" name="serialNumber" class="form-control" required>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-success">Request Lending</button>
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
                    <label for="regNumberReturn" class="form-label">Registration Number</label>
                    <input type="text" name="regNumberReturn" class="form-control" value="<?php echo htmlspecialchars($student['reg_number']); ?>" readonly>
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

        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  // Sample student data
  const studentInfo = {
    names: "Eric Uwizeyimana",
    regNo: "2222223456",
    year: "3",
    department: "Computer and Software Engineering",
    program: "BTech in Embedded Systems",
    mode: "Full-Time",
    serial: "UR-ES-2025-001",
    photoUrl: "./upload/1747499528_we.jpeg"

    //photoUrl: "https://via.placeholder.com/100x120.png?text=Student+Photo" // Replace with actual photo
  };

  // Fill the HTML with the student data
  document.getElementById("names").textContent = studentInfo.names;
  document.getElementById("regno").textContent = studentInfo.regNo;
  document.getElementById("year").textContent = studentInfo.year;
  document.getElementById("dept").textContent = studentInfo.department;
  document.getElementById("program").textContent = studentInfo.program;
  document.getElementById("mode").textContent = studentInfo.mode;
  document.getElementById("serial").textContent = studentInfo.serial;

  // Load photo if available
  if (studentInfo.file) {
    const photoBox = document.getElementById("photo-box");
    photoBox.innerHTML = `<img src="${studentInfo.file}" alt="Student Photo">`;
  }
</script>
</body>
</html>
