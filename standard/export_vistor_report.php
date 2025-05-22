<?php
// ===== delete_visitor.php =====
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $conn = new mysqli('localhost', 'root', '', 'gate');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM visitors WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Visitor deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "welcome to visitor info";
}
?>

<!-- ===== export_vistor_report.php ===== -->
<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'gate';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=export_vistor_report.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Visitor Name', 'ID Number', 'Visit Reason', 'District', 'Sector', 'Equipment', 'Visit Time']);

    $sql = "SELECT id, visitor_name, id_number, visit_reason, district, sector, equipment, visit_time FROM visitors";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
    } else {
        fputcsv($output, ['No records found']);
    }

    fclose($output);
    exit;
}
?>

<style>
h2 {
    text-align: center;
    color: #333;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
    background: white;
}
th, td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}
th {
    background: #3a80cb;
    color: white;
}
tr:nth-child(even) {
    background-color: #f9f9f9;
}
.export-btn:hover {
    background-color: darkred;
}
</style>

<div class="card border-info">
  <div class="card-header bg-info">Visitor Reports</div>
  <div class="card-body">
    <p>View gate entry/exit logs, timestamps, and visitor information.</p>
    <a href="export_vistor_report.php?export=csv" class="btn2">Export as CSV</a>

    <table>
      <tr>
        <th>ID</th>
        <th>Visitor Name</th>
        <th>ID Number</th>
        <th>Visit Reason</th>
        <th>District</th>
        <th>Sector</th>
        <th>Equipment</th>
        <th>Visit Time</th>
        <th>Actions</th>
      </tr>
      <?php
      $sql = "SELECT id, visitor_name, id_number, visit_reason, district, sector, equipment, visit_time FROM visitors";
      $result = $conn->query($sql);
      if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['visitor_name']}</td>
                      <td>{$row['id_number']}</td>
                      <td>{$row['visit_reason']}</td>
                      <td>{$row['district']}</td>
                      <td>{$row['sector']}</td>
                      <td>{$row['equipment']}</td>
                      <td>{$row['visit_time']}</td>
                      <td>
                        <button class='btn3' onclick='deleteVisitor({$row['id']})'>Delete</button>
                        <a href='edit_visitor.php?id={$row['id']}' class='btn3'>Edit</a>
                      </td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='9'>No visitor records found.</td></tr>";
      }
      $conn->close();
      ?>
    </table>

    <script>
    function deleteVisitor(id) {
        if (confirm("Are you sure you want to delete this visitor?")) {
            fetch('delete_visitor.php?id=' + id)
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => {
                alert("Error deleting: " + error);
            });
        }
    }
    </script>
  </div>
</div>
