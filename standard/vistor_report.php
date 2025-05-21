<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'gate';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Export logic
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=visitor_report.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Visitor Name', 'ID Number', 'Visit Reason', 'District', 'Sector', 'Visit Time']);

    $sql = "SELECT `id`, `visitor_name`, `id_number`, `visit_reason`, `district`, `sector`, `visit_time` FROM `visitors`";
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

<!-- HTML Content for AJAX -->
<div class="card border-info">
  <div class="card-header bg-info">Visitor Reports</div>
  <div class="card-body">
    <p>View gate entry/exit logs, timestamps, and visitor information.</p>
    <a href="export_report.php?export=csv" class="btn2">Export as CSV</a>

    <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
      <tr style="background-color: #3a80cb; color: white;">
        <th>ID</th>
        <th>Visitor Name</th>
        <th>ID Number</th>
        <th>Visit Reason</th>
        <th>District</th>
        <th>Sector</th>
        <th>Visit Time</th>
      </tr>
      <?php
      $sql = "SELECT `id`, `visitor_name`, `id_number`, `visit_reason`, `district`, `sector`, `visit_time` FROM `visitors`";
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
                      <td>{$row['visit_time']}</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='7'>No visitor records found.</td></tr>";
      }
      $conn->close();
      ?>
    </table>
  </div>
</div>
