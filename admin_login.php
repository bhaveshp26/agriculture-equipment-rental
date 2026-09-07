<?php
include("header2.php");
if(session_status() === PHP_SESSION_NONE) session_start();
if(isset($_SESSION["email"])) { header("location:admin_dashboard.php"); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login - AgriRent</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    * { font-family: 'Poppins', sans-serif; }
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #0d1f0d 0%, #1a3a1a 50%, #2d5a2d 100%);
      display: flex; flex-direction: column;
    }
    .login-wrapper { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px 15px; }
    .login-card { background: #fff; border-radius: 20px; width: 100%; max-width: 440px; box-shadow: 0 20px 60px rgba(0,0,0,0.4); overflow: hidden; }
    .login-header { background: linear-gradient(135deg, #0d3d0d, #1a6b1a); padding: 35px 30px; text-align: center; color: #fff; }
    .login-header .icon-circle { width: 70px; height: 70px; background: rgba(255,255,255,0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 2rem; }
    .login-header h3 { margin: 0; font-weight: 700; font-size: 1.6rem; }
    .login-header p { margin: 5px 0 0; opacity: 0.8; font-size: 0.9rem; }
    .login-body { padding: 35px 30px; }
    .form-label { font-weight: 600; color: #333; font-size: 0.9rem; }
    .input-group-text { background: #f0faf0; border-color: #c8e6c9; color: #1a6b1a; }
    .form-control { border-color: #c8e6c9; padding: 10px 15px; }
    .form-control:focus { border-color: #1a6b1a; box-shadow: 0 0 0 0.2rem rgba(26,107,26,0.2); }
    .btn-login { background: linear-gradient(135deg, #1a6b1a, #0d3d0d); border: none; padding: 12px; font-size: 1rem; font-weight: 600; border-radius: 10px; width: 100%; }
    .btn-login:hover { opacity: 0.9; transform: translateY(-1px); }
    .admin-badge { background: #e8f5e9; color: #1a6b1a; padding: 4px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block; margin-bottom: 10px; }
  </style>
</head>
<body>
<div class="login-wrapper">
  <div class="login-card">
    <div class="login-header">
      <div class="icon-circle"><i class="fas fa-user-shield"></i></div>
      <div class="admin-badge"><i class="fas fa-cog me-1"></i>Admin Panel</div>
      <h3>Admin Login</h3>
      <p>Access the AgriRent control panel</p>
    </div>
    <div class="login-body">
      <form method="POST" action="admin_login_validate.php">
        <div class="mb-3">
          <label class="form-label">Admin Email</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" class="form-control" name="email" placeholder="Enter admin email" required>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control" name="password" placeholder="Enter password" required>
          </div>
        </div>
        <button type="submit" class="btn btn-login text-white mt-2"><i class="fas fa-sign-in-alt me-2"></i>Login to Admin Panel</button>
      </form>
      <div class="text-center mt-4">
        <a href="index.php" style="color:#1a6b1a; font-size:0.85rem; text-decoration:none;"><i class="fas fa-arrow-left me-1"></i>Back to Home</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
