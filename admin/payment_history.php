<?php
session_start();
include '../db.php';
if ($_SESSION['user_role'] !== 'admin') {
    die("Access denied");
}

$query = $conn->query("
  SELECT p.*, m.name 
  FROM payments p 
  JOIN members m ON p.member_id = m.id 
  ORDER BY p.payment_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Payment History</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background: linear-gradient(to right,rgb(60, 76, 137),rgb(2, 0, 15));
      font-family: 'Segoe UI', sans-serif;
    }
    .table-container {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
      margin-top: 50px;
    }
    .table th {
      position: sticky;
      top: 0;
      background-color: #212529 !important;
      color: white;
      z-index: 1;
    }
    .btn-sm {
      margin-bottom: 4px;
    }
    h3 {
      color: #007bff;
      font-weight: 600;
    }
  </style>
</head>
<body>
<div class="container table-container">
  <h3 class="mb-4">💵 Payment History</h3>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="table-dark text-center">
        <tr>
          <th>Member</th>
          <th>Plan</th>
          <th>Amount</th>
          <th>Date</th>
          <th>Next Due</th>
          <th>Mode</th>
          <th>Notes</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $query->fetch_assoc()): ?>
          <tr>
            <td class="text-center"><?= htmlspecialchars($row['name']) ?></td>
            <td class="text-center"><?= htmlspecialchars($row['plan']) ?></td>
            <td class="text-center text-success">₹<?= number_format($row['amount'], 2) ?></td>
            <td class="text-center"><?= date("d M Y", strtotime($row['payment_date'])) ?></td>
            <td class="text-center"><?= date("d M Y", strtotime($row['next_due_date'])) ?></td>
            <td class="text-center"><?= $row['payment_mode'] ?></td>
            <td><?= htmlspecialchars($row['notes']) ?: '-' ?></td>
            <td class="text-center">
              <a href="generate_invoice.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">📤 Invoice</a>
              <a href="print_invoice.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-secondary">🖨️ Print</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
