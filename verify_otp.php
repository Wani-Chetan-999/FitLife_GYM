<!-- verify_otp.php -->
<!DOCTYPE html>
<html>
<head>
  <title>Verify OTP</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .otp-card {
      background-color: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 420px;
    }

    .otp-card h3 {
      color: #198754;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .btn-success {
      background-color: #198754;
      border: none;
    }

    .btn-success:hover {
      background-color: #157347;
    }
  </style>
</head>
<body>
  <div class="otp-card text-center">
    <h3>🔑 Verify OTP</h3>
    <p class="text-muted">Enter the OTP sent to your email</p>
    <form action="reset_password.php" method="POST">
      <div class="mb-3 text-start">
        <label for="otp" class="form-label">OTP</label>
        <input type="text" name="otp" id="otp" class="form-control" required>
      </div>
      <button type="submit" name="verify_otp" class="btn btn-success w-100">Verify</button>
    </form>
  </div>
</body>
</html>
