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
img { border-radius: 4px; }
</style>
</head>
<body>
<div class="container">
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
  <h4>Equipment List</h4>
  <a href="add_equipment.php"><button class="btn btn-warning">+ Add New Equipment</button></a>
</div>
<?php
$results = mysqli_query($con, "SELECT * FROM equipments");
if (!$results || mysqli_num_rows($results) === 0) {
    echo "<p>No equipment found.</p>";
} else {
?>
<table class="table table-bordered table-hover">
<thead class="thead-dark">
<tr>
  <th>ID</th><th>Name</th><th>Type</th><th>Rent Price</th>
  <th>Status</th><th>Image</th><th>Description</th>
  <th>Edit</th><th>Delete</th>
</tr>
</thead>
<tbody>
<?php while ($row = mysqli_fetch_assoc($results)): ?>
<tr>
  <td><?php echo htmlspecialchars($row['eq_id']); ?></td>
  <td><?php echo htmlspecialchars($row['name']); ?></td>
  <td><?php echo htmlspecialchars($row['eq_type']); ?></td>
  <td><?php echo htmlspecialchars($row['rent_price']); ?></td>
  <td><?php echo htmlspecialchars($row['status']); ?></td>
  <td><?php if (!empty($row['eq_img'])): ?><img src="<?php echo htmlspecialchars($row['eq_img']); ?>" height="80" width="80"><?php endif; ?></td>
  <td><?php echo htmlspecialchars($row['description']); ?></td>
  <td><a href="eq_profile_upd.php?tid=<?php echo urlencode($row['eq_id']); ?>"><button class="btn btn-success btn-sm">Edit</button></a></td>
  <td><a href="eq_profile_del.php?tid=<?php echo urlencode($row['eq_id']); ?>"><button class="btn btn-danger btn-sm">Delete</button></a></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<?php } mysqli_close($con); ?>
</div>
</body>
</html>
