<!-- <div class="card border-info">
  <div class="card-header bg-info">Reports</div>
  <div class="card-body">
    <p>View gate entry/exit logs, timestamps, and image captures here.</p>
    <a href="export_report.php" class="btn2">Export as PDF/Excel</a>
  </div>
</div> -->
<?php
include '../db.php';
// $result = $conn->query("SELECT * FROM students ORDER BY timestamp DESC");
$result = $conn->query("SELECT * FROM students ORDER BY Registration_Number ASC");

?>

<!DOCTYPE html>
<html>
<head>
  <title>Gate Entry/Exit Report</title>
  <style>
    body { font-family: Arial; background: #f2f2f2; padding: 20px; }
    table { width: 100%; border-collapse: collapse; background: white; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
    th { background: #17a2b8; color: white; }
    img { width: 60px; height: 60px; object-fit: cover; }
    .btn { margin-top: 10px; padding: 8px 15px; background: #007bff; color: white; border: none; cursor: pointer; }
    .btn:hover { background: #0056b3; }
  </style>
</head>
<body>

<h2>Gate Logs Report</h2>
<table>
  <tr>
    <th>ID</th>
    <th>Reg No</th>
    <th>Name</th>
    <th>Action</th>
    <th>Timestamp</th>
    <th>Photo</th>
  </tr>
  <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['Registration_Number']) ?></td>
      <td><?= htmlspecialchars($row['Name']) ?></td>
    
      <td>
        <?php if ($row['photo']): ?>
          <img src="../uploads/<?= $row['photo'] ?>" alt="Captured Image">
        <?php else: ?>
          N/A
        <?php endif; ?>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

<a href="report.php" class="btn btn-info">View Full Report</a>

</body>
</html>
