<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Profile</title>
  <style>
    body { font-family: Arial, sans-serif; background-color: #f4f6f8; padding: 40px; }
    .profile-card {
      width: 700px;
      margin: auto;
      background: white;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .header {
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      color: #1a73e8;
      margin-bottom: 30px;
    }
    .info {
      display: flex;
      justify-content: space-between;
    }
    .details { width: 65%; }
    .details p { margin: 10px 0; font-size: 16px; }
    .details strong { color: #333; }
    .photo {
      width: 150px; height: 180px;
      background: #e0e0e0;
      border-radius: 5px;
      overflow: hidden;
    }
    .photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  </style>
</head>
<body>

<div class="profile-card">
  <div class="header">Student Profile</div>
  <?php if ($student): ?>
  <div class="info">
    <div class="details">
      <p><strong>Registration Number:</strong> <?= $student['Registration_Number'] ?></p>
      <p><strong>Names:</strong> <?= htmlspecialchars($student['Name']) ?></p>
      <p><strong>Department:</strong> <?= $student['Department'] ?></p>
      <p><strong>Program:</strong> <?= $student['Program'] ?></p>
      <p><strong>Class:</strong> <?= $student['Class'] ?></p>
      <p><strong>Laptop Serial Number:</strong> <?= $student['Laptop_SerialNumber'] ?></p>
      <p><strong>Laptop Status:</strong> <?= $student['laptop_status'] ?></p>
      <p><strong>Student Card ID:</strong> <?= $student['studentcard_Id'] ?></p>
    </div>
    <div class="photo">
      <?php if (!empty($student['photo'])): ?>
        <img src="../uploads/<?= $student['photo'] ?>" alt="Student Photo">
      <?php else: ?>
        <div style="padding:10px; text-align:center;">No Photo</div>
      <?php endif; ?>
    </div>
  </div>
  <?php else: ?>
    <p style="text-align:center; color:red;">Student not found. Please scan your card or log in.</p>
  <?php endif; ?>
</div>

</body>
</html>
