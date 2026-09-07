<?php
session_start();
include_once("connection.php");

if (!isset($_POST['name'], $_POST['id'], $_POST['etype'], $_POST['email'],
           $_POST['price'], $_POST['time'], $_POST['date'], $_POST['rdate'])) {
    header("location:user_view_eq.php");
    exit;
}

// Block admin — only user_reg accounts can book
$chk = mysqli_prepare($con, "SELECT user_id FROM user_reg WHERE email = ?");
mysqli_stmt_bind_param($chk, "s", $_POST['email']);
mysqli_stmt_execute($chk);
mysqli_stmt_store_result($chk);
if (mysqli_stmt_num_rows($chk) === 0) {
    mysqli_stmt_close($chk);
    echo "<script>alert('Only registered users can book equipment. Admins are not allowed.'); window.location='user_view_eq.php';</script>";
    exit;
}
mysqli_stmt_close($chk);

// Auto-upgrade booking table with new columns if missing
$cols = [];
$res = mysqli_query($con, "SHOW COLUMNS FROM booking");
while ($col = mysqli_fetch_assoc($res)) $cols[] = $col['Field'];
if (!in_array('status', $cols))        mysqli_query($con, "ALTER TABLE booking ADD COLUMN `status` VARCHAR(20) DEFAULT 'Active'");
if (!in_array('total_amount', $cols))  mysqli_query($con, "ALTER TABLE booking ADD COLUMN `total_amount` DECIMAL(10,2) DEFAULT 0");
if (!in_array('days', $cols))          mysqli_query($con, "ALTER TABLE booking ADD COLUMN `days` INT DEFAULT 1");
if (!in_array('booked_at', $cols))     mysqli_query($con, "ALTER TABLE booking ADD COLUMN `booked_at` DATETIME DEFAULT CURRENT_TIMESTAMP");

$name         = trim($_POST['name']);
$id           = trim($_POST['id']);
$etype        = trim($_POST['etype']);
$email        = trim($_POST['email']);
$price        = trim($_POST['price']);
$time         = trim($_POST['time']);
$booking_date = trim($_POST['date']);
$return_date  = trim($_POST['rdate']);
$total_amount = isset($_POST['total_amount']) ? (float)$_POST['total_amount'] : 0;
$days         = isset($_POST['days']) ? (int)$_POST['days'] : 1;
$booked_at    = date('Y-m-d H:i:s');
$status       = 'Active';

// Validate dates
if ($return_date <= $booking_date) {
    echo "<script>alert('Return date must be after booking date'); history.back();</script>";
    exit;
}

$stmt = mysqli_prepare($con,
    "INSERT INTO booking (name, id, eq_type, email, price, time, booking_date, return_date, status, total_amount, days, booked_at)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);
mysqli_stmt_bind_param($stmt, "sssssssssdis",
    $name, $id, $etype, $email, $price, $time,
    $booking_date, $return_date, $status, $total_amount, $days, $booked_at
);

if (mysqli_stmt_execute($stmt)) {
    $booking_id = mysqli_insert_id($con);

    // Update equipment status to Booked
    $upd = mysqli_prepare($con, "UPDATE equipments SET status='Booked' WHERE eq_id=?");
    mysqli_stmt_bind_param($upd, "s", $id);
    mysqli_stmt_execute($upd);
    mysqli_stmt_close($upd);

    mysqli_stmt_close($stmt);
    mysqli_close($con);
    header("location:bill.php?bid=" . $booking_id);
    exit;
} else {
    $err = mysqli_error($con);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Booking failed: " . addslashes($err) . "');
        history.back();
    </script>";
}
?>
