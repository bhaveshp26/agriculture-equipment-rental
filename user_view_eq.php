<?php
session_start();
include_once("connection.php");

// Check if current user is admin (in admin table) or regular user
$is_admin = false;
if (isset($_SESSION['email'])) {
    $chk = mysqli_prepare($con, "SELECT admin_id FROM admin WHERE email = ?");
    mysqli_stmt_bind_param($chk, "s", $_SESSION['email']);
    mysqli_stmt_execute($chk);
    mysqli_stmt_store_result($chk);
    $is_admin = mysqli_stmt_num_rows($chk) > 0;
    mysqli_stmt_close($chk);
}
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
<h4>Available Equipment</h4>
<?php
$results = mysqli_query($con, "SELECT * FROM equipments");
if (!$results || mysqli_num_rows($results) === 0) {
    echo "<p>No equipment available.</p>";
} else {
?>
<table class="table table-bordered table-hover">
<thead class="thead-dark">
<tr>
  <th>ID</th><th>Name</th><th>Type</th><th>Rent Price</th>
  <th>Status</th><th>Image</th><th>Description</th>
  <?php if (!$is_admin): ?><th>Book</th><?php endif; ?>
</tr>
</thead>
<tbody>
<?php while ($row = mysqli_fetch_assoc($results)): ?>
<tr>
  <td><?php echo htmlspecialchars($row['eq_id']); ?></td>
  <td><?php echo htmlspecialchars($row['name']); ?></td>
  <td><?php echo htmlspecialchars($row['eq_type']); ?></td>
  <td><?php echo htmlspecialchars($row['rent_price']); ?></td>
  <td>
    <?php
      $status = strtolower($row['status']);
      if ($status === 'available') {
          echo '<span style="background:#e8f5e9; color:#1a6b1a; padding:4px 12px; border-radius:20px; font-size:0.78rem; font-weight:700;">✔ Available</span>';
      } else {
          echo '<span style="background:#fdecea; color:#c62828; padding:4px 12px; border-radius:20px; font-size:0.78rem; font-weight:700;">✘ ' . htmlspecialchars($row['status']) . '</span>';
      }
    ?>
  </td>
  <td><?php if (!empty($row['eq_img'])): ?><img src="<?php echo htmlspecialchars($row['eq_img']); ?>" width="80" height="80"><?php endif; ?></td>
  <td><?php echo htmlspecialchars($row['description']); ?></td>
  <?php if (!$is_admin): ?>
  <td>
    <?php if ($status === 'available'): ?>
      <a href="booking.php?tid=<?php echo urlencode($row['eq_id']); ?>">
        <button class="btn btn-success btn-sm"><i class="fas fa-calendar-plus me-1"></i>Book</button>
      </a>
    <?php else: ?>
      <button class="btn btn-secondary btn-sm" disabled title="Already booked by another user">
        <i class="fas fa-lock me-1"></i>Booked
      </button>
    <?php endif; ?>
  </td>
  <?php endif; ?>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<?php } mysqli_close($con); ?>
</div>
</body>
</html>
