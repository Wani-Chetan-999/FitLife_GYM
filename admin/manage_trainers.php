<?php
session_start();
include '../db.php';
if ($_SESSION['user_role'] !== 'admin') {
    die("Access denied");
}

// Get all trainers
$trainers = $conn->query("SELECT id, name, email, phone, specialization FROM users WHERE role = 'trainer'");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Trainers</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background: linear-gradient(to right,rgb(210, 222, 234),rgb(245, 240, 240));
      font-family: 'Segoe UI', sans-serif;
      padding: 40px 20px;
    }

    .container {
      background-color: #fff;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    h3 {
      color: #007bff;
      font-weight: 600;
      margin-bottom: 25px;
    }

    table {
      border-radius: 12px;
      overflow: hidden;
    }

    th, td {
      vertical-align: middle !important;
    }

    .table-hover tbody tr:hover {
      background-color: #f8f9fa;
    }

    .btn-warning {
      border-radius: 8px;
    }
  </style>
</head>
<body>
<div class="container">
  <h3>Trainer Profiles</h3>
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Specialization</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $trainers->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= $row['specialization'] ?? '<span class="text-muted">N/A</span>' ?></td>
          <td>
            <a href="edit_trainer.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
