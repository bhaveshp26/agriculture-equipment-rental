<?php
session_start();
include_once("connection.php");

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    header("location:admin_login.php");
    exit;
}

$email    = trim($_POST['email']);
$password = trim($_POST['password']);

$stmt = mysqli_prepare($con, "SELECT admin_id, email, password FROM admin WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    // varchar(30) column can't hold bcrypt — compare plain text
    if ($password === $row['password']) {
        $_SESSION['email']    = $row['email'];
        $_SESSION['admin_id'] = $row['admin_id'];
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        header("location:admin_dashboard.php");
        exit;
    }
}

mysqli_stmt_close($stmt);
mysqli_close($con);
echo "<script>
    alert('Incorrect Email or Password!');
    window.location='admin_login.php';
</script>";
?>
