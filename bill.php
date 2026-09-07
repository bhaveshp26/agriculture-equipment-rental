<?php
session_start();
include_once("connection.php");

if (!isset($_GET['bid'])) { header("location:user_dashboard.php"); exit; }

// Block admin from viewing bills
if (isset($_SESSION['email'])) {
    $chk = mysqli_prepare($con, "SELECT admin_id FROM admin WHERE email = ?");
    mysqli_stmt_bind_param($chk, "s", $_SESSION['email']);
    mysqli_stmt_execute($chk);
    mysqli_stmt_store_result($chk);
    if (mysqli_stmt_num_rows($chk) > 0) {
        mysqli_stmt_close($chk);
        echo "<!DOCTYPE html><html><head>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        </head><body style='background:#f0faf0; font-family:Poppins,sans-serif;'>
        <div style='max-width:480px; margin:80px auto; background:#fff; border-radius:16px; padding:40px; box-shadow:0 10px 40px rgba(0,0,0,0.1); text-align:center;'>
        <div style='font-size:4rem; margin-bottom:15px;'>🚫</div>
        <h4 style='color:#c62828; font-weight:700;'>Access Denied</h4>
        <p style='color:#666;'>Billing details are private and only visible to the user who made the booking.</p>
        <a href='view_booking.php' style='display:inline-block; margin-top:15px; background:linear-gradient(135deg,#1a6b1a,#4caf50); color:#fff; padding:11px 30px; border-radius:25px; text-decoration:none; font-weight:600;'>
        View All Bookings</a>
        </div></body></html>";
        exit;
    }
    mysqli_stmt_close($chk);
}

$bid = (int)$_GET['bid'];
$stmt = mysqli_prepare($con, "SELECT * FROM booking WHERE booking_id = ?");
mysqli_stmt_bind_param($stmt, "i", $bid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$b = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$b) { echo "<script>alert('Booking not found'); window.location='user_dashboard.php';</script>"; exit; }

$subtotal = $b['days'] * (float)$b['price'];
$gst      = $subtotal * 0.18;
$total    = $subtotal + $gst;
$booked_at = date('d M Y, h:i A', strtotime($b['booked_at']));
$booking_date = date('d M Y', strtotime($b['booking_date']));
$return_date  = date('d M Y', strtotime($b['return_date']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Booking Bill - AgriRent</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    * { font-family: 'Poppins', sans-serif; }
    body { background: #f0faf0; }
    .bill-wrapper { max-width: 780px; margin: 30px auto; padding: 0 15px; }
    .bill-card { background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); overflow: hidden; }
    .bill-header { background: linear-gradient(135deg, #1a6b1a, #4caf50); padding: 35px 40px; color: #fff; }
    .bill-header .logo { font-size: 2rem; font-weight: 800; }
    .bill-header .logo span { color: #d4f7d4; }
    .bill-header .invoice-no { background: rgba(255,255,255,0.2); padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; display: inline-block; margin-top: 8px; }
    .bill-body { padding: 35px 40px; }
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 30px; }
    .info-block h6 { color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
    .info-block p { color: #222; font-weight: 600; margin: 0; font-size: 0.95rem; }
    .bill-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .bill-table thead tr { background: #f0faf0; }
    .bill-table th { padding: 12px 15px; text-align: left; font-size: 0.8rem; text-transform: uppercase; color: #555; letter-spacing: 0.5px; }
    .bill-table td { padding: 14px 15px; border-bottom: 1px solid #f0f0f0; font-size: 0.9rem; }
    .bill-total-section { background: #f0faf0; border-radius: 12px; padding: 20px 25px; }
    .total-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 0.9rem; color: #555; }
    .total-row.final { border-top: 2px solid #4caf50; margin-top: 10px; padding-top: 12px; font-size: 1.1rem; font-weight: 800; color: #1a6b1a; }
    .status-pill { padding: 6px 18px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; display: inline-block; }
    .status-active { background: #e8f5e9; color: #1a6b1a; border: 1.5px solid #4caf50; }
    .status-cancelled { background: #fdecea; color: #c62828; border: 1.5px solid #ef5350; }
    .status-completed { background: #e3f2fd; color: #1565c0; border: 1.5px solid #42a5f5; }
    .watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%) rotate(-30deg); font-size: 6rem; font-weight: 900; color: rgba(76,175,80,0.06); pointer-events: none; white-space: nowrap; }
    .bill-footer { border-top: 2px dashed #c8e6c9; padding: 20px 40px; text-align: center; color: #888; font-size: 0.85rem; }
    .btn-print { background: linear-gradient(135deg, #4caf50, #1a6b1a); border: none; color: #fff; padding: 11px 30px; border-radius: 25px; font-weight: 600; }
    .btn-back { border: 2px solid #4caf50; color: #1a6b1a; padding: 11px 30px; border-radius: 25px; font-weight: 600; background: transparent; }
    @media print {
      body { background: #fff; }
      .no-print { display: none !important; }
      .bill-card { box-shadow: none; border-radius: 0; }
    }
  </style>
</head>
<body>
<div class="bill-wrapper">

  <!-- Action buttons -->
  <div class="d-flex justify-content-between align-items-center mb-3 no-print">
    <a href="view_booking_code.php?temail=<?php echo urlencode($b['email']); ?>" class="btn btn-back"><i class="fas fa-arrow-left me-2"></i>My Bookings</a>
    <button onclick="window.print()" class="btn btn-print"><i class="fas fa-print me-2"></i>Print / Save PDF</button>
  </div>

  <div class="bill-card" style="position:relative;">
    <div class="watermark">AgriRent</div>

    <!-- Header -->
    <div class="bill-header">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="logo"><i class="fas fa-tractor me-2"></i>Agri<span>Rent</span></div>
          <div style="opacity:0.8; font-size:0.85rem; margin-top:4px;">Agriculture Equipment Rental Platform</div>
          <div class="invoice-no"><i class="fas fa-hashtag me-1"></i>Invoice #AGR-<?php echo str_pad($b['booking_id'], 5, '0', STR_PAD_LEFT); ?></div>
        </div>
        <div style="text-align:right;">
          <div style="font-size:0.85rem; opacity:0.8;">Booking Status</div>
          <?php
            $s = strtolower($b['status'] ?? 'active');
            $cls = $s === 'cancelled' ? 'status-cancelled' : ($s === 'completed' ? 'status-completed' : 'status-active');
          ?>
          <span class="status-pill <?php echo $cls; ?> mt-1 d-inline-block"><?php echo htmlspecialchars($b['status'] ?? 'Active'); ?></span>
          <div style="font-size:0.8rem; opacity:0.75; margin-top:8px;"><i class="fas fa-clock me-1"></i><?php echo $booked_at; ?></div>
        </div>
      </div>
    </div>

    <div class="bill-body">
      <!-- Customer & Booking Info -->
      <div class="info-grid">
        <div>
          <div class="info-block mb-3">
            <h6><i class="fas fa-user me-1"></i>Billed To</h6>
            <p><?php echo htmlspecialchars($b['name']); ?></p>
            <p style="font-weight:400; color:#666; font-size:0.85rem;"><?php echo htmlspecialchars($b['email']); ?></p>
          </div>
        </div>
        <div>
          <div class="info-block mb-3">
            <h6><i class="fas fa-calendar me-1"></i>Booking Period</h6>
            <p><?php echo $booking_date; ?> → <?php echo $return_date; ?></p>
            <p style="font-weight:400; color:#666; font-size:0.85rem;"><?php echo $b['days']; ?> day(s) | Pickup: <?php echo htmlspecialchars($b['time']); ?></p>
          </div>
        </div>
      </div>

      <!-- Equipment Table -->
      <table class="bill-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Equipment</th>
            <th>Type</th>
            <th>Rate/Day</th>
            <th>Days</th>
            <th style="text-align:right;">Amount</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td><strong><?php echo htmlspecialchars($b['eq_type']); ?></strong><br><small class="text-muted">ID: <?php echo htmlspecialchars($b['id']); ?></small></td>
            <td><?php echo htmlspecialchars($b['eq_type']); ?></td>
            <td>₹<?php echo number_format((float)$b['price'], 2); ?></td>
            <td><?php echo $b['days']; ?></td>
            <td style="text-align:right; font-weight:600;">₹<?php echo number_format($subtotal, 2); ?></td>
          </tr>
        </tbody>
      </table>

      <!-- Totals -->
      <div class="row">
        <div class="col-md-5 ms-auto">
          <div class="bill-total-section">
            <div class="total-row"><span>Subtotal</span><span>₹<?php echo number_format($subtotal, 2); ?></span></div>
            <div class="total-row"><span>GST (18%)</span><span>₹<?php echo number_format($gst, 2); ?></span></div>
            <div class="total-row"><span>Discount</span><span>₹0.00</span></div>
            <div class="total-row final"><span><i class="fas fa-rupee-sign me-1"></i>Total Payable</span><span>₹<?php echo number_format($total, 2); ?></span></div>
          </div>
        </div>
      </div>
    </div>

    <div class="bill-footer">
      <p class="mb-1"><i class="fas fa-check-circle text-success me-2"></i>Thank you for choosing AgriRent. Happy farming!</p>
      <p class="mb-0" style="font-size:0.78rem;">For support: support@agrirent.in | This is a computer-generated bill</p>
    </div>
  </div>
</div>
</body>
</html>
