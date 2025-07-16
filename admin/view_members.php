<?php
session_start();
include '../db.php';

if ($_SESSION['user_role'] !== 'admin') {
    die("Access denied");
}

// Get all members with their plans
$query = "
SELECT m.id, m.name, m.email, m.phone, m.fitness_goals,
       p.plan_name, mp.start_date, mp.expiry_date
FROM members m
LEFT JOIN member_plans mp ON m.id = mp.member_id
LEFT JOIN membership_plans p ON mp.plan_id = p.id
ORDER BY m.name ASC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Members & Plans</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right,rgb(2, 12, 48),rgb(2, 0, 15));
      font-family: 'Segoe UI', sans-serif;
      min-height: 100vh;
      padding: 30px;
    }

    .members-container {
      background-color: #ffffff;
      border-radius: 15px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      padding: 30px;
      max-width: 1100px;
      margin: auto;
    }

    h3 {
      text-align: center;
      font-weight: bold;
      color: #007bff;
      margin-bottom: 25px;
    }

    table th, table td {
      vertical-align: middle;
    }

    .badge-not-assigned {
      background-color: #f0ad4e;
    }

    .badge-plan {
      background-color: #5bc0de;
    }

    .table thead th {
      background-color: #343a40;
      color: white;
    }
  </style>
</head>
<body>

<div class="members-container">
  <h3><i class="fas fa-users me-2"></i>All Gym Members & Their Plans</h3>

  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th><i class="fas fa-user"></i> Name</th>
          <th><i class="fas fa-envelope"></i> Email</th>
          <th><i class="fas fa-phone"></i> Phone</th>
          <th><i class="fas fa-dumbbell"></i> Plan</th>
          <th><i class="fas fa-calendar-day"></i> Start</th>
          <th><i class="fas fa-calendar-check"></i> Expiry</th>
          <th><i class="fas fa-bullseye"></i> Goals</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td>
              <?php if ($row['plan_name']): ?>
                <span class="badge badge-plan text-white p-2"><?= htmlspecialchars($row['plan_name']) ?></span>
              <?php else: ?>
                <span class="badge badge-not-assigned text-dark p-2">Not assigned</span>
              <?php endif; ?>
            </td>
            <td><?= $row['start_date'] ? date('d M Y', strtotime($row['start_date'])) : '-' ?></td>
            <td><?= $row['expiry_date'] ? date('d M Y', strtotime($row['expiry_date'])) : '-' ?></td>
            <td><?= htmlspecialchars($row['fitness_goals']) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
