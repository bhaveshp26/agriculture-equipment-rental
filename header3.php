<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
  .ag-navbar { background: linear-gradient(135deg, #1a6b1a, #4caf50); padding: 0 20px; box-shadow: 0 2px 15px rgba(0,0,0,0.2); }
  .ag-navbar .navbar-brand { color:#fff !important; font-weight:700; font-size:1.4rem; }
  .ag-navbar .navbar-brand span { color:#d4f7d4; }
  .ag-navbar .nav-link { color:rgba(255,255,255,0.9) !important; padding:8px 14px !important; border-radius:6px; transition:all 0.2s; }
  .ag-navbar .nav-link:hover { background:rgba(255,255,255,0.2); }
  .ag-navbar .dropdown-menu { border:none; box-shadow:0 5px 20px rgba(0,0,0,0.15); border-radius:10px; }
  .ag-navbar .dropdown-item:hover { background:#e8f5e9; color:#1a6b1a; }
  .ag-navbar .dropdown-item i { width:20px; color:#1a6b1a; }
</style>
<nav class="navbar navbar-expand-lg ag-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="user_dashboard.php"><i class="fas fa-tractor me-2"></i>Agri<span>Rent</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userNav" style="border-color:rgba(255,255,255,0.5);">
      <span style="color:white;"><i class="fas fa-bars"></i></span>
    </button>
    <div class="collapse navbar-collapse" id="userNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="user_dashboard.php"><i class="fas fa-home me-1"></i>Home</a></li>
        <li class="nav-item"><a class="nav-link" href="user_view_eq.php"><i class="fas fa-tools me-1"></i>Equipment</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php"><i class="fas fa-envelope me-1"></i>Contact</a></li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php if(isset($_SESSION["email"]) && !empty($_SESSION["email"])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
              <i class="fas fa-user-circle me-1"></i>My Account
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
              <li><a class="dropdown-item" href="view_booking_code.php?temail=<?php echo urlencode($_SESSION['email']); ?>"><i class="fas fa-calendar-check me-2"></i>My Bookings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="user_login.php"><i class="fas fa-sign-in-alt me-1"></i>Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
