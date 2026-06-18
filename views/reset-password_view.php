<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['reset_email'])) { header("Location: forget-password.php"); exit(); }
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "root", "", "cafeteria", 3306);
    $new_pass = $_POST['password']; $confirm_pass = $_POST['confirm_password']; $email = $_SESSION['reset_email'];
    if ($new_pass === $confirm_pass) {
        $protected_pass = $conn->real_escape_string($new_pass);
        $conn->query("UPDATE users SET password='$protected_pass', Reset_token=NULL WHERE email='$email'");
        unset($_SESSION['reset_email']);
        echo "<script>alert('Password updated successfully!'); window.location.href='login.php';</script>";
        exit();
    } else { echo "<script>alert('Passwords do not match!');</script>"; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Reset Password</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> body{ background-color:#FBF5DD; font-family: Arial, sans-serif; } .reset-box{ background:white; padding:40px; border-radius:15px; width:400px; margin:60px auto; box-shadow:0 4px 15px rgba(0,0,0,0.1); } h2{ text-align:center; color:#0D530E; margin-bottom:25px; font-weight:bold; } label{ font-weight:bold; color:#306D29; } .btn-reset{ background-color:#0D530E; color:white; width:100%; border:none; } .btn-reset:hover{ background-color:#306D29; } </style>
</head>
<body>
<?php include("partions/user-navbar.php"); ?>
<div class="reset-box">
    <h2>Reset Password</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter new password" required>
        </div>
        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password" required>
        </div>
        <button type="submit" class="btn btn-reset">Reset Password</button>
    </form>
</div>
</body>
</html>