<?php
session_start();
include_once("connection.php");

// Add name column to admin if missing (compatible with older MySQL)
$check = mysqli_query($con, "SHOW COLUMNS FROM `admin` LIKE 'name'");
if (mysqli_num_rows($check) === 0) {
    mysqli_query($con, "ALTER TABLE `admin` ADD COLUMN `name` VARCHAR(100) DEFAULT NULL");
}
mysqli_query($con, "ALTER TABLE `admin` MODIFY `email` VARCHAR(100) DEFAULT NULL");
mysqli_query($con, "ALTER TABLE `admin` MODIFY `password` VARCHAR(255) DEFAULT NULL");
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
<h4>Admin List</h4>
<?php
$results = mysqli_query($con, "SELECT admin_id, name, email FROM admin");
if (!$results || mysqli_num_rows($results) === 0) {
    echo "<p>No admins found.</p>";
} else {
?>
<table class="table table-bordered table-hover">
<thead class="thead-dark">
<tr>
  <th>Admin ID</th><th>Name</th><th>Email</th>
  <th>Add Member</th><th>Edit</th><th>Delete</th>
</tr>
</thead>
<tbody>
<?php while ($row = mysqli_fetch_assoc($results)): ?>
<tr>
  <td><?php echo htmlspecialchars($row['admin_id']); ?></td>
  <td><?php echo htmlspecialchars($row['name'] ?? ''); ?></td>
  <td><?php echo htmlspecialchars($row['email']); ?></td>
  <td><a href="add_member.php"><button class="btn btn-warning btn-sm">Add</button></a></td>
  <td><a href="admin_profile_upd.php?tmail=<?php echo urlencode($row['email']); ?>"><button class="btn btn-success btn-sm">Edit</button></a></td>
  <td><a href="admin_profile_del.php?tmail=<?php echo urlencode($row['email']); ?>"><button class="btn btn-danger btn-sm">Delete</button></a></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<?php } mysqli_close($con); ?>
</div>
</body>
</html>
