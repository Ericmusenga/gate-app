<?php
include('db.php');

$sql = "SELECT * FROM students";
$result = $conn->query($sql);

echo "<h2>Student Records</h2>";
echo "<table border='1'>
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Program</th>
            <th>Class</th>
            <th>Photo</th>
            <th>Serial Number</th>
            <th>Actions</th>
        </tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['student_id'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['department'] . "</td>
                <td>" . $row['program'] . "</td>
                <td>" . $row['class'] . "</td>
                <td>" . $row['photo'] . "</td>
                <td>" . $row['serial_number'] . "</td>
                <td>
                    <a href='edit.php?id=" . $row['student_id'] . "'>Edit</a> | 
                    <a href='delete.php?id=" . $row['student_id'] . "'>Delete</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='8'>No records found</td></tr>";
}

echo "</table>";
?>
