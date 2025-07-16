<?php
include '../db.php';

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $emergency = $_POST['emergency_contact'];
    $health = $_POST['health_conditions'];
    $goals = $_POST['fitness_goals'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO members (name, email, phone, dob, address, emergency_contact, health_conditions, fitness_goals, password) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $name, $email, $phone, $dob, $address, $emergency, $health, $goals, $password);

    if ($stmt->execute()) {
        $success = "✅ Member added successfully!";
    } else {
        $error = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Member</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right,rgb(2, 12, 48),rgb(2, 0, 15));
      font-family: 'Segoe UI', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px;
    }
    .form-card {
      background: #ffffff;
      border-radius: 15px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
      padding: 30px;
      width: 100%;
      max-width: 900px;
    }
    .form-card h2 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: bold;
      color: #007bff;
    }
    label {
      font-weight: 500;
      margin-top: 10px;
    }
    .form-control {
      border-radius: 10px;
    }
    .btn-success {
      border-radius: 10px;
      font-weight: 600;
    }
    .alert {
      border-radius: 10px;
    }
  </style>
</head>
<body>

<div class="form-card">
  <h2><i class="fas fa-user-plus me-2"></i>Add New Member</h2>

  <?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
  <?php endif; ?>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="row">
      <div class="col-md-6">
        <label><i class="fas fa-user me-1"></i>Name</label>
        <input type="text" name="name" class="form-control" required>

        <label><i class="fas fa-envelope me-1"></i>Email</label>
        <input type="email" name="email" class="form-control" required>

        <label><i class="fas fa-phone me-1"></i>Phone</label>
        <input type="text" name="phone" class="form-control">

        <label><i class="fas fa-calendar-alt me-1"></i>Date of Birth</label>
        <input type="date" name="dob" class="form-control">

        <label><i class="fas fa-map-marker-alt me-1"></i>Address</label>
        <textarea name="address" class="form-control"></textarea>
      </div>

      <div class="col-md-6">
        <label><i class="fas fa-user-shield me-1"></i>Emergency Contact</label>
        <input type="text" name="emergency_contact" class="form-control">

        <label><i class="fas fa-heartbeat me-1"></i>Health Conditions</label>
        <textarea name="health_conditions" class="form-control"></textarea>

        <label><i class="fas fa-bullseye me-1"></i>Fitness Goals</label>
        <textarea name="fitness_goals" class="form-control"></textarea>

        <label><i class="fas fa-lock me-1"></i>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
    </div>

    <button type="submit" class="btn btn-success mt-4 w-100">
      <i class="fas fa-user-plus me-1"></i> Add Member
    </button>
  </form>
</div>

</body>
</html>
