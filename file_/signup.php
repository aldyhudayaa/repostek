<?php
include './config/db.php';
include './_partials/_template/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $role_id = $_POST['role_id'];
    $created_at = date('Y-m-d H:i:s');
    $update_at = date('Y-m-d H:i:s');

    
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    
    $stmt = $conn->prepare("INSERT INTO tb_users (fullname, email, password, jenis_kelamin, no_telp, alamat, image, role_id, created_at, update_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssiis", $fullname, $email, $password, $jenis_kelamin, $no_telp, $alamat, $image, $role_id, $created_at, $update_at);

    if ($stmt->execute()) {
        header("Location: index.php?page=login");
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - ChatAI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .container {
            max-width: 450px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            border-radius: 8px;
        }
        .btn-primary {
            border-radius: 8px;
            font-size: 16px;
            padding: 12px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Sign Up</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="fullname" class="form-control" required placeholder="Enter your full name">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required placeholder="Enter your email">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="Enter your password">
        </div>

        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">Select Gender</option>
                <option value="1">Male</option>
                <option value="2">Female</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="no_telp" class="form-control" required placeholder="Enter phone number">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="alamat" class="form-control" required placeholder="Enter your address"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Profile Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role_id" class="form-control" required>
                <option value="1">Admin</option>
                <option value="2">User</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Sign Up</button>
    </form>

    <p class="text-center mt-3">
        Already have an account? <a href="index.php?page=login">Login</a>
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
