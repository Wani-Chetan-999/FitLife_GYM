<?php
session_start();
include '../db.php';
if ($_SESSION['user_role'] !== 'admin') {
    die("Access denied");
}

$members = $conn->query("SELECT id, name FROM members");
$plans = $conn->query("SELECT id, plan_name, duration FROM membership_plans");

$message = '';

if (isset($_POST['assign'])) {
    $member_id = $_POST['member_id'];
    $plan_id = $_POST['plan_id'];
    $start = $_POST['start_date'];

    // Fetch duration from plan
    $duration_q = $conn->prepare("SELECT duration FROM membership_plans WHERE id = ?");
    $duration_q->bind_param("i", $plan_id);
    $duration_q->execute();
    $res = $duration_q->get_result()->fetch_assoc();
    $duration = $res['duration'];

    $expiry = date('Y-m-d', strtotime($start . " +$duration days"));

    $assign = $conn->prepare("INSERT INTO member_plans (member_id, plan_id, start_date, expiry_date) VALUES (?, ?, ?, ?)");
    $assign->bind_param("iiss", $member_id, $plan_id, $start, $expiry);

    if ($assign->execute()) {
        $message = "<div class='alert alert-success'>✅ Plan assigned successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>❌ Error assigning plan.</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Assign Plan</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background: linear-gradient(to right, #f0f2f5, #d9f1ff);
      font-family: 'Segoe UI', sans-serif;
      padding: 50px 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .assign-card {
      background: #fff;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 600px;
    }

    .form-select, .form-control {
      border-radius: 10px;
    }

    .btn-success {
      background-color: #28a745;
      border: none;
      border-radius: 10px;
      font-weight: 500;
    }

    h3 {
      color: #007bff;
      text-align: center;
      margin-bottom: 25px;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <div class="assign-card">
    <h3>📋 Assign Plan to Member</h3>
    <?= $message ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Select Member</label>
        <select name="member_id" class="form-select" required>
          <option value="">-- Choose Member --</option>
          <?php $members->data_seek(0); while($m = $members->fetch_assoc()): ?>
            <option value="<?= $m['id'] ?>"><?= $m['name'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Select Plan</label>
        <select name="plan_id" class="form-select" required>
          <option value="">-- Choose Plan --</option>
          <?php $plans->data_seek(0); while($p = $plans->fetch_assoc()): ?>
            <option value="<?= $p['id'] ?>"><?= $p['plan_name'] ?> (<?= $p['duration'] ?> days)</option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Start Date</label>
        <input type="date" name="start_date" class="form-control" required>
      </div>

      <button type="submit" name="assign" class="btn btn-success w-100">Assign Plan</button>
    </form>
  </div>

</body>
</html>
