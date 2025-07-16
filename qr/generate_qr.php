<?php
require '../vendor/autoload.php';
include '../db.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

$saveDir = __DIR__ . '/qrcodes/';
if (!is_dir($saveDir)) {
    mkdir($saveDir, 0777, true);
}

$members = $conn->query("SELECT id, name FROM members");
$qrList = [];

while ($row = $members->fetch_assoc()) {
    $memberId = $row['id'];
    $memberName = $row['name'];
    $qrText = "MEMBER_ID:$memberId";

    $qrCode = new QrCode($qrText);
    $qrCode->setSize(300);
    $qrCode->setMargin(10);

    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    $fileName = "member_$memberId.png";
    $filePath = $saveDir . $fileName;
    $result->saveToFile($filePath);

    $qrList[] = ['name' => $memberName, 'file' => "qrcodes/$fileName"];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Member QR Codes</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background: #f4f7fc;
    }
    .card {
      box-shadow: 0 6px 15px rgba(0,0,0,0.08);
      border: none;
      border-radius: 10px;
    }
    .btn-download {
      border-radius: 25px;
    }
  </style>
</head>
<body>
<div class="container py-5">
  <h2 class="mb-4 text-center text-primary">🎯 QR Codes for All Members</h2>
  <div class="row g-4">
    <?php foreach ($qrList as $qr): ?>
      <div class="col-md-4 col-sm-6">
        <div class="card p-3 text-center">
          <h5 class="mb-3"><?= htmlspecialchars($qr['name']) ?></h5>
          <img src="<?= htmlspecialchars($qr['file']) ?>" class="img-fluid mb-3" alt="QR Code">
          <a href="<?= htmlspecialchars($qr['file']) ?>" download class="btn btn-outline-success btn-download">
            ⬇️ Download QR
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
</body>
</html>
