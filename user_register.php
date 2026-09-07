<?php
include_once("connection.php");

// Fix column types if not already done
mysqli_query($con, "ALTER TABLE `user_reg` MODIFY `contact` VARCHAR(20) DEFAULT NULL");
mysqli_query($con, "ALTER TABLE `user_reg` MODIFY `password` VARCHAR(255) DEFAULT NULL");
mysqli_query($con, "ALTER TABLE `user_reg` MODIFY `confirm_password` VARCHAR(255) DEFAULT NULL");
mysqli_query($con, "ALTER TABLE `user_reg` MODIFY `email` VARCHAR(100) DEFAULT NULL");

if (!isset($_POST['name'], $_POST['email'], $_POST['password1'], $_POST['password2'], $_POST['phone_no'], $_POST['address'])) {
    header("location:how-to-register.php");
    exit;
}

$name     = trim($_POST['name']);
$email    = trim($_POST['email']);
$pass1    = trim($_POST['password1']);
$pass2    = trim($_POST['password2']);
$phone    = trim($_POST['phone_no']);
$address  = trim($_POST['address']);

if ($pass1 !== $pass2) {
    echo "<script>
        alert('Passwords do not match');
        window.location='how-to-register.php';
    </script>";
    exit;
}

$password = trim($pass1); // stored as plain text to match varchar(30) column

$stmt = mysqli_prepare($con,
    "INSERT INTO user_reg (name, email, password, confirm_password, contact, address) VALUES (?, ?, ?, ?, ?, ?)"
);
mysqli_stmt_bind_param($stmt, "ssssss", $name, $email, $password, $pass2, $phone, $address);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Registered Successfully');
        window.location='user_login.php';
    </script>";
} else {
    $err = mysqli_error($con);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Registration Failed. Email may already be in use.');
        window.location='how-to-register.php';
    </script>";
}
?>
