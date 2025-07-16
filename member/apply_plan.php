<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'member') {
    header("Location: ../member_login.php");
    exit;
}

$memberId = $_SESSION['user_id'];

// Step 1: Fetch Plan Details
if (isset($_GET['plan_id'])) {
    $planId = $_GET['plan_id'];
    $plan = $conn->query("SELECT * FROM membership_plans WHERE id = $planId")->fetch_assoc();
    if (!$plan) {
        die("Plan not found.");
    }
}

// Step 2: Handle Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $planId = $_POST['plan_id'];
    $paymentMode = $_POST['payment_mode'];
    $notes = $_POST['notes'];
    $paymentDate = date('Y-m-d');

    // Get plan details
    $plan = $conn->query("SELECT * FROM membership_plans WHERE id = $planId")->fetch_assoc();
    $amount = $plan['price'];
    $duration = $plan['duration'];
    $startDate = $paymentDate;
    $expiryDate = date('Y-m-d', strtotime("+$duration days"));

    // 1. Add to member_plans
    $conn->query("INSERT INTO member_plans (member_id, plan_id, start_date, expiry_date)
                  VALUES ($memberId, $planId, '$startDate', '$expiryDate')");

    // 2. Add to payments
    $conn->query("INSERT INTO payments (member_id, plan, amount, payment_date, next_due_date, payment_mode, notes)
                  VALUES ($memberId, '{$plan['plan_name']}', $amount, '$paymentDate', '$expiryDate', '$paymentMode', '$notes')");

    // Redirect back
    header("Location: member_dashboard.php?success=1");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Apply Plan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h3>Apply for Plan</h3>
    <?php if (isset($plan)): ?>
        <div class="card my-4">
            <div class="card-body">
                <h5 class="card-title"><?php echo $plan['plan_name']; ?></h5>
                <p><strong>Duration:</strong> <?php echo $plan['duration']; ?> days</p>
                <p><strong>Price:</strong> ₹<?php echo $plan['price']; ?></p>
                <p><?php echo $plan['description']; ?></p>
            </div>
        </div>

        <!-- Payment Form -->
        <form method="POST">
            <input type="hidden" name="plan_id" value="<?php echo $plan['id']; ?>">
            <div class="mb-3">
                <label>Payment Mode</label>
                <select name="payment_mode" class="form-control" required>
                    <option value="">Select</option>
                    <option value="Cash">Cash</option>
                    <option value="UPI">UPI</option>
                    <option value="Card">Card</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Notes (optional)</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Confirm & Pay ₹<?php echo $plan['price']; ?></button>
        </form>
    <?php else: ?>
        <p class="text-danger">No plan selected.</p>
    <?php endif; ?>
</div>
</body>
</html>
