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
<h4>User List</h4>
<?php
$results = mysqli_query($con, "SELECT user_id, name, email, contact, address FROM user_reg");
if (!$results || mysqli_num_rows($results) === 0) {
    echo "<p>No users found.</p>";
} else {
?>
<table class="table table-bordered table-hover">
<thead class="thead-dark">
<tr>
  <th>User ID</th><th>Name</th><th>Email</th><th>Contact</th><th>Address</th>
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
</tr>
<?php endwhile; ?>
</tbody>
</table>
<?php } mysqli_close($con); ?>
</div>
</body>
</html>
