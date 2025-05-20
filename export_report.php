<?php
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=entry_logs.xls");

include '../db.php';
$result = $conn->query("SELECT * FROM entry_logs ORDER BY timestamp DESC");

echo "<table border='1'>";
echo "<tr><th>ID</th><th>Reg No</th><th>Name</th><th>Action</th><th>Timestamp</th></tr>";

while($row = $result->fetch_assoc()) {
  echo "<tr>";
  echo "<td>{$row['id']}</td>";
  echo "<td>{$row['Registration_Number']}</td>";
  echo "<td>{$row['Name']}</td>";
  echo "<td>{$row['action']}</td>";
  echo "<td>{$row['timestamp']}</td>";
  echo "</tr>";
}

echo "</table>";
?>
