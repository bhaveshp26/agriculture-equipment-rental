<?php
session_start();
include_once("connection.php");

if (!isset($_GET['temail'])) {
    header("location:user_dashboard.php");
    exit;
}

$email = trim($_GET['temail']);
?>
<!DOCTYPE html>
<html>
<head>
<link href="bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" media="all"/>
<style>
body { background-color: #f5f5f5; }
.container { width: 90%; margin: 20px auto; background-color: white; padding: 15px; border-radius: 8px; }
</style>
</head>
<body>
<div class="container">
<h4>User Profile</h4>
<?php
$stmt = mysqli_prepare($con, "SELECT user_id, name, email, contact, address FROM user_reg WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$results = mysqli_stmt_get_result($stmt);

if (!$results || mysqli_num_rows($results) === 0) {
    echo "<p>User not found.</p>";
} else {
?>
<table class="table table-bordered table-hover">
<thead class="thead-dark">
<tr>
  <th>User ID</th><th>Name</th><th>Email</th><th>Contact</th><th>Address</th><th>Edit</th><th>Delete</th>
</tr>
</thead>
<tbody>
<?php while ($row = mysqli_fetch_assoc($results)): ?>
<tr>
  <td><?php echo htmlspecialchars($row['user_id']); ?></td>
  <td><?php echo htmlspecialchars($row['name']); ?></td>
  <td><?php echo htmlspecialchars($row['email']); ?></td>
  <td><?php echo htmlspecialchars($row['contact']); ?></td>
  <td><?php echo htmlspecialchars($row['address']); ?></td>
  <td><a href="user_profile_upd.php?tmail=<?php echo urlencode($row['email']); ?>"><button class="btn btn-success btn-sm">Edit</button></a></td>
  <td><a href="user_profile_del.php?tmail=<?php echo urlencode($row['email']); ?>"><button class="btn btn-danger btn-sm">Delete</button></a></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<?php } mysqli_stmt_close($stmt); mysqli_close($con); ?>
</div>
</body>
</html>
