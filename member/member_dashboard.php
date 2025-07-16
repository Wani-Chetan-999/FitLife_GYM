<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'member') {
    header("Location: ../member_login.php");
    exit;
}

include '../db.php';

$userId = $_SESSION['user_id'];

// Fetch upcoming sessions
$sessions = $conn->query("
    SELECT ts.session_date, ts.session_time, ts.notes, u.name AS trainer_name
    FROM trainer_schedule ts
    JOIN users u ON ts.trainer_id = u.id
    WHERE ts.member_id = $userId
    ORDER BY ts.session_date ASC, ts.session_time ASC
");

// Fetch profile
$profile = $conn->query("SELECT * FROM members WHERE id = $userId")->fetch_assoc();

// Fetch plan
$planSql = "SELECT mp.*, p.plan_name 
            FROM member_plans mp 
            JOIN membership_plans p ON mp.plan_id = p.id 
            WHERE mp.member_id = $userId 
            ORDER BY mp.start_date DESC LIMIT 1";
$plan = $conn->query($planSql)->fetch_assoc();

// Fetch payment history
$payments = $conn->query("SELECT * FROM payments WHERE member_id = $userId ORDER BY payment_date DESC");

// Plan expiry
$today = date('Y-m-d');
$expiry_date = $plan['expiry_date'] ?? null;
$remaining_days = $expiry_date ? (strtotime($expiry_date) - strtotime($today)) / (60 * 60 * 24) : null;

$availablePlans = $conn->query("SELECT * FROM membership_plans ORDER BY duration");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Member Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #e3f2fd, #ffffff);
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border-radius: 15px;
      transition: transform 0.3s ease-in-out;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card-header {
      font-weight: bold;
      font-size: 1.1rem;
    }
    .badge-status {
      font-size: 0.9rem;
      padding: 0.4em 0.8em;
    }
    .table th, .table td {
      vertical-align: middle;
    }
    .chart-container {
      background: #fff;
      padding: 1rem;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    .btn-primary, .btn-outline-danger {
      border-radius: 20px;
    }
    h2, h4 {
      font-weight: 700;
    }
  </style>
</head>
<body>
<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary">Welcome, <?php echo $_SESSION['user_name']; ?> 👋</h2>
    <a href="../logout.php" class="btn btn-outline-danger"><i class="fas fa-sign-out-alt me-1"></i>Logout</a>
  </div>

  <?php if ($plan && $remaining_days <= 5 && $remaining_days >= 0): ?>
    <div class="alert alert-warning d-flex align-items-center" role="alert">
      <i class="fas fa-exclamation-triangle me-2"></i>
      <div>
        <strong>Heads up!</strong> Your membership is expiring in <strong><?php echo ceil($remaining_days); ?> days</strong>.
        Please renew to continue enjoying gym services.
      </div>
    </div>
  <?php endif; ?>

  <div class="row g-4">
    <!-- Profile -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white"><i class="fas fa-user me-2"></i>Profile</div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Name:</strong> <?php echo $profile['name']; ?></li>
            <li class="list-group-item"><strong>Email:</strong> <?php echo $profile['email']; ?></li>
            <li class="list-group-item"><strong>Phone:</strong> <?php echo $profile['phone'] ?? 'N/A'; ?></li>
            <li class="list-group-item"><strong>DOB:</strong> <?php echo $profile['dob']; ?></li>
            <li class="list-group-item"><strong>Address:</strong> <?php echo $profile['address']; ?></li>
            <li class="list-group-item"><strong>Emergency Contact:</strong> <?php echo $profile['emergency_contact']; ?></li>
            <li class="list-group-item"><strong>Health Conditions:</strong> <?php echo $profile['health_conditions']; ?></li>
            <li class="list-group-item"><strong>Fitness Goals:</strong> <?php echo $profile['fitness_goals']; ?></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Membership Plan -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header bg-success text-white"><i class="fas fa-dumbbell me-2"></i>Current Membership</div>
        <div class="card-body">
          <?php if ($plan): ?>
            <p><strong>Plan:</strong> <?php echo $plan['plan_name']; ?></p>
            <p><strong>Start Date:</strong> <?php echo $plan['start_date']; ?></p>
            <p><strong>End Date:</strong> <?php echo $plan['expiry_date']; ?></p>
            <p><strong>Status:</strong>
              <?php
              echo ($plan['expiry_date'] < $today)
                ? "<span class='badge bg-danger badge-status'>Expired</span>"
                : "<span class='badge bg-success badge-status'>Active</span>";
              ?>
            </p>
          <?php else: ?>
            <p class="text-danger">No active membership plan assigned.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Sessions -->
  <h4 class="mt-5"><i class="fas fa-calendar-alt me-2"></i>Upcoming Sessions</h4>
  <?php if ($sessions->num_rows > 0): ?>
    <div class="table-responsive shadow-sm rounded">
      <table class="table table-striped table-bordered">
        <thead class="table-light">
          <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Trainer</th>
            <th>Notes</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $sessions->fetch_assoc()): ?>
            <tr>
              <td><?php echo date("d M Y", strtotime($row['session_date'])); ?></td>
              <td><?php echo date("h:i A", strtotime($row['session_time'])); ?></td>
              <td><?php echo $row['trainer_name']; ?></td>
              <td><?php echo $row['notes']; ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-muted">No upcoming sessions found.</p>
  <?php endif; ?>

  <!-- Available Plans -->
  <h4 class="mt-5"><i class="fas fa-list-alt me-2"></i>Available Plans</h4>
  <div class="row">
    <?php while ($plan = $availablePlans->fetch_assoc()): ?>
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title text-primary"><i class="fas fa-cube me-1"></i><?php echo $plan['plan_name']; ?></h5>
            <p><strong>Duration:</strong> <?php echo $plan['duration']; ?> days</p>
            <p><strong>Price:</strong> ₹<?php echo $plan['price']; ?></p>
            <p><?php echo $plan['description']; ?></p>
            <form method="get" action="apply_plan.php">
              <input type="hidden" name="plan_id" value="<?php echo $plan['id']; ?>">
              <button type="submit" class="btn btn-sm btn-primary rounded-pill">Apply Now</button>
            </form>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <!-- Payment History -->
  <div class="mt-5">
    <div class="card shadow-sm">
      <div class="card-header bg-warning text-dark"><i class="fas fa-receipt me-2"></i>Payment History</div>
      <div class="card-body">
        <?php if ($payments->num_rows > 0): ?>
          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
              <thead class="table-dark">
                <tr>
                  <th>Amount</th>
                  <th>Date</th>
                  <th>Mode</th>
                  <th>Notes</th>
                </tr>
              </thead>
              <tbody>
                <?php while($pay = $payments->fetch_assoc()): ?>
                  <tr>
                    <td>₹<?php echo $pay['amount']; ?></td>
                    <td><?php echo $pay['payment_date']; ?></td>
                    <td><?php echo $pay['payment_mode']; ?></td>
                    <td><?php echo $pay['notes']; ?></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <p class="text-danger">No payments found.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Charts Section -->
  <h4 class="mt-5"><i class="fas fa-chart-line me-2"></i>Your Fitness Progress</h4>
  <div class="row">
    <div class="col-md-6">
      <div class="chart-container mb-4">
        <canvas id="weightChart"></canvas>
      </div>
    </div>
    <div class="col-md-6">
      <div class="chart-container mb-4">
        <canvas id="bmiChart"></canvas>
      </div>
    </div>
    <div class="col-md-6">
      <div class="chart-container mb-4">
        <canvas id="attendanceChart"></canvas>
      </div>
    </div>
    <div class="col-md-6">
      <div class="chart-container mb-4">
        <canvas id="calorieChart"></canvas>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const dates = ["Jul 01", "Jul 05", "Jul 10", "Jul 15", "Jul 20"];

  new Chart(document.getElementById("weightChart"), {
    type: 'line',
    data: {
      labels: dates,
      datasets: [{
        label: "Weight (kg)",
        data: [78, 77.2, 76.5, 75.8, 75],
        borderColor: "#4e73df",
        backgroundColor: "rgba(78, 115, 223, 0.1)",
        fill: true
      }]
    },
    options: { responsive: true, plugins: { title: { display: true, text: 'Weight Reduction Over Time' } } }
  });

  new Chart(document.getElementById("bmiChart"), {
    type: 'bar',
    data: {
      labels: dates,
      datasets: [{
        label: "BMI",
        data: [24.9, 24.5, 24.2, 23.8, 23.5],
        backgroundColor: "#1cc88a"
      }]
    },
    options: { responsive: true, plugins: { title: { display: true, text: 'BMI Progress Chart' } } }
  });

  new Chart(document.getElementById("attendanceChart"), {
    type: 'bar',
    data: {
      labels: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      datasets: [{
        label: "Days Attended",
        data: [1, 4, 3, 4, 2, 3, 0],
        backgroundColor: "#36b9cc"
      }]
    },
    options: { responsive: true, plugins: { title: { display: true, text: 'Weekly Attendance Summary' } } }
  });

  new Chart(document.getElementById("calorieChart"), {
    type: 'line',
    data: {
      labels: dates,
      datasets: [{
        label: "Calories Burned",
        data: [300, 420, 390, 450, 500],
        borderColor: "#f6c23e",
        backgroundColor: "rgba(246, 194, 62, 0.1)",
        fill: true
      }]
    },
    options: { responsive: true, plugins: { title: { display: true, text: 'Calories Burned Trend' } } }
  });
</script>
</body>
</html>
