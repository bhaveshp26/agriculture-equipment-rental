<?php
include_once("connection.php");

if (!isset($_POST['email'])) {
    header("location:how-to-register.php");
    exit;
}

$email = trim($_POST['email']);

$stmt = mysqli_prepare($con, "DELETE FROM user_reg WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Account deactivated successfully');
        window.location='how-to-register.php';
    </script>";
} else {
    $err = mysqli_error($con);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Deactivation failed: " . addslashes($err) . "');
        history.back();
    </script>";
}
?>
