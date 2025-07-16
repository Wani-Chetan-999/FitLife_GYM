<?php
include '../db.php';

$member_id = $_POST['member_id'];
$today = date('Y-m-d');

// Check if already checked in
$stmt = $conn->prepare("SELECT * FROM attendance WHERE member_id = ? AND date = ?");
$stmt->bind_param("is", $member_id, $today);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Mark checkout
    $update = $conn->prepare("UPDATE attendance SET check_out = NOW() WHERE member_id = ? AND date = ?");
    $update->bind_param("is", $member_id, $today);
    $update->execute();
    echo "Checked out successfully!";
} else {
    // Mark check-in
    $insert = $conn->prepare("INSERT INTO attendance (member_id, check_in, date) VALUES (?, NOW(), ?)");
    $insert->bind_param("is", $member_id, $today);
    $insert->execute();
    echo "Checked in successfully!";
}
