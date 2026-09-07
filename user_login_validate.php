<?php
session_start();
include_once("connection.php");

if (!isset($_POST['email']) || !isset($_POST['password1'])) {
    header("location:user_login.php");
    exit;
}

$email    = trim($_POST['email']);
$password = trim($_POST['password1']);

$stmt = mysqli_prepare($con, "SELECT * FROM user_reg WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    if ($password === $row['password']) {
        $_SESSION['email'] = $row['email'];
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        header("location:user_dashboard.php?tid=" . urlencode($row['email']));
        exit;
    }
}

mysqli_stmt_close($stmt);
mysqli_close($con);
echo "<script>
    alert('Incorrect Email or Password');
    window.location='user_login.php';
</script>";
?>
