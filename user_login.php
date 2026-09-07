<?php
include("navbar.php");
if(session_status() === PHP_SESSION_NONE) session_start();
if(isset($_SESSION["email"])) { header("location:user_dashboard.php?tid=".urlencode($_SESSION["email"])); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Login - AgriRent</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    * { font-family: 'Poppins', sans-serif; }
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #0d3d0d 0%, #1a6b1a 50%, #4caf50 100%);
      display: flex; flex-direction: column;
    }
    .login-wrapper { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px 15px; }
    .login-card {
      background: #fff; border-radius: 20px; width: 100%; max-width: 440px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden;
    }
    .login-header {
      background: linear-gradient(135deg, #1a6b1a, #4caf50);
      padding: 35px 30px; text-align: center; color: #fff;
    }
    .login-header .icon-circle {
      width: 70px; height: 70px; background: rgba(255,255,255,0.2);
      border-radius: 50%; display: flex; align-items: center; justify-content: center;
      margin: 0 auto 15px; font-size: 2rem;
    }
    .login-header h3 { margin: 0; font-weight: 700; font-size: 1.6rem; }
    .login-header p { margin: 5px 0 0; opacity: 0.85; font-size: 0.9rem; }
    .login-body { padding: 35px 30px; }
    .form-label { font-weight: 600; color: #333; font-size: 0.9rem; }
    .input-group-text { background: #f0faf0; border-color: #c8e6c9; color: #4caf50; }
    .form-control { border-color: #c8e6c9; padding: 10px 15px; }
    .form-control:focus { border-color: #4caf50; box-shadow: 0 0 0 0.2rem rgba(76,175,80,0.2); }
    .btn-login { background: linear-gradient(135deg, #4caf50, #1a6b1a); border: none; padding: 12px; font-size: 1rem; font-weight: 600; border-radius: 10px; width: 100%; letter-spacing: 0.5px; }
    .btn-login:hover { opacity: 0.9; transform: translateY(-1px); }
    .divider { text-align: center; position: relative; margin: 20px 0; }
    .divider::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: #e0e0e0; }
    .divider span { background: #fff; padding: 0 12px; color: #999; font-size: 0.85rem; position: relative; }
    .link-green { color: #1a6b1a; font-weight: 600; text-decoration: none; }
    .link-green:hover { color: #4caf50; }
  </style>
</head>
<body>
<div class="login-wrapper">
  <div class="login-card">
    <div class="login-header">
      <div class="icon-circle"><i class="fas fa-user"></i></div>
      <h3>Welcome Back!</h3>
      <p>Login to your AgriRent account</p>
    </div>
    <div class="login-body">
      <form method="POST" action="user_login_validate.php">
        <div class="mb-3">
          <label class="form-label">Email Address</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control" name="password1" placeholder="Enter your password" required>
          </div>
          <div class="text-end mt-1"><a href="forget_passoword.php" class="link-green" style="font-size:0.85rem;">Forgot Password?</a></div>
        </div>
        <button type="submit" class="btn btn-login text-white mt-2"><i class="fas fa-sign-in-alt me-2"></i>Login</button>
      </form>
      <div class="divider"><span>Don't have an account?</span></div>
      <div class="text-center">
        <a href="how-to-register.php" class="btn btn-outline-success w-100" style="border-radius:10px; font-weight:600;">
          <i class="fas fa-user-plus me-2"></i>Create New Account
        </a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
