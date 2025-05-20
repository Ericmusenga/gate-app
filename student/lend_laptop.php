<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Lend Laptop</title>

</head>
<body> -->

<!-- <div class="container">
  <h2>Lend a Laptop</h2>
  <form action="" method="POST">
    <label>Registration Number:</label>
    <input type="text" name="Registration_Number" required />

    <label>Laptop Serial Number:</label>
    <input type="text" name="Laptop_SerialNumber" required />

    <button type="submit">Lend Laptop</button>
  </form> -->

  <?php
  include '../db.php';
  $registrationNumber = $_POST['Registration_Number'] ?? '';
  $laptopSerialNumber = $_POST['Laptop_SerialNumber'] ?? '';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if ($registrationNumber && $laptopSerialNumber) {
          $stmt = $conn->prepare("UPDATE students SET laptop_status = 'Lent', Laptop_SerialNumber = ? WHERE Registration_Number = ?");
          $stmt->bind_param("ss", $laptopSerialNumber, $registrationNumber);
          
          if ($stmt->execute()) {
              echo '<div class="message success">Laptop successfully lent.</div>';
          } else {
              echo '<div class="message error">Error updating record: ' . $stmt->error . '</div>';
          }

          $stmt->close();
      } else {
          echo '<div class="message error">Please provide both Registration Number and Laptop Serial Number.</div>';
      }
  }

  $conn->close();
  ?>

  <!-- <div class="back-link">
    <a href="student_dashboard.php">&larr; Back to Student Dashboard</a>
  </div>
</div>

</body>
</html> -->
