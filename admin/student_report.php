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
    header('Content-Disposition: attachment; filename=students_report.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Registration Number', 'Name', 'Department', 'Program', 'Class', 'Laptop Serial Number', 'Laptop Status', 'Student Card ID', 'Photo', 'Created At']);

    $sql = "SELECT id, Registration_Number, Name, Department, Program, Class, Laptop_SerialNumber, laptop_status, studentcard_Id, photo, created_at FROM students";
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

<!DOCTYPE html>
<html>
<head>
    <title>Student Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .card {
            background: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
        }

        .btn2 {
            background: #3a80cb;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn2:hover {
            background: darkblue;
        }

        .btn3 {
            background: #ff4d4d;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            margin: 2px;
            cursor: pointer;
        }

        .btn3:hover {
            background-color: #d11a2a;
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
            vertical-align: middle;
        }

        th {
            background: #3a80cb;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        img {
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Student Reports</h2>
    <p>View and manage all registered students.</p>
    <a href="student_report.php?export=csv" class="btn2">Export as CSV</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Reg No</th>
            <th>Name</th>
            <th>Department</th>
            <th>Program</th>
            <th>Class</th>
            <th>Laptop Serial Number</th>
            <th>Laptop Status</th>
            <th>Card ID</th>
            <th>Photo</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>

        <?php
        $sql = "SELECT id, Registration_Number, Name, Department, Program, Class, Laptop_SerialNumber, laptop_status, studentcard_Id, photo, created_at FROM students";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $photoHtml = $row['photo'] ? "<img src='uploads/{$row['photo']}' width='60'>" : "N/A";

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
                    <td>{$photoHtml}</td>
                    <td>{$row['created_at']}</td>
                    <td>
                        <button class='btn3' onclick=\"deleteStudent({$row['id']})\">Delete</button>
                        <a href='edit_student.php?id={$row['id']}' class='btn3' style='background:#3a80cb;'>Edit</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='12'>No student records found.</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</div>

<script>
function deleteStudent(id) {
    if (confirm("Are you sure you want to delete this student?")) {
        fetch('delete_student.php?id=' + id)
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload(); // Refresh to reflect deletion
        })
        .catch(error => {
            alert("Error deleting: " + error);
        });
    }
}

</script>

</body>
</html>
