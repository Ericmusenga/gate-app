<div class="card border-secondary">
  <div class="card-header bg-secondary">Update Student Info</div>
  <div class="card-body">
    <form action="update_student.php" method="post">
      <label>Student ID:</label><br>
      <input type="text" name="student_id" required><br><br>
      <label>New Email:</label><br>
      <input type="email" name="email"><br><br>
      <label>New Department:</label><br>
      <input type="text" name="department"><br><br>
      <button type="submit">Update</button>
    </form>
  </div>
</div>
