<?php
session_start();
include '../db.php';
if ($_SESSION['user_role'] !== 'admin') {
    die("Access denied");
}

$id = $_GET['id'];
$plan = $conn->query("SELECT * FROM membership_plans WHERE id = $id")->fetch_assoc();

if (isset($_POST['update_plan'])) {
    $name = $_POST['plan_name'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];
    $desc = $_POST['description'];

    $stmt = $conn->prepare("UPDATE membership_plans SET plan_name=?, duration=?, price=?, description=? WHERE id=?");
    $stmt->bind_param("sidsi", $name, $duration, $price, $desc, $id);

    if ($stmt->execute()) {
        header("Location: manage_plans.php");
        exit();
    } else {
        echo "Failed to update.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Plan</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h3>Edit Plan: <?= $plan['plan_name'] ?></h3>
  <form method="POST" class="mt-3" style="max-width: 600px;">
    <input type="text" name="plan_name" value="<?= $plan['plan_name'] ?>" class="form-control mb-2" required>
    <input type="number" name="duration" value="<?= $plan['duration'] ?>" class="form-control mb-2" required>
    <input type="number" step="0.01" name="price" value="<?= $plan['price'] ?>" class="form-control mb-2" required>
    <textarea name="description" class="form-control mb-2"><?= $plan['description'] ?></textarea>

    <button type="submit" name="update_plan" class="btn btn-success w-100">Update Plan</button>
  </form>
</div>
</body>
</html>
