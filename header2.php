<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
  .ag-navbar { background: linear-gradient(135deg, #0d3d0d, #1a6b1a); padding: 0 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.2); }
  .ag-navbar .navbar-brand { color:#fff !important; font-weight:700; font-size:1.4rem; }
  .ag-navbar .navbar-brand span { color:#a8f0a8; }
  .ag-navbar .nav-link { color:rgba(255,255,255,0.9) !important; padding:8px 14px !important; border-radius:6px; }
  .ag-navbar .nav-link:hover { background:rgba(255,255,255,0.15); }
</style>
<nav class="navbar navbar-expand-lg ag-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><i class="fas fa-tractor me-2"></i>Agri<span>Rent</span></a>
    <div class="ms-auto">
      <?php if(isset($_SESSION["email"]) && !empty($_SESSION["email"])): ?>
        <a class="nav-link d-inline" href="logout.php" style="color:rgba(255,255,255,0.9);"><i class="fas fa-sign-out-alt me-1"></i>Logout</a>
      <?php else: ?>
        <a class="nav-link d-inline" href="admin_login.php" style="color:rgba(255,255,255,0.9);"><i class="fas fa-cog me-1"></i>Admin Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
