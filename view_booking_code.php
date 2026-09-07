<?php
session_start();
include_once("connection.php");

if (!isset($_GET['temail'])) {
    header("location:user_dashboard.php");
    exit;
}

$email = trim($_GET['temail']);

// Auto-fix booking table structure if it has wrong columns
$cols = [];
$res = mysqli_query($con, "SHOW COLUMNS FROM booking");
if ($res) {
    while ($col = mysqli_fetch_assoc($res)) {
        $cols[] = $col['Field'];
    }
}
// If old renthouse structure, recreate it
if (!in_array('email', $cols)) {
    mysqli_query($con, "DROP TABLE IF EXISTS `booking`");
    mysqli_query($con, "CREATE TABLE `booking` (
        `booking_id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(100) DEFAULT NULL,
        `id` varchar(50) DEFAULT NULL,
        `eq_type` varchar(50) DEFAULT NULL,
        `email` varchar(100) DEFAULT NULL,
        `price` varchar(50) DEFAULT NULL,
        `time` varchar(20) DEFAULT NULL,
        `booking_date` date DEFAULT NULL,
        `return_date` date DEFAULT NULL,
        PRIMARY KEY (`booking_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1");
}
?>
<!DOCTYPE html>
<html>
<head>
<link href="bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" media="all"/>
<style>
body { background-color: #f5f5f5; }
.container { width: 95%; margin: 20px auto; background-color: white; padding: 15px; border-radius: 8px; }
</style>
</head>
<body>
<div class="container">
<h4>My Bookings</h4>
<?php
$stmt = mysqli_prepare($con, "SELECT * FROM booking WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$results = mysqli_stmt_get_result($stmt);

if (!$results || mysqli_num_rows($results) === 0) {
    echo "<p>No bookings found for this account.</p>";
} else {
?>
<table class="table table-bordered table-hover">
<thead class="thead-dark">
<tr>
  <th>Name</th><th>Eq ID</th><th>Type</th><th>Email</th>
  <th>Price</th><th>Time</th><th>Booking Date</th><th>Return Date</th><th>Cancel</th>
</tr>
</thead>
<tbody>
<?php while ($row = mysqli_fetch_assoc($results)): ?>
<tr>
  <td><?php echo htmlspecialchars($row['name']); ?></td>
  <td><?php echo htmlspecialchars($row['id']); ?></td>
  <td><?php echo htmlspecialchars($row['eq_type']); ?></td>
  <td><?php echo htmlspecialchars($row['email']); ?></td>
  <td><?php echo htmlspecialchars($row['price']); ?></td>
  <td><?php echo htmlspecialchars($row['time']); ?></td>
  <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
  <td><?php echo htmlspecialchars($row['return_date']); ?></td>
  <td><a href="booking_profile_del.php?tmail=<?php echo urlencode($row['email']); ?>"><button class="btn btn-danger btn-sm">Cancel</button></a></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<?php } mysqli_stmt_close($stmt); mysqli_close($con); ?>
</div>
</body>
</html>
