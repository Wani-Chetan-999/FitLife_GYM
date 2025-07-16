<?php
session_start();
include '../db.php';
if ($_SESSION['user_role'] !== 'admin') {
    die("Access denied");
}

$members = $conn->query("SELECT id, name FROM members");

if (isset($_POST['submit'])) {
    $member_id = $_POST['member_id'];
    $plan = $_POST['plan'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $next_due = $_POST['next_due_date'];
    $mode = $_POST['payment_mode'];
    $notes = $_POST['notes'];

    $stmt = $conn->prepare("INSERT INTO payments (member_id, plan, amount, payment_date, next_due_date, payment_mode, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isdssss", $member_id, $plan, $amount, $payment_date, $next_due, $mode, $notes);
    $stmt->execute();
    $msg = "✅ Payment recorded successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Record Payment</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background: linear-gradient(to right,rgb(60, 76, 137),rgb(2, 0, 15));
      font-family: 'Segoe UI', sans-serif;
    }
    .form-container {
      background-color: #fff;
      padding: 30px;
      margin: 40px auto;
      max-width: 600px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    h3 {
      color: #007bff;
      font-weight: 600;
      text-align: center;
      margin-bottom: 25px;
    }
    label {
      font-weight: 500;
    }
    .btn-primary {
      font-weight: 600;
      border-radius: 8px;
    }
    .form-control, .form-select {
      border-radius: 8px;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h3>💰 Record Payment</h3>
    <?php if (isset($msg)) echo "<div class='alert alert-success text-center'>$msg</div>"; ?>
    
    <form method="POST">
      <div class="mb-3">
        <label for="member_id">Member:</label>
        <select name="member_id" class="form-select" required>
          <option value="" disabled selected>Select Member</option>
          <?php while($m = $members->fetch_assoc()): ?>
            <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="plan">Plan:</label>
        <input type="text" name="plan" class="form-control" placeholder="e.g. Monthly Plan" required>
      </div>

      <div class="mb-3">
        <label for="amount">Amount (₹):</label>
        <input type="number" step="0.01" name="amount" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="payment_date">Payment Date:</label>
        <input type="date" name="payment_date" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="next_due_date">Next Due Date:</label>
        <input type="date" name="next_due_date" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="payment_mode">Payment Mode:</label>
        <select name="payment_mode" class="form-select" required>
          <option value="Cash">Cash</option>
          <option value="UPI">UPI</option>
          <option value="Card">Card</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="notes">Notes:</label>
        <input type="text" name="notes" class="form-control" placeholder="Optional remarks...">
      </div>

      <button type="submit" name="submit" class="btn btn-primary w-100">Record Payment</button>
    </form>
  </div>
</body>
</html>
