<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'trainer') {
    header("Location: ../login.php");
    exit;
}
include '../db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Trainer Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      background: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.75)), 
                  url('https://images.unsplash.com/photo-1583454110551-21f8dedf8bf0?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
    }

    .dashboard-container {
      padding: 40px 20px;
    }

    .card {
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
      transition: transform 0.2s ease-in-out;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card-header {
      font-weight: bold;
      font-size: 1.1rem;
      background-color: rgba(255, 255, 255, 0.1);
      color: #ffc107;
    }

    .card-body {
      background-color: rgba(255, 255, 255, 0.95);
      color: #000;
    }

    .table td, .table th {
      vertical-align: middle;
    }

    .table thead {
      background-color: #343a40;
      color: #fff;
    }

    .btn-logout {
      position: fixed;
      top: 20px;
      right: 30px;
      z-index: 1000;
    }

    h2 {
      color: #ffc107;
    }

    .section-heading {
      margin-bottom: 20px;
      color: #f8f9fa;
      font-weight: 600;
    }
  </style>
</head>
<body>

<a href="../logout.php" class="btn btn-danger btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>

<div class="container dashboard-container">
  <h2 class="mb-4"><i class="fas fa-dumbbell me-2"></i>Welcome, <?php echo $_SESSION['user_name']; ?> (Trainer)</h2>

  <div class="row g-4">
    <!-- Today's Schedule -->
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <i class="fas fa-calendar-day me-2"></i>Today's Schedule
        </div>
        <div class="card-body">
          <?php
          $today = date('Y-m-d');
          $trainer_id = $_SESSION['user_id'];
          $sessions = $conn->prepare("
              SELECT ts.session_date, ts.session_time, m.name AS member_name, ts.notes
              FROM trainer_schedule ts
              JOIN members m ON ts.member_id = m.id
              WHERE ts.trainer_id = ? AND ts.session_date = ?
              ORDER BY ts.session_time ASC
          ");
          $sessions->bind_param("is", $trainer_id, $today);
          $sessions->execute();
          $result = $sessions->get_result();
          ?>

          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>⏰ Time</th>
                  <th>👤 Member</th>
                  <th>📝 Notes</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($result->num_rows > 0): ?>
                  <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                      <td><?= date("h:i A", strtotime($row['session_time'])) ?></td>
                      <td><?= $row['member_name'] ?></td>
                      <td><?= $row['notes'] ?></td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr><td colspan="3">No sessions scheduled for today.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>

    <!-- Assigned Members -->
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <i class="fas fa-users me-2"></i>Assigned Members
        </div>
        <div class="card-body">
          <?php
          $query = $conn->prepare("
              SELECT m.name, m.email, m.phone, m.fitness_goals
              FROM members m
              JOIN member_trainers mt ON m.id = mt.member_id
              WHERE mt.trainer_id = ?
          ");
          $query->bind_param("i", $trainer_id);
          $query->execute();
          $assigned = $query->get_result();

          if ($assigned->num_rows > 0): ?>
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>👤 Name</th>
                    <th>📧 Email</th>
                    <th>📞 Phone</th>
                    <th>🎯 Fitness Goals</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = $assigned->fetch_assoc()): ?>
                    <tr>
                      <td><?= $row['name'] ?></td>
                      <td><?= $row['email'] ?></td>
                      <td><?= $row['phone'] ?></td>
                      <td><?= $row['fitness_goals'] ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <p>No members assigned yet.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
