<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
  .ag-navbar {
    background: linear-gradient(135deg, #1a6b1a 0%, #2d9e2d 60%, #4caf50 100%);
    padding: 0 20px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.3);
  }
  .ag-navbar .navbar-brand { color: #fff !important; font-size: 1.5rem; font-weight: 700; }
  .ag-navbar .navbar-brand span { color: #a8f0a8; }
  .ag-navbar .nav-link { color: rgba(255,255,255,0.9) !important; font-weight: 500; padding: 8px 14px !important; border-radius: 6px; transition: all 0.2s; }
  .ag-navbar .nav-link:hover { background: rgba(255,255,255,0.2); color: #fff !important; }
  .ag-navbar .btn-nav-login { background: #fff; color: #1a6b1a !important; border-radius: 20px; padding: 6px 18px !important; font-weight: 600; }
  .ag-navbar .btn-nav-login:hover { background: #e8f5e9; }
  .ag-navbar .btn-nav-register { background: transparent; border: 2px solid #fff; color: #fff !important; border-radius: 20px; padding: 5px 18px !important; font-weight: 600; }
  .ag-navbar .btn-nav-register:hover { background: rgba(255,255,255,0.2); }
  .ag-navbar .dropdown-menu { border: none; box-shadow: 0 5px 20px rgba(0,0,0,0.15); border-radius: 10px; }
  .ag-navbar .dropdown-item:hover { background: #e8f5e9; color: #1a6b1a; }
  .ag-navbar .dropdown-item i { width: 20px; color: #2d9e2d; }
</style>

<nav class="navbar navbar-expand-lg ag-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <i class="fas fa-tractor me-2"></i>Agri<span>Rent</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" style="border-color:rgba(255,255,255,0.5);">
      <span style="color:white;"><i class="fas fa-bars"></i></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-home me-1"></i>Home</a></li>
        <li class="nav-item"><a class="nav-link" href="user_view_eq.php"><i class="fas fa-tools me-1"></i>Equipment</a></li>
        <li class="nav-item"><a class="nav-link" href="about us.php"><i class="fas fa-info-circle me-1"></i>About</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php"><i class="fas fa-envelope me-1"></i>Contact</a></li>
      </ul>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center gap-2">
        <?php if(isset($_SESSION["email"]) && !empty($_SESSION["email"])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
              <i class="fas fa-user-circle me-1"></i><?php echo htmlspecialchars($_SESSION["email"]); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>My Profile</a></li>
              <li><a class="dropdown-item" href="view_booking_code.php?temail=<?php echo urlencode($_SESSION['email']); ?>"><i class="fas fa-calendar-check me-2"></i>My Bookings</a></li>
              <li><a class="dropdown-item" href="user_view_eq.php"><i class="fas fa-tractor me-2"></i>View Equipment</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link btn-nav-register" href="how-to-register.php"><i class="fas fa-user-plus me-1"></i>Register</a></li>
          <li class="nav-item"><a class="nav-link btn-nav-login" href="user_login.php"><i class="fas fa-sign-in-alt me-1"></i>Login</a></li>
          <li class="nav-item"><a class="nav-link" href="admin_login.php" style="opacity:0.7; font-size:0.85rem;"><i class="fas fa-cog me-1"></i>Admin</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
