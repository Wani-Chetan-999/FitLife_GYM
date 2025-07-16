<?php
session_start();
include '../db.php';
if ($_SESSION['user_role'] !== 'admin') {
    die("Access denied");
}

// Fetch trainers & members
$trainers = $conn->query("SELECT id, name FROM users WHERE role = 'trainer'");
$members = $conn->query("SELECT id, name FROM members");

if (isset($_POST['submit'])) {
    $trainer_id = $_POST['trainer_id'];
    $member_id = $_POST['member_id'];
    $date = $_POST['session_date'];
    $time = $_POST['session_time'];
    $notes = $_POST['notes'];

    $stmt = $conn->prepare("INSERT INTO trainer_schedule (trainer_id, member_id, session_date, session_time, notes) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $trainer_id, $member_id, $date, $time, $notes);
    $stmt->execute();
    $msg = "Schedule added!";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Trainer Schedule</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background: linear-gradient(to right,rgb(210, 222, 234),rgb(245, 240, 240));
      font-family: 'Segoe UI', sans-serif;
    }
    .form-box {
      background-color: #ffffff;
      border-radius: 15px;
      padding: 30px;
      max-width: 600px;
      margin: 40px auto;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    h3 {
      color: #007bff;
      text-align: center;
      font-weight: 600;
      margin-bottom: 25px;
    }
    label {
      font-weight: 500;
      margin-bottom: 5px;
    }
    .form-control, .form-select {
      border-radius: 8px;
    }
    .btn-primary {
      border-radius: 8px;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="form-box">
    <h3>Assign Schedule to Trainer</h3>
    <?php if (isset($msg)) echo "<div class='alert alert-success text-center'>$msg</div>"; ?>
    <form method="POST">
      <div class="mb-3">
        <label>Trainer</label>
        <select name="trainer_id" class="form-select" required>
          <?php while($t = $trainers->fetch_assoc()): ?>
            <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['name']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="mb-3">
        <label>Member</label>
        <select name="member_id" class="form-select" required>
          <?php while($m = $members->fetch_assoc()): ?>
            <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="mb-3">
        <label>Date</label>
        <input type="date" name="session_date" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Time</label>
        <input type="time" name="session_time" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Notes</label>
        <input type="text" name="notes" class="form-control" placeholder="Optional notes...">
      </div>

      <button type="submit" name="submit" class="btn btn-primary w-100">Add Schedule</button>
    </form>
  </div>
</body>
</html>
