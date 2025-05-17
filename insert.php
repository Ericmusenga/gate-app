<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $department = $_POST['department'];
    $program = $_POST['program'];
    $class = $_POST['class'];
    $serial_number = $_POST['serial_number'];

    $sql = "INSERT INTO students (name, department, program, class, serial_number) 
            VALUES ('$name', '$department', '$program', '$class', '$file', '$serial_number')";

    if ($conn->query($sql) === TRUE) {
        echo "New student record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<form method="POST">
    <label>Name:</label><input type="text" name="name" required><br>
    <label>Department:</label><input type="text" name="department" required><br>
    <label>Program:</label><input type="text" name="program" required><br>
    <label>Class:</label><input type="text" name="class" required><br>
    <label>Serial Number:</label><input type="text" name="serial_number" required><br>
    <button type="submit">Submit</button>
</form>
