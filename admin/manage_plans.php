<?php
session_start();
include '../db.php';
if ($_SESSION['user_role'] !== 'admin') {
    die("Access denied");
}

// Delete plan
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM membership_plans WHERE id = $id");
    header("Location: manage_plans.php");
    exit();
}

// Fetch all plans
$plans = $conn->query("SELECT * FROM membership_plans");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Membership Plans</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background: linear-gradient(to right, #f0f2f5, #d9f1ff);
      font-family: 'Segoe UI', sans-serif;
      padding: 40px 20px;
    }

    .card {
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      padding: 25px;
      background: white;
    }

    h3 {
      color: #007bff;
      font-weight: 600;
    }

    .btn-primary {
      background-color: #007bff;
      border: none;
      border-radius: 10px;
    }

    .btn-warning, .btn-danger {
      border-radius: 8px;
      padding: 4px 10px;
    }

    .table th {
      background-color: #0d6efd;
      color: white;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>📋 Membership Plans</h3>
        <a href="add_plan.php" class="btn btn-primary">+ Add New Plan</a>
      </div>

      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Plan Name</th>
            <th>Duration (days)</th>
            <th>Price (₹)</th>
            <th>Description</th>
            <th style="width: 150px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($plans->num_rows > 0): ?>
            <?php while($row = $plans->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['plan_name']) ?></td>
                <td><?= $row['duration'] ?></td>
                <td><?= number_format($row['price'], 2) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td>
                  <a href="edit_plan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this plan?')">Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="5" class="text-center text-muted">No plans found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
