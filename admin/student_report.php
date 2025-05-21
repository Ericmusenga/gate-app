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
    header('Content-Disposition: attachment; filename=vistor_report.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Visitor Name', 'ID Number', 'Visit Reason', 'Sector', 'District', 'Visit Time']);

    $sql = "SELECT `id`, `visitor_name`, `id_number`, `visit_reason`, `sector`, `district`, `visit_time` FROM `visitors`";
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
    <a href="student_report.php?export=csv" class="btn2">Export as CSV</a>

    <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
      <tr style="background-color: #3a80cb; color: white;">
        <th>ID</th>
        <th>Reg No</th>
        <th>Name</th>
        <th>Department<th>
        <th>Program<th>
        <th>Class<th>
        <th>Laptop_SerialNumber<th>
        <th>laptop_status<th>
        <th>studentcard_Id<th>
        <th>Photo</th> 
        <th>TIME</th> 
        <th>Actions</th>

      </tr>
      <?php
      $sql = "SELECT `id`, `Registration_Number`, `Name`, `Department`, `Program`, `Class`, `Laptop_SerialNumber`, `laptop_status`, `studentcard_Id`, `photo`, `created_at` FROM `students`";
      $result = $conn->query($sql);
      if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $photoHtml = $row['photo'] ? "<img src='uploads/{$row['photo']}' alt='Captured Image' width='60'>" : "N/A";

                echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['Registration_Number']}</td>
                <td>{$row['Name']}</td>
                <td>{$row['Department']}</td>
                <td>{$row['Program']}</td>
                <td>{$row['Class']}</td>
                <td>{$row['Laptop_SerialNumber']}</td>
                <td>{$row['laptop_status']}</td>
                <td>{$row['studentcard_Id']}</td>
                <td>$photoHtml</td>
                <td>{$row['created_at']}</td>
                <td>
                    <button class='btn3' onclick=\"deleteVisitor({$row['id']})\">Delete</button>
                    <a href='edit_visitor.php?id={$row['id']}' class='btn3'>Edit</a>
                </td>
                </tr>";

          }
        } else {
            echo "<tr><td colspan='7'>No visitor records found.</td></tr>";
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
            loadContent('admin_dashboard.php'); // Reload updated content
        })
        .catch(error => {
            alert("Error deleting: " + error);
        });
    }
    }
    </script>

  </div>
</div>
