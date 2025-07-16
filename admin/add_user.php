<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    die("Access denied.");
}

$success = $error = "";

if (isset($_POST['create_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
        $success = "✅ User created successfully!";
    } else {
        $error = "❌ Failed to create user. Try another email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right,rgb(2, 12, 48),rgb(2, 0, 15));
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 40px 30px;
            width: 100%;
            max-width: 450px;
        }

        .form-card h3 {
            margin-bottom: 30px;
            font-weight: bold;
            color: #007bff;
        }

        .form-card .form-control,
        .form-card .form-select {
            border-radius: 10px;
            padding: 10px 15px;
        }

        .form-card button {
            border-radius: 10px;
            font-weight: 600;
        }

        .alert {
            border-radius: 10px;
        }

        .form-icon {
            margin-right: 8px;
        }
    </style>
</head>
<body>

<div class="form-card">
    <h3><i class="fas fa-user-plus form-icon"></i>Create Trainer / Admin</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-user form-icon"></i>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fas fa-envelope form-icon"></i>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fas fa-lock form-icon"></i>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fas fa-user-tag form-icon"></i>Role</label>
            <select name="role" class="form-select" required>
                <option value="trainer">Trainer</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <button type="submit" name="create_user" class="btn btn-primary w-100">
            <i class="fas fa-plus-circle me-2"></i>Create User
        </button>
    </form>
</div>

</body>
</html>
