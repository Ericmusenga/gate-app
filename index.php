<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>UR CE RUKARA - Student Info</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #eaeaea;
    }
    .card {
      width: 500px;
      border: 2px solid #000;
      padding: 20px;
      margin: 50px auto;
      background-color: #f9f9f9;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      border-radius: 10px;
    }
    .header {
      text-align: center;
      font-weight: bold;
      font-size: 22px;
      margin-bottom: 20px;
      color: #2c3e50;
    }
    .info {
      display: flex;
      justify-content: space-between;
    }
    .details {
      width: 65%;
    }
    .details p {
      margin: 8px 0;
      font-size: 14px;
      line-height: 1.4;
    }
    .details strong {
      color: #333;
    }
    .photo {
      width: 30%;
      height: 120px;
      border: 1px solid #000;
      background-color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 14px;
      text-align: center;
    }
    .photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 2px;
    }
  </style>
</head>
<body>

<div class="card">
  <div class="header">UR CE - RUKARA<br>STUDENT INFO</div>
  <div class="info">
    <div class="details" id="student-details">
      <p><strong>Names:</strong> <span id="names">___________________________</span></p>
      <p><strong>Reg No:</strong> <span id="regno">___________________________</span></p>
      <p><strong>Year of Study:</strong> <span id="year">_____________________</span></p>
      <p><strong>Department:</strong> <span id="dept">______________________</span></p>
      <p><strong>Program:</strong> <span id="program">_______________________</span></p>
      <p><strong>Study Mode:</strong> <span id="mode">______________________</span></p>
      <p><strong>Serial Number:</strong> <span id="serial">____________________</span></p>
    </div>
    <div class="photo" id="photo-box">
      <!-- Optional photo will appear here -->
      Photo
    </div>
  </div>
</div>

<script>
  // Sample student data
  const studentInfo = {
    names: "Eric Uwizeyimana",
    regNo: "2222223456",
    year: "3",
    department: "Computer and Software Engineering",
    program: "BTech in Embedded Systems",
    mode: "Full-Time",
    serial: "UR-ES-2025-001",
    photoUrl: "https://via.placeholder.com/100x120.png?text=Student+Photo" // Replace with actual photo
  };

  // Fill the HTML with the student data
  document.getElementById("names").textContent = studentInfo.names;
  document.getElementById("regno").textContent = studentInfo.regNo;
  document.getElementById("year").textContent = studentInfo.year;
  document.getElementById("dept").textContent = studentInfo.department;
  document.getElementById("program").textContent = studentInfo.program;
  document.getElementById("mode").textContent = studentInfo.mode;
  document.getElementById("serial").textContent = studentInfo.serial;

  // Load photo if available
  if (studentInfo.file) {
    const photoBox = document.getElementById("photo-box");
    photoBox.innerHTML = `<img src="${studentInfo.file}" alt="Student Photo">`;
  }
</script>

</body>
</html>
