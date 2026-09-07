<?php
include_once("connection.php");

if (!isset($_POST['email'], $_POST['password1'], $_POST['password2'])) {
    header("location:forget_passoword.php");
    exit;
}

$email = trim($_POST['email']);
$pass1 = trim($_POST['password1']);
$pass2 = trim($_POST['password2']);

if ($pass1 !== $pass2) {
    echo "<script>
        alert('Passwords do not match');
        window.location='forget_passoword.php';
    </script>";
    exit;
}

// Check if user exists
$check = mysqli_prepare($con, "SELECT user_id FROM user_reg WHERE email = ?");
mysqli_stmt_bind_param($check, "s", $email);
mysqli_stmt_execute($check);
mysqli_stmt_store_result($check);

if (mysqli_stmt_num_rows($check) === 0) {
    mysqli_stmt_close($check);
    mysqli_close($con);
    echo "<script>
        alert('No account found with that email');
        window.location='forget_passoword.php';
    </script>";
    exit;
}
mysqli_stmt_close($check);

$new_password = password_hash($pass1, PASSWORD_DEFAULT);

$stmt = mysqli_prepare($con, "UPDATE user_reg SET password = ?, confirm_password = ? WHERE email = ?");
mysqli_stmt_bind_param($stmt, "sss", $new_password, $new_password, $email);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Password updated successfully. Please login.');
        window.location='user_login.php';
    </script>";
} else {
    $err = mysqli_error($con);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Failed to update password: " . addslashes($err) . "');
        window.location='forget_passoword.php';
    </script>";
}
?>
