<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

include '../db.php';

// Stats
$membersCount = $conn->query("SELECT COUNT(*) as total FROM members")->fetch_assoc()['total'];
$trainersCount = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='trainer'")->fetch_assoc()['total'];
$todayCheckins = $conn->query("SELECT COUNT(*) as total FROM attendance WHERE date = CURDATE()")->fetch_assoc()['total'];
$monthlyEarnings = $conn->query("SELECT SUM(amount) as total FROM payments WHERE MONTH(payment_date) = MONTH(CURDATE())")->fetch_assoc()['total'];
$todayCount = $todayCheckins;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | FitLife Gym</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <style>
    body {
      background-color: #f4f6f8;
      
    }
    .sidebar {
      height: 100vh;
      background-color: #343a40;
      padding-top: 20px;
      position: fixed;
      width: 240px;
      overflow-y: auto; /* Enables vertical scroll */
     
      box-shadow: 2px 0 4px rgba(0, 0, 0, 0.1);

    }

    .sidebar a {
      color: #ccc;
      text-decoration: none;
      display: block;
      padding: 12px 20px;
    }
    .sidebar a:hover {
      background-color: #495057;
      color: #fff;
    }
    .main-content {
      margin-left: 250px;
      padding: 20px;
    }
    .header {
      background: url('https://images.unsplash.com/photo-1605296867304-46d5465a13f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80') center center/cover no-repeat;
      color: white;
      padding: 180px 50px;
      border-radius: 10px;
      margin-bottom: 30px;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h4 class="text-white text-center">Admin Panel</h4>
  <a href="add_user.php"><i class="bi bi-person-plus"></i> Add User</a>
  <a href="add_member.php"><i class="bi bi-person-plus-fill"></i> Add Member</a>
  <a href="view_members.php"><i class="bi bi-people-fill"></i> View All Members</a>

  <hr class="text-white">

  <a href="add_plan.php"><i class="bi bi-journal-plus"></i> Add Plan</a>
  <a href="assign_plan.php"><i class="bi bi-check2-square"></i> Assign Plan</a>
  <a href="manage_plans.php"><i class="bi bi-folder2-open"></i> Manage Plans</a>

  <hr class="text-white">

  <a href="assign_trainer.php"><i class="bi bi-person-badge"></i> Assign Trainer</a>
  <a href="manage_trainers.php"><i class="bi bi-person-gear"></i> Manage Trainers</a>
  <a href="add_schedule.php"><i class="bi bi-calendar-event"></i> Trainer Schedule</a>

  <hr class="text-white">

  <a href="add_payment.php"><i class="bi bi-cash-stack"></i> Add Payment</a>
  <a href="payment_history.php"><i class="bi bi-clock-history"></i> View Payments</a>

  <hr class="text-white">

  <a href="../qr/scan_qr.php"><i class="bi bi-qr-code-scan"></i> Attendance Scan</a>
  <a href="attendance_report.php"><i class="bi bi-card-checklist"></i> Attendance Report <span class="badge bg-success"><?= $todayCount ?></span></a>
  <a href="../qr/generate_qr.php"><i class="bi bi-qr-code"></i> Generate QR Codes</a>

  <hr class="text-white">

  <a href="../logout.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
  <div class="header">
    <h1 class="display-4">Admin Dashboard</h1>
    <p class="lead">Manage your gym operations efficiently.</p>
    <h2>Welcome, <?= $_SESSION['user_name'] ?> (Admin)</h2>

  </div>

  <!-- Dashboard Stats -->
  <div class="row">
    <div class="col-md-3">
      <div class="card text-white bg-primary mb-3">
        <div class="card-body text-center">
          <h5 class="card-title">Total Members</h5>
          <p class="fs-4"><?= $membersCount ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card text-white bg-success mb-3">
        <div class="card-body text-center">
          <h5 class="card-title">Total Trainers</h5>
          <p class="fs-4"><?= $trainersCount ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card text-dark bg-warning mb-3">
        <div class="card-body text-center">
          <h5 class="card-title">Check-ins Today</h5>
          <p class="fs-4"><?= $todayCheckins ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card text-white bg-dark mb-3">
        <div class="card-body text-center">
          <h5 class="card-title">Monthly Earnings</h5>
          <p class="fs-4">₹<?= $monthlyEarnings ?? 0 ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
