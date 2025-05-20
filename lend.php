<!-- <div class="card border-dark">
  <div class="card-header bg-dark">Lend Computer</div>
  <div class="card-body">
    <form action="lend_process.php" method="post">
      <input type="text" name="lender_id" placeholder="Lender ID" required><br><br>
      <input type="text" name="borrower_id" placeholder="Borrower ID" required><br><br>
      <button type="submit">Lend</button>
    </form>
  </div>
</div> -->
<div class="tab-pane fade" id="lendLaptop">
  <div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
      <h4 class="mb-4 text-center">Lend a Laptop</h4>
      <form action="lend_laptop.php" method="POST">
        <div class="mb-3">
          <label class="form-label">Registration Number</label>
          <input type="text" name="Registration_Number" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Laptop Serial Number</label>
          <input type="text" name="Laptop_SerialNumber" class="form-control" required>
        </div>
        <div class="text-center">
          <!-- <button type="submit" class="btn btn-success">Lend</button> -->
           <button type="submit" class="btn btn-success form-submit-btn">Register</button>

        </div>
      </form>
    </div>
  </div>
</div>
