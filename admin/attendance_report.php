<?php
include '../db.php';
$filter = $_GET['filter'] ?? 'daily';
$dateFilter = $filter === 'weekly' ? "WEEK(date) = WEEK(CURDATE())" : "date = CURDATE()";

$sql = $conn->query("
  SELECT a.*, m.name 
  FROM attendance a 
  JOIN members m ON a.member_id = m.id 
  WHERE $dateFilter 
  ORDER BY a.date DESC
");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Attendance Report</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background: #f0f4f8;
      font-family: 'Segoe UI', sans-serif;
    }
    .report-box {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.05);
      margin-top: 40px;
    }
    h3 {
      color: #003366;
      font-weight: 600;
    }
    .btn-group .btn {
      border-radius: 25px;
      padding: 6px 20px;
    }
    .table th, .table td {
      vertical-align: middle;
    }
    .table th {
      background-color: #003366 !important;
      color: #fff;
    }
    .date-highlight {
      background: #eaf4ff;
      border-radius: 5px;
      padding: 5px 10px;
      font-weight: 500;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="report-box">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3>📋 Attendance Report (<?= ucfirst($filter) ?>)</h3>
      <div class="btn-group">
        <a href="?filter=daily" class="btn btn-outline-primary <?= $filter === 'daily' ? 'active' : '' ?>">Today</a>
        <a href="?filter=weekly" class="btn btn-outline-secondary <?= $filter === 'weekly' ? 'active' : '' ?>">This Week</a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered text-center align-middle">
        <thead>
          <tr>
            <th>👤 Member</th>
            <th>🕒 Check-in</th>
            <th>🕔 Check-out</th>
            <th>📅 Date</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($sql->num_rows > 0): ?>
            <?php while($row = $sql->fetch_assoc()): ?>
              <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['check_in'] ?></td>
                <td><?= $row['check_out'] ?? '<span class="text-muted">-</span>' ?></td>
                <td><span class="date-highlight"><?= $row['date'] ?></span></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="4" class="text-muted">No attendance records found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
