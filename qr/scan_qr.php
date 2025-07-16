<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>QR Attendance Scanner</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f7f8fc, #e0eafc);
            font-family: 'Segoe UI', sans-serif;
        }
        .scanner-box {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        #qr-reader {
            border-radius: 10px;
            overflow: hidden;
        }
        h2 {
            font-weight: 600;
            color: #003366;
        }
        .scan-result {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="scanner-box text-center">
    <h2>📷 QR Code Attendance</h2>
    <p class="text-muted">Scan a valid QR code to mark a member’s attendance</p>
    <div id="qr-reader" style="width: 100%;"></div>
    <div id="qr-result" class="scan-result fw-semibold"></div>
</div>

<script>
    function onScanSuccess(qrMessage) {
        const resultBox = document.getElementById("qr-result");
        resultBox.innerHTML = `<div class="alert alert-info">⏳ Verifying QR: <strong>${qrMessage}</strong></div>`;

        fetch("mark_attendance.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "data=" + encodeURIComponent(qrMessage)
        })
        .then(res => res.text())
        .then(msg => {
            resultBox.innerHTML = `<div class="alert alert-success">✅ ${msg}</div>`;
        })
        .catch(err => {
            resultBox.innerHTML = `<div class="alert alert-danger">❌ Error: ${err.message}</div>`;
        });
    }

    function onScanFailure(error) {
        console.warn(`QR Scan error: ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", {
        fps: 10,
        qrbox: 250
    });
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
</body>
</html>
