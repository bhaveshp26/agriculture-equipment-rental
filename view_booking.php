<?php
session_start();
include_once("connection.php");
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
<h4>All Bookings</h4>
<?php
$results = mysqli_query($con, "SELECT * FROM booking");
if (!$results || mysqli_num_rows($results) === 0) {
    echo "<p>No bookings found.</p>";
} else {
?>
<table class="table table-bordered table-hover">
<thead class="thead-dark">
<tr>
  <th>Name</th><th>Eq ID</th><th>Type</th><th>Email</th>
  <th>Price</th><th>Time</th><th>Booking Date</th><th>Return Date</th><th>Delete</th>
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
  <td><a href="booking_profile_del.php?tmail=<?php echo urlencode($row['email']); ?>"><button class="btn btn-danger btn-sm">Delete</button></a></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<?php } mysqli_close($con); ?>
</div>
</body>
</html>
