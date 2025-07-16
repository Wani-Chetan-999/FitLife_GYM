<?php
include '../db.php';

$payment_id = $_GET['id'];
$sql = $conn->prepare("SELECT p.*, m.name, m.email FROM payments p JOIN members m ON p.member_id = m.id WHERE p.id = ?");
$sql->bind_param("i", $payment_id);
$sql->execute();
$data = $sql->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Invoice #<?= $payment_id ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    @media print {
      .no-print {
        display: none;
      }
    }
    .invoice-box {
      max-width: 700px;
      margin: auto;
      padding: 30px;
      border: 1px solid #eee;
      box-shadow: 0 0 10px rgba(0, 0, 0, .15);
      font-size: 16px;
    }
  </style>
</head>
<body>
<div class="invoice-box">
  <h2>Gym Invoice</h2>
  <p><strong>Member:</strong> <?= $data['name'] ?><br>
     <strong>Email:</strong> <?= $data['email'] ?><br>
     <strong>Plan:</strong> <?= $data['plan'] ?><br>
     <strong>Amount:</strong> ₹<?= $data['amount'] ?><br>
     <strong>Payment Date:</strong> <?= $data['payment_date'] ?><br>
     <strong>Next Due:</strong> <?= $data['next_due_date'] ?><br>
     <strong>Payment Mode:</strong> <?= $data['payment_mode'] ?><br>
     <strong>Notes:</strong> <?= $data['notes'] ?></p>

  <hr>
  <p style='font-size:12px;'>Thank you for your payment!</p>
  <button class="btn btn-primary no-print mt-3" onclick="window.print()">🖨️ Print</button>
  <a href="payment_history.php" class="btn btn-secondary no-print mt-3">Back</a>
</div>
</body>
</html>
