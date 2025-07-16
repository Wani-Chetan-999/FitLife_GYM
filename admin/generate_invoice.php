<?php
require '../vendor/autoload.php'; // if using Composer

use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../db.php';

// Get payment ID
$payment_id = $_GET['id'];
$sql = $conn->prepare("SELECT p.*, m.name, m.email FROM payments p JOIN members m ON p.member_id = m.id WHERE p.id = ?");
$sql->bind_param("i", $payment_id);
$sql->execute();
$data = $sql->get_result()->fetch_assoc();

// Prepare invoice HTML
$html = "
<h2>Gym Invoice</h2>
<p><strong>Member:</strong> {$data['name']}<br>
<strong>Email:</strong> {$data['email']}<br>
<strong>Plan:</strong> {$data['plan']}<br>
<strong>Amount:</strong> ₹{$data['amount']}<br>
<strong>Payment Date:</strong> {$data['payment_date']}<br>
<strong>Next Due:</strong> {$data['next_due_date']}<br>
<strong>Payment Mode:</strong> {$data['payment_mode']}<br>
<strong>Notes:</strong> {$data['notes']}</p>
<hr>
<p style='font-size:12px;'>Thank you for your payment!</p>
";

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$pdf = $dompdf->output();

// Save PDF temporarily
$file_path = "../invoices/invoice_{$payment_id}.pdf";
file_put_contents($file_path, $pdf);

// Send Email with PHPMailer
$mail = new PHPMailer(true);

try {
    // SMTP Settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Your SMTP
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@gmail.com'; // Your email
    $mail->Password = 'your_app_password';    // App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Email details
    $mail->setFrom('your_email@gmail.com', 'Your Gym Name');
    $mail->addAddress($data['email'], $data['name']);
    $mail->Subject = 'Your Gym Payment Invoice';
    $mail->Body = 'Please find your invoice attached.';

    $mail->addAttachment($file_path);

    $mail->send();
    echo "Invoice sent to {$data['email']}!";
} catch (Exception $e) {
    echo "Email failed: {$mail->ErrorInfo}";
}
?>
