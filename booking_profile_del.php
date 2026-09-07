<?php
include_once("connection.php");
if (!isset($_GET['tmail'])) { header("location:user_dashboard.php"); exit; }
$tmail = trim($_GET['tmail']);
$bid   = isset($_GET['bid']) ? (int)$_GET['bid'] : 0;

if ($bid) {
    $stmt = mysqli_prepare($con, "SELECT * FROM booking WHERE booking_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $bid);
} else {
    $stmt = mysqli_prepare($con, "SELECT * FROM booking WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $tmail);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
if (!$row) { echo "<script>alert('Booking not found'); history.back();</script>"; exit; }
?>
<!DOCTYPE html>
<html>
<head>
<link href="bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" media="all"/>
<style>
body { background-image:url('/agriculture/images/bg1.webp'); background-size:100% 100%; }
.container { height:800px; width:600px; background-color:white; border-radius:10px; }
.thin-line-input { border:none; border-bottom:1px solid #ccc; padding:5px; width:500px; }
</style>
</head>
<body>
<form action='booking_profile_code.php' method='post'>
<input type='hidden' name='email' value='<?php echo htmlspecialchars($row['email']); ?>'>
<input type='hidden' name='bid' value='<?php echo htmlspecialchars($row['booking_id']); ?>'>
<br><br>
<div class='container'><br>
<h5>Booking - Cancel</h5><br>
<b>Name</b><br>
<input type='text' class='thin-line-input' value='<?php echo htmlspecialchars($row['name']); ?>' name='name' readonly required><br><br>
<b>Equipment ID</b><br>
<input type='text' class='thin-line-input' value='<?php echo htmlspecialchars($row['id']); ?>' name='id' readonly required><br><br>
<b>Type</b><br>
<input type='text' class='thin-line-input' value='<?php echo htmlspecialchars($row['eq_type']); ?>' name='etype' readonly required><br><br>
<b>Email</b><br>
<input type='text' class='thin-line-input' value='<?php echo htmlspecialchars($row['email']); ?>' name='email' readonly><br><br>
<b>Price</b><br>
<input type='text' class='thin-line-input' value='<?php echo htmlspecialchars($row['price']); ?>' name='price' readonly><br><br>
<b>Time</b><br>
<input type='text' class='thin-line-input' value='<?php echo htmlspecialchars($row['time']); ?>' name='time' readonly><br><br>
<b>Booking Date</b><br>
<input type='text' class='thin-line-input' value='<?php echo htmlspecialchars($row['booking_date']); ?>' name='date' readonly><br><br>
<b>Return Date</b><br>
<input type='text' class='thin-line-input' value='<?php echo htmlspecialchars($row['return_date']); ?>' name='rdate' readonly><br><br>
<button type='submit' class='btn btn-danger'>CANCEL CONFIRM</button>
</div>
</form>
</body>
</html>
