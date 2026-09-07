<?php
include_once("connection.php");

if (!isset($_POST['name'], $_POST['email'])) {
    header("location:view_admin.php");
    exit;
}

$name  = trim($_POST['name']);
$email = trim($_POST['email']);

// Only update password if a new one was provided
if (!empty(trim($_POST['password']))) {
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($con, "UPDATE admin SET name = ?, password = ? WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "sss", $name, $password, $email);
} else {
    $stmt = mysqli_prepare($con, "UPDATE admin SET name = ? WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "ss", $name, $email);
}

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Profile updated successfully');
        window.location='view_admin.php';
    </script>";
} else {
    $err = mysqli_error($con);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Update failed: " . addslashes($err) . "');
        window.location='view_admin.php';
    </script>";
}
?>
