<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['reset_email'])) { header("Location: forget-password.php"); exit(); }
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "root", "", "cafeteria", 3306);
    $code = $conn->real_escape_string($_POST['code']); $email = $_SESSION['reset_email'];
    $check = $conn->query("SELECT * FROM users WHERE email='$email' AND Reset_token='$code'");
    if ($check->num_rows > 0) { header("Location: reset-password.php"); exit(); }
    else { echo "<script>alert('Invalid verification code!');</script>"; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Verify Code</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> body{ background-color:#FBF5DD; } .box{ width:400px; margin:60px auto; background:white; padding:40px; border-radius:15px; box-shadow:0 4px 10px rgba(0,0,0,0.1); } h2{ color:#0D530E; text-align:center; margin-bottom:20px; font-weight:bold;} .btn-verify{ background:#0D530E; color:white; width:100%; } .btn-verify:hover{ background-color:#306D29; } </style>
</head>
<body>
<?php include("partions/user-navbar.php"); ?>
<div class="box">
    <h2>Verification Code</h2>
    <form action="" method="POST">
        <label class="form-label" style="font-weight:bold; color:#306D29;">Enter 4-Digit Code</label>
        <input type="text" name="code" class="form-control mb-3" placeholder="Enter verification code" required>
        <button type="submit" class="btn btn-verify">Verify</button>
    </form>
</div>
</body>
</html>