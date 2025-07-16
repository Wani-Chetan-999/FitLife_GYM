<?php
session_start();
include '../db.php';

if ($_SESSION['user_role'] !== 'admin') {
    die("Access denied");
}

$id = $_GET['id'];
$trainer = $conn->query("SELECT * FROM users WHERE id = $id AND role = 'trainer'")->fetch_assoc();

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $spec = $_POST['specialization'];

    $stmt = $conn->prepare("UPDATE users SET name=?, phone=?, specialization=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $phone, $spec, $id);
    $stmt->execute();

    header("Location: manage_trainers.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Trainer</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
  <h3>Edit Trainer: <?= $trainer['name'] ?></h3>
  <form method="POST" class="mt-3" style="max-width: 600px;">
    <label>Name:</label>
    <input type="text" name="name" value="<?= $trainer['name'] ?>" class="form-control mb-2" required>

    <label>Phone:</label>
    <input type="text" name="phone" value="<?= $trainer['phone'] ?>" class="form-control mb-2" required>

    <label>Specialization:</label>
    <input type="text" name="specialization" value="<?= $trainer['specialization'] ?>" class="form-control mb-2">

    <button type="submit" name="update" class="btn btn-success w-100">Update Trainer</button>
  </form>
</div>
</body>
</html>
