<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM members WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $member = $res->fetch_assoc();
        if (password_verify($password, $member['password'])) {
            $_SESSION['user_id'] = $member['id'];
            $_SESSION['user_name'] = $member['name'];
            $_SESSION['user_role'] = 'member';
            header("Location: member/member_dashboard.php");
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Member not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Member Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
     background: linear-gradient(to right,rgb(2, 12, 48),rgb(2, 0, 15));
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-box {
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }
    .login-box h2 {
      margin-bottom: 25px;
      font-weight: 600;
      text-align: center;
    }
  </style>
</head>
<body>
<div class="login-box">
  <h2>👤 Member Login</h2>
  <?php if (isset($error)) echo "<div class='alert alert-danger text-center'>$error</div>"; ?>
  <form method="POST" novalidate>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">🔐 Login</button>
  </form>
</div>
</body>
</html>
