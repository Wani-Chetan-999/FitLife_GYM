<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Reset Password Result</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background: linear-gradient(to right, #dff9fb, #f9f9f9);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .result-card {
      padding: 30px;
      max-width: 450px;
      width: 100%;
      background-color: #fff;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      border-radius: 15px;
      text-align: center;
    }
    .btn-login {
      margin-top: 15px;
    }
  </style>
</head>
<body>
<div class="result-card">
<?php
if (isset($_POST['reset_password']) && isset($_SESSION['verified'])) {
    $email = $_SESSION['reset_email'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password=?, otp_code=NULL, otp_expiry=NULL WHERE email=?");
    $stmt->bind_param("ss", $new_password, $email);
    
    if ($stmt->execute()) {
        echo "<h4 class='text-success'>✅ Password Updated Successfully!</h4>";
        echo "<p class='mt-2'>You can now log in with your new password.</p>";
        echo "<a href='login.php' class='btn btn-primary btn-login'>Go to Login</a>";
        session_destroy();
    } else {
        echo "<h4 class='text-danger'>❌ Failed to update password.</h4>";
        echo "<p>Please try again later.</p>";
        echo "<a href='forgot_password.php' class='btn btn-outline-danger btn-login'>Try Again</a>";
    }
} else {
    echo "<h4 class='text-warning'>⚠️ Unauthorized Access</h4>";
    echo "<p>You must verify your OTP first.</p>";
    echo "<a href='forgot_password.php' class='btn btn-outline-warning btn-login'>Start Over</a>";
}
?>
</div>
</body>
</html>
