<?php
session_start();
include 'db.php';

if (isset($_POST['verify_otp'])) {
    $otp = $_POST['otp'];
    $email = $_SESSION['reset_email'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND otp_code=? AND otp_expiry >= NOW()");
    $stmt->bind_param("ss", $email, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['verified'] = true;
        ?>
        <!DOCTYPE html>
        <html>
        <head>
          <title>Reset Password</title>
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
          <style>
            body {
              background: linear-gradient(to right, #e0eafc, #cfdef3);
              display: flex;
              justify-content: center;
              align-items: center;
              height: 100vh;
            }
            .card {
              border-radius: 15px;
              padding: 30px;
              box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
              background: #fff;
              max-width: 450px;
              width: 100%;
            }
          </style>
        </head>
        <body>
        <div class="card">
          <h4 class="mb-3 text-center text-primary">🔐 Reset Your Password</h4>
          <form action="update_password.php" method="POST">
            <div class="mb-3">
              <label class="form-label">New Password:</label>
              <input type="password" name="new_password" class="form-control" required>
            </div>
            <button type="submit" name="reset_password" class="btn btn-success w-100">Update Password</button>
          </form>
        </div>
        </body>
        </html>
        <?php
    } else {
        echo "
        <!DOCTYPE html>
        <html>
        <head>
          <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'>
        </head>
        <body class='bg-light d-flex align-items-center justify-content-center' style='height: 100vh;'>
          <div class='alert alert-danger p-4 text-center'>
            ❌ Invalid or expired OTP.<br><br>
            <a href='forgot_password.php' class='btn btn-sm btn-outline-primary mt-2'>Try Again</a>
          </div>
        </body>
        </html>";
    }
}
?>
