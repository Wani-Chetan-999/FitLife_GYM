<!-- forgot_password.php -->
<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #f0f4f7, #d9e2ec);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .forgot-card {
      background-color: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 420px;
    }

    .forgot-card h3 {
      font-weight: bold;
      color: #0d6efd;
    }

    .btn-primary {
      background-color: #0d6efd;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0b5ed7;
    }
  </style>
</head>
<body>
  <div class="forgot-card text-center">
    <h3>🔐 Forgot Password</h3>
    <p class="text-muted mb-4">Enter your email to receive an OTP</p>
    <form action="send_otp.php" method="POST">
      <div class="mb-3 text-start">
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" id="email" class="form-control" required>
      </div>
      <button type="submit" name="send_otp" class="btn btn-primary w-100">Send OTP</button>
    </form>
  </div>
</body>
</html>
