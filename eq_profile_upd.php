<?php
include_once("connection.php");
if (!isset($_GET['tid'])) {
    header("location:view_equipment.php");
    exit;
}
$tid = trim($_GET['tid']);
$stmt = mysqli_prepare($con, "SELECT * FROM equipments WHERE eq_id = ?");
mysqli_stmt_bind_param($stmt, "s", $tid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
if (!$row) {
    echo "<script>alert('Equipment not found'); window.location='view_equipment.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<link href="bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" media="all"/>
<style>
body { background-image:url('/agriculture/images/bg1.webp'); background-size:100% 100%; }
.container { height:720px; width:600px; background-color:white; border-radius:10px; }
.thin-line-input { border:none; border-bottom:1px solid #ccc; padding:5px; width:500px; }
</style>
</head>
<body>
<form action='eq_profile_upd_code.php' method='post'>
<br><br>
<div class='container'><br>
<h5>UPDATE - EQUIPMENT</h5><br>
<b>ID</b><br>
<input type='text' class='thin-line-input' value='<?php echo htmlspecialchars($row['eq_id']); ?>' name='id' readonly required><br><br>
<b>Name</b><br>
<input type='text' class='thin-line-input' value='<?php echo htmlspecialchars($row['name']); ?>' name='ename' required><br><br>
<b>Type</b><br>
<input type='text' class='thin-line-input' value='<?php echo htmlspecialchars($row['eq_type']); ?>' name='etype' required><br><br>
<b>Price</b><br>
<input type='text' class='thin-line-input' value='<?php echo htmlspecialchars($row['rent_price']); ?>' name='price'><br><br>
<b>Status</b><br>
<input type='text' class='thin-line-input' value='<?php echo htmlspecialchars($row['status']); ?>' name='status'><br><br>
<b>Description</b><br>
<input type='text' class='thin-line-input' value='<?php echo htmlspecialchars($row['description']); ?>' name='description'><br><br>
<button type='submit' class='btn btn-success'>UPDATE CONFIRM</button>
</div>
</form>
</body>
</html>