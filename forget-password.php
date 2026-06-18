<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "root", "", "cafeteria", 3306);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
    $email = $conn->real_escape_string($_POST['email']);
    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($result->num_rows > 0) {
        $code = rand(1000, 9999);
        $conn->query("UPDATE users SET Reset_token='$code' WHERE email='$email'");
        $_SESSION['reset_email'] = $email;
        echo "<script>alert('Your Verification Code is: $code'); window.location.href='verify-code.php';</script>";
        exit();
    } else { echo "<script>alert('Email not found!');</script>"; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Forgot Password</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> body{ background-color:#FBF5DD; } .box{ width:400px; margin:60px auto; background:white; padding:40px; border-radius:15px; box-shadow:0 4px 10px rgba(0,0,0,0.1); } h2{ color:#0D530E; text-align:center; margin-bottom:20px; font-weight:bold;} .btn-send{ background:#0D530E; color:white; width:100%; } .btn-send:hover{ background-color:#306D29; } </style>
</head>
<body>
<?php include("partions/user-navbar.php"); ?>
<div class="box">
    <h2>Forgot Password</h2>
    <form action="" method="POST">
        <label class="form-label" style="font-weight:bold; color:#306D29;">Email Address</label>
        <input type="email" name="email" class="form-control mb-3" placeholder="Enter your email" required>
        <button type="submit" class="btn btn-send">Send Code</button>
    </form>
</div>
</body>
</html>