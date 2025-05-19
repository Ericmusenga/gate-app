<!-- Visitor Registration Card -->
 <!DOCTYPE html>
<html lang="en">
 <header
 <div class="header">
  <!-- <a href="../logout.php" class="logout-btn">Logout</a> -->
</div>
</header>
<div class="card border-warning visitor-card">
  <div class="card-header bg-warning text-white text-center">
    <style>
    /* Visitor Registration */
    .visitor-card {
  max-width: 500px;
  margin: 40px auto;
  box-shadow: 0 4px 8px rgba(109, 180, 180, 0.1);
  border-radius: 8px;
}

.visitor-form {
  padding: 15px;
}

.visitor-form .form-group {
  margin-bottom: 15px;
}

.visitor-form label {
  font-weight: bold;
  margin-bottom: 10px;
  display: white;
}

.visitor-form input[type="text"] {
  width: 80%;
  padding: 8px 12px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
</style>
  </div>
  <div class="card-body">
    <h3 class="text-center mb-4"> <center> Visitor Form </center></h3>
    <form action="visitor_process.php" method="post" class="visitor-form">
      <div class="form-group">
        <label for="firstname">First Name</label>
        <input type="text" name="firstname" id="firstname" class="form-control" required>
      </div>
      
      <div class="form-group">
        <label for="lastname">Last Name</label>
        <input type="text" name="lastname" id="lastname" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="purpose">Purpose of Visit</label>
        <input type="text" name="purpose" id="purpose" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="visitor_id">Visitor ID</label>
        <input type="text" name="visitor_id" id="visitor_id" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="equipment">Equipment (if any)</label>
        <input type="text" name="equipment" id="equipment" class="form-control">
      </div>

      <div class="text-center mt-3">
        <button type="submit" class="btn btn-success form-submit-btn btn">Register</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>