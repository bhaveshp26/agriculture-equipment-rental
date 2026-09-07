<?php
session_start();
include_once("connection.php");
include("navbar.php");

if (!isset($_GET['tid'])) { header("location:user_view_eq.php"); exit; }

$tid = trim($_GET['tid']);

// Block admin from booking — only registered users can book
if (!isset($_SESSION['email'])) {
    header("location:user_login.php?redirect=booking.php?tid=" . urlencode($tid));
    exit;
}

// Check if session email belongs to a user (not admin)
$chk = mysqli_prepare($con, "SELECT user_id FROM user_reg WHERE email = ?");
mysqli_stmt_bind_param($chk, "s", $_SESSION['email']);
mysqli_stmt_execute($chk);
mysqli_stmt_store_result($chk);
if (mysqli_stmt_num_rows($chk) === 0) {
    mysqli_stmt_close($chk);
    mysqli_close($con);
    echo "<!DOCTYPE html><html><head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head><body style='background:#f0faf0; font-family:Poppins,sans-serif;'>
    <div style='max-width:480px; margin:80px auto; background:#fff; border-radius:16px; padding:40px; box-shadow:0 10px 40px rgba(0,0,0,0.1); text-align:center;'>
    <div style='font-size:4rem; margin-bottom:15px;'>🚫</div>
    <h4 style='color:#c62828; font-weight:700;'>Admins Cannot Book Equipment</h4>
    <p style='color:#666;'>Booking is only available for registered users. Please login with a user account to proceed.</p>
    <a href='logout.php' style='display:inline-block; margin-top:15px; background:linear-gradient(135deg,#4caf50,#1a6b1a); color:#fff; padding:11px 30px; border-radius:25px; text-decoration:none; font-weight:600;'>
    Switch to User Account</a>
    <br><a href='user_view_eq.php' style='display:inline-block; margin-top:12px; color:#1a6b1a; font-size:0.9rem;'>← Back to Equipment</a>
    </div></body></html>";
    exit;
}
mysqli_stmt_close($chk);
$stmt = mysqli_prepare($con, "SELECT * FROM equipments WHERE eq_id = ?");
mysqli_stmt_bind_param($stmt, "s", $tid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$eq = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$eq) { echo "<script>alert('Equipment not found'); window.location='user_view_eq.php';</script>"; exit; }

// Block booking if equipment is already booked
if (strtolower($eq['status']) !== 'available') {
    echo "<!DOCTYPE html><html><head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' rel='stylesheet'>
    </head><body style='background:#f0faf0; font-family:Poppins,sans-serif;'>
    <div style='max-width:500px; margin:80px auto; background:#fff; border-radius:16px; padding:40px; box-shadow:0 10px 40px rgba(0,0,0,0.1); text-align:center;'>
    <div style='font-size:4rem; margin-bottom:15px;'>⚠️</div>
    <h4 style='color:#e65100; font-weight:700;'>Equipment Already Booked</h4>
    <p style='color:#666;'><b>" . htmlspecialchars($eq['name']) . "</b> is currently <b style=\"color:#c62828;\">" . htmlspecialchars($eq['status']) . "</b> and not available for booking right now.</p>
    <p style='color:#888; font-size:0.9rem;'>Please check back later or choose another equipment.</p>
    <a href='user_view_eq.php' style='display:inline-block; margin-top:15px; background:linear-gradient(135deg,#4caf50,#1a6b1a); color:#fff; padding:11px 30px; border-radius:25px; text-decoration:none; font-weight:600;'>
    <i class='fas fa-arrow-left me-2'></i>Browse Other Equipment</a>
    </div></body></html>";
    exit;
}

$user_email = $_SESSION['email'] ?? '';
$today = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Book Equipment - AgriRent</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    * { font-family: 'Poppins', sans-serif; }
    body { background: linear-gradient(135deg, #e8f5e9 0%, #f1f8e9 100%); min-height: 100vh; }
    .booking-card { background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); overflow: hidden; max-width: 900px; margin: 30px auto; }
    .booking-header { background: linear-gradient(135deg, #1a6b1a, #4caf50); padding: 30px; color: #fff; }
    .booking-header h3 { font-weight: 700; margin: 0; }
    .eq-preview { background: #f0faf0; border-radius: 12px; padding: 20px; border: 2px solid #c8e6c9; }
    .eq-preview .eq-img { width: 100px; height: 100px; object-fit: cover; border-radius: 10px; }
    .eq-preview .eq-img-placeholder { width: 100px; height: 100px; background: #c8e6c9; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: #4caf50; }
    .form-label { font-weight: 600; color: #333; font-size: 0.88rem; }
    .form-control, .form-select { border-color: #c8e6c9; border-radius: 8px; padding: 10px 14px; }
    .form-control:focus, .form-select:focus { border-color: #4caf50; box-shadow: 0 0 0 0.2rem rgba(76,175,80,0.2); }
    .form-control[readonly] { background: #f0faf0; color: #555; }
    .price-summary { background: linear-gradient(135deg, #e8f5e9, #f1f8e9); border-radius: 12px; padding: 20px; border: 2px dashed #4caf50; }
    .price-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #c8e6c9; font-size: 0.9rem; }
    .price-row:last-child { border-bottom: none; font-weight: 700; font-size: 1.05rem; color: #1a6b1a; }
    .btn-book { background: linear-gradient(135deg, #4caf50, #1a6b1a); border: none; padding: 14px 40px; border-radius: 50px; font-size: 1rem; font-weight: 700; color: #fff; width: 100%; transition: all 0.3s; }
    .btn-book:hover { opacity: 0.9; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(76,175,80,0.4); }
    .status-badge { padding: 5px 14px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
    .status-available { background: #e8f5e9; color: #1a6b1a; }
    .status-unavailable { background: #fdecea; color: #c62828; }
    .section-divider { border: none; border-top: 2px dashed #c8e6c9; margin: 20px 0; }
  </style>
</head>
<body>
<div class="container px-3">
  <div class="booking-card">
    <div class="booking-header">
      <div class="d-flex align-items-center gap-3">
        <div style="background:rgba(255,255,255,0.2); width:50px; height:50px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
          <i class="fas fa-tractor"></i>
        </div>
        <div>
          <h3><i class="fas fa-calendar-plus me-2"></i>Book Equipment</h3>
          <p class="mb-0" style="opacity:0.85; font-size:0.9rem;">Fill in the details to confirm your booking</p>
        </div>
      </div>
    </div>

    <div class="p-4">
      <!-- Equipment Preview -->
      <div class="eq-preview mb-4">
        <div class="d-flex align-items-center gap-3">
          <?php if (!empty($eq['eq_img'])): ?>
            <img src="<?php echo htmlspecialchars($eq['eq_img']); ?>" class="eq-img" alt="Equipment">
          <?php else: ?>
            <div class="eq-img-placeholder"><i class="fas fa-tractor"></i></div>
          <?php endif; ?>
          <div>
            <h5 class="fw-bold text-success mb-1"><?php echo htmlspecialchars($eq['name']); ?></h5>
            <span class="badge bg-secondary me-1"><?php echo htmlspecialchars($eq['eq_type']); ?></span>
            <span class="status-badge <?php echo strtolower($eq['status']) == 'available' ? 'status-available' : 'status-unavailable'; ?>">
              <i class="fas fa-circle me-1" style="font-size:0.6rem;"></i><?php echo htmlspecialchars($eq['status']); ?>
            </span>
            <div class="mt-1"><span class="text-muted" style="font-size:0.85rem;"><?php echo htmlspecialchars($eq['description']); ?></span></div>
            <div class="mt-1 fw-bold text-success"><i class="fas fa-rupee-sign me-1"></i><?php echo htmlspecialchars($eq['rent_price']); ?> / day</div>
          </div>
        </div>
      </div>

      <form action="booking_code.php" method="post" id="bookingForm">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($eq['eq_id']); ?>">
        <input type="hidden" name="etype" value="<?php echo htmlspecialchars($eq['eq_type']); ?>">
        <input type="hidden" name="price" value="<?php echo htmlspecialchars($eq['rent_price']); ?>">

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label"><i class="fas fa-user me-1 text-success"></i>Your Full Name</label>
            <input type="text" class="form-control" name="name" placeholder="Enter your name" required>
          </div>
          <div class="col-md-6">
            <label class="form-label"><i class="fas fa-envelope me-1 text-success"></i>Email Address</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user_email); ?>" placeholder="Enter your email" required>
          </div>
          <div class="col-md-6">
            <label class="form-label"><i class="fas fa-tools me-1 text-success"></i>Equipment ID</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($eq['eq_id']); ?>" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label"><i class="fas fa-tag me-1 text-success"></i>Equipment Name</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($eq['name']); ?>" readonly>
          </div>
          <div class="col-md-4">
            <label class="form-label"><i class="fas fa-clock me-1 text-success"></i>Pickup Time</label>
            <input type="time" class="form-control" name="time" required>
          </div>
          <div class="col-md-4">
            <label class="form-label"><i class="fas fa-calendar me-1 text-success"></i>Booking Date</label>
            <input type="date" class="form-control" name="date" id="booking_date" min="<?php echo $today; ?>" required onchange="calcTotal()">
          </div>
          <div class="col-md-4">
            <label class="form-label"><i class="fas fa-calendar-check me-1 text-success"></i>Return Date</label>
            <input type="date" class="form-control" name="rdate" id="return_date" min="<?php echo $today; ?>" required onchange="calcTotal()">
          </div>
        </div>

        <hr class="section-divider">

        <!-- Price Summary -->
        <div class="price-summary mb-4">
          <h6 class="fw-bold text-success mb-3"><i class="fas fa-receipt me-2"></i>Price Summary</h6>
          <div class="price-row"><span>Equipment</span><span><?php echo htmlspecialchars($eq['name']); ?></span></div>
          <div class="price-row"><span>Rate</span><span>₹<?php echo htmlspecialchars($eq['rent_price']); ?>/day</span></div>
          <div class="price-row"><span>Duration</span><span id="duration_display">— days</span></div>
          <div class="price-row"><span>Subtotal</span><span id="subtotal_display">₹—</span></div>
          <div class="price-row"><span>GST (18%)</span><span id="gst_display">₹—</span></div>
          <div class="price-row"><span><i class="fas fa-rupee-sign me-1"></i>Total Amount</span><span id="total_display">₹—</span></div>
          <input type="hidden" name="total_amount" id="total_amount_input">
          <input type="hidden" name="days" id="days_input">
        </div>

        <button type="submit" class="btn btn-book">
          <i class="fas fa-check-circle me-2"></i>Confirm Booking
        </button>
      </form>
    </div>
  </div>
</div>

<script>
const pricePerDay = <?php echo (float)$eq['rent_price']; ?>;

function calcTotal() {
  const bd = document.getElementById('booking_date').value;
  const rd = document.getElementById('return_date').value;
  if (!bd || !rd) return;

  const d1 = new Date(bd), d2 = new Date(rd);
  if (d2 <= d1) {
    document.getElementById('return_date').setCustomValidity('Return date must be after booking date');
    return;
  }
  document.getElementById('return_date').setCustomValidity('');

  const days = Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24));
  const subtotal = days * pricePerDay;
  const gst = subtotal * 0.18;
  const total = subtotal + gst;

  document.getElementById('duration_display').textContent = days + ' day(s)';
  document.getElementById('subtotal_display').textContent = '₹' + subtotal.toFixed(2);
  document.getElementById('gst_display').textContent = '₹' + gst.toFixed(2);
  document.getElementById('total_display').textContent = '₹' + total.toFixed(2);
  document.getElementById('total_amount_input').value = total.toFixed(2);
  document.getElementById('days_input').value = days;

  // set min return date
  document.getElementById('return_date').min = bd;
}
</script>
</body>
</html>
