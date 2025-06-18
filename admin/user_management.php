<?php
include '../db.php';

// Fetch all users
$admins = $conn->query("SELECT id, username, email, role FROM users");
$students = $conn->query("SELECT id, Registration_Number, Name, email, Department, Program, Class FROM students");
$security = $conn->query("SELECT id, Name, email, Security_ID, Username FROM security");
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link href="../css/style.css" rel="stylesheet">
    <style>
        body { background: #f2f2f2; font-family: Arial, sans-serif; }
        .container { max-width: 1100px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        h2 { color: #006699; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #006699; color: #fff; }
        .btn { padding: 6px 14px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-edit { background: #ffc107; color: #333; }
        .btn-delete { background: #dc3545; color: #fff; }
        .tab-btns { margin-bottom: 20px; }
        .tab-btns button { margin-right: 10px; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
    </style>
    <script>
        function showTab(tab) {
            document.querySelectorAll('.tab-content').forEach(function(el) { el.classList.remove('active'); });
            document.getElementById(tab).classList.add('active');
        }
    </script>
</head>
<body>
<div class="container">
    <h2>User Management</h2>
    <div class="tab-btns">
        <button class="btn btn-edit" onclick="showTab('admins')">Admins</button>
        <button class="btn btn-edit" onclick="showTab('students')">Students</button>
        <button class="btn btn-edit" onclick="showTab('security')">Security</button>
    </div>
    <div id="admins" class="tab-content active">
        <h3>Admins</h3>
        <table>
            <tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Actions</th></tr>
            <?php while($row = $admins->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['role']) ?></td>
                <td>
                    <button class="btn btn-edit">Edit</button>
                    <button class="btn btn-delete">Delete</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <div id="students" class="tab-content">
        <h3>Students</h3>
        <table>
            <tr><th>ID</th><th>Reg No</th><th>Name</th><th>Email</th><th>Department</th><th>Program</th><th>Class</th><th>Actions</th></tr>
            <?php while($row = $students->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['Registration_Number']) ?></td>
                <td><?= htmlspecialchars($row['Name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['Department']) ?></td>
                <td><?= htmlspecialchars($row['Program']) ?></td>
                <td><?= htmlspecialchars($row['Class']) ?></td>
                <td>
                    <button class="btn btn-edit">Edit</button>
                    <button class="btn btn-delete">Delete</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <div id="security" class="tab-content">
        <h3>Security</h3>
        <table>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Security ID</th><th>Username</th><th>Actions</th></tr>
            <?php while($row = $security->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['Name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['Security_ID']) ?></td>
                <td><?= htmlspecialchars($row['Username']) ?></td>
                <td>
                    <button class="btn btn-edit">Edit</button>
                    <button class="btn btn-delete">Delete</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
<script>
    // Show the first tab by default
    showTab('admins');
</script>
</body>
</html> 