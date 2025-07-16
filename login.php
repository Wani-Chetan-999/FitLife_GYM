<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Gym Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right,rgb(2, 12, 48),rgb(2, 0, 15));
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    
    .login-card {
      background: #fff;
      padding: 30px 40px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 450px;
    }
    .login-card h2 {
      font-weight: 700;
      color: #333;
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #ff6f61;
    }
    .btn-primary {
      background-color: #ff6f61;
      border: none;
      font-weight: bold;
    }
    .btn-primary:hover {
      background-color: #e55a4f;
    }
    .form-label i {
      margin-right: 6px;
    }
    .forgot-link {
      display: block;
      text-align: center;
      margin-top: 12px;
      font-size: 14px;
    }
  </style>
</head>
<body>

<div class="login-card">
  <h2 class="text-center mb-4"><i class="bi bi-person-circle"></i> Admin / Trainer Login</h2>
  <form method="POST" action="login_process.php">
    <div class="mb-3">
      <label class="form-label"><i class="bi bi-envelope"></i> Email address</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label"><i class="bi bi-lock"></i> Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label"><i class="bi bi-person-badge"></i> Login as</label>
      <select name="role" class="form-select" required>
        <option value="" disabled selected>Select role</option>
        <option value="admin">Admin</option>
        <option value="trainer">Trainer</option>
      </select>
    </div>

    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
    <a href="forgot_password.php" class="forgot-link text-muted">Forgot Password?</a>
  </form>
</div>

</body>
</html>
