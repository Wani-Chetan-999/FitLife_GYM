<?php
session_start();
include 'db.php';

if (isset($_POST['send_otp'])) {
    $email = $_POST['email'];

    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $otp = rand(100000, 999999);
        $otp_expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        // Save OTP to DB
        $update = $conn->prepare("UPDATE users SET otp_code=?, otp_expiry=? WHERE email=?");
        $update->bind_param("sss", $otp, $otp_expiry, $email);
        $update->execute();

        // Simulate email sending (later you can use PHPMailer or SMTP)
        echo "OTP sent to your email: <strong>$otp</strong> (for testing)<br><a href='verify_otp.php'>Verify OTP</a>";

        $_SESSION['reset_email'] = $email;
    } else {
        echo "Email not found.";
    }
}
?>
