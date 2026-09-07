<?php
include_once("connection.php");
if (!isset($_GET['tmail'])) { header("location:view_admin.php"); exit; }
$tmail = trim($_GET['tmail']);
$stmt = mysqli_prepare($con, "SELECT * FROM admin WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $tmail);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
if (!$row) { echo "<script>alert('Admin not found'); window.location='view_admin.php';</script>"; exit; }
?>
<!DOCTYPE html>
<html>
<head>
<link href="bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" media="all"/>
<style>
body { background-image:url('/agriculture/images/bg1.webp'); background-size:100% 100%; }
.container { height:500px; width:500px; background-color:white; border-radius:10px; }
.thin-line-input { border:none; border-bottom:1px solid #ccc; padding:5px; width:400px; }
</style>
</head>
<body>
<form action='admin_profile_del_code.php' method='post'>
<br><br>
<div class='container'><br>
<h5>DELETE - PROFILE</h5><br>
<b>ID</b><br>
<input type='text' class='thin-line-input' value='<?php echo htmlspecialchars($row['admin_id']); ?>' name='id' readonly required><br><br>
<b>Email</b><br>
<input type='text' class='thin-line-input' value='<?php echo htmlspecialchars($row['email']); ?>' name='email' readonly required><br><br>
<button type='submit' class='btn btn-danger'>DELETE CONFIRM</button>
</div>
</form>
</body>
</html>