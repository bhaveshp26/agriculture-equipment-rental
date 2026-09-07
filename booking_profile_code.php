<?php
include_once("connection.php");

if (!isset($_POST['email'])) {
    header("location:user_dashboard.php");
    exit;
}

$email = trim($_POST['email']);
$bid   = isset($_POST['bid']) ? (int)$_POST['bid'] : 0;

// Get equipment id to restore its status
if ($bid) {
    $s = mysqli_prepare($con, "SELECT id FROM booking WHERE booking_id = ?");
    mysqli_stmt_bind_param($s, "i", $bid);
    mysqli_stmt_execute($s);
    $r = mysqli_stmt_get_result($s);
    $row = mysqli_fetch_assoc($r);
    mysqli_stmt_close($s);
    if ($row) {
        $eq_id = $row['id'];
        $upd = mysqli_prepare($con, "UPDATE equipments SET status='Available' WHERE eq_id=?");
        mysqli_stmt_bind_param($upd, "s", $eq_id);
        mysqli_stmt_execute($upd);
        mysqli_stmt_close($upd);
    }
    $stmt = mysqli_prepare($con, "UPDATE booking SET status='Cancelled' WHERE booking_id=?");
    mysqli_stmt_bind_param($stmt, "i", $bid);
} else {
    $stmt = mysqli_prepare($con, "UPDATE booking SET status='Cancelled' WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
}

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Booking cancelled successfully');
        window.location='view_booking_code.php?temail=" . urlencode($email) . "';
    </script>";
} else {
    $err = mysqli_error($con);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Cancellation failed');
        history.back();
    </script>";
}
?>
