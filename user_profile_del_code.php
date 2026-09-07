<?php
include_once("connection.php");

if (!isset($_POST['email'])) {
    header("location:index.php");
    exit;
}

$email = trim($_POST['email']);

$stmt = mysqli_prepare($con, "DELETE FROM user_reg WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    session_start();
    session_destroy();
    echo "<script>
        alert('Account deleted successfully');
        window.location='index.php';
    </script>";
} else {
    $err = mysqli_error($con);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Delete failed: " . addslashes($err) . "');
        history.back();
    </script>";
}
?>
