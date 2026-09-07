<?php
include_once("connection.php");

if (!isset($_POST['email'])) {
    header("location:view_admin.php");
    exit;
}

$email = trim($_POST['email']);

$stmt = mysqli_prepare($con, "DELETE FROM admin WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Deleted successfully');
        window.location='view_admin.php';
    </script>";
} else {
    $err = mysqli_error($con);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Delete failed: " . addslashes($err) . "');
        window.location='view_admin.php';
    </script>";
}
?>
