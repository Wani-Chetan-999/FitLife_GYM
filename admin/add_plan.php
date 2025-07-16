<?php
session_start();
include '../db.php';

if ($_SESSION['user_role'] !== 'admin') {
    die("Access denied");
}

$feedback = '';

if (isset($_POST['add_plan'])) {
    $name = $_POST['plan_name'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];
    $desc = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO membership_plans (plan_name, duration, price, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sids", $name, $duration, $price, $desc);

    if ($stmt->execute()) {
        $feedback = "<div class='alert alert-success'>✅ Plan added successfully!</div>";
    } else {
        $feedback = "<div class='alert alert-danger'>❌ Error adding plan. Try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Membership Plan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #f0f2f5, #d9f1ff);
      font-family: 'Segoe UI', sans-serif;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px;
    }

    .plan-form-card {
      background-color: #fff;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 600px;
    }

    h3 {
      text-align: center;
      margin-bottom: 25px;
      color: #007bff;
      font-weight: bold;
    }

    .btn-primary {
      background-color: #007bff;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    .form-control {
      border-radius: 8px;
    }

    textarea.form-control {
      resize: vertical;
    }
  </style>
</head>
<body>

  <div class="plan-form-card">
    <h3><i class="fas fa-plus-circle me-2"></i>Create New Membership Plan</h3>
    <?= $feedback ?>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Plan Name</label>
        <input type="text" name="plan_name" class="form-control" placeholder="e.g. Monthly, Quarterly" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Duration (in days)</label>
        <input type="number" name="duration" class="form-control" placeholder="e.g. 30" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Price (₹)</label>
        <input type="number" step="0.01" name="price" class="form-control" placeholder="e.g. 999.99" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Description (optional)</label>
        <textarea name="description" class="form-control" placeholder="Brief about this plan..."></textarea>
      </div>
      <button type="submit" name="add_plan" class="btn btn-primary w-100">Add Plan</button>
    </form>
  </div>

  <script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script> <!-- optional -->
</body>
</html>
