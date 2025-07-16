<?php
session_start();
include '../db.php';
if ($_SESSION['user_role'] !== 'admin') {
    die("Access denied");
}

$members = $conn->query("SELECT id, name FROM members");
$trainers = $conn->query("SELECT id, name FROM users WHERE role = 'trainer'");

if (isset($_POST['assign'])) {
    $member_id = $_POST['member_id'];
    $trainer_id = $_POST['trainer_id'];

    // Check if already assigned
    $check = $conn->prepare("SELECT * FROM member_trainers WHERE member_id = ?");
    $check->bind_param("i", $member_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // update
        $update = $conn->prepare("UPDATE member_trainers SET trainer_id=? WHERE member_id=?");
        $update->bind_param("ii", $trainer_id, $member_id);
        $update->execute();
        $msg = "Trainer updated for member!";
    } else {
        // insert
        $insert = $conn->prepare("INSERT INTO member_trainers (member_id, trainer_id) VALUES (?, ?)");
        $insert->bind_param("ii", $member_id, $trainer_id);
        $insert->execute();
        $msg = "Trainer assigned successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Assign Trainer</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background: linear-gradient(to right,rgb(210, 222, 234),rgb(245, 240, 240));
      font-family: 'Segoe UI', sans-serif;
      padding: 40px 20px;
    }

    .card {
      border-radius: 16px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
      padding: 25px;
      background: #ffffff;
    }

    h3 {
      font-weight: 600;
      color: #0d6efd;
    }

    label {
      font-weight: 500;
    }

    .btn-success {
      background-color: #28a745;
      border-radius: 8px;
    }

    .alert {
      border-radius: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card mx-auto" style="max-width: 600px;">
      <h3 class="mb-3">Assign Trainer to Member</h3>
      <?php if (isset($msg)) echo "<div class='alert alert-info'>$msg</div>"; ?>
      <form method="POST">
        <div class="mb-3">
          <label for="member">Member:</label>
          <select name="member_id" id="member" class="form-select" required>
            <option value="" disabled selected>Select Member</option>
            <?php $members->data_seek(0); while($m = $members->fetch_assoc()): ?>
              <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="trainer">Trainer:</label>
          <select name="trainer_id" id="trainer" class="form-select" required>
            <option value="" disabled selected>Select Trainer</option>
            <?php $trainers->data_seek(0); while($t = $trainers->fetch_assoc()): ?>
              <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['name']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <button type="submit" name="assign" class="btn btn-success w-100">Assign Trainer</button>
      </form>
    </div>
  </div>
</body>
</html>
