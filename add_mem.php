<?php
include_once("connection.php");

// Add name column to admin if missing (compatible with older MySQL)
$check = mysqli_query($con, "SHOW COLUMNS FROM `admin` LIKE 'name'");
if (mysqli_num_rows($check) === 0) {
    mysqli_query($con, "ALTER TABLE `admin` ADD COLUMN `name` VARCHAR(100) DEFAULT NULL");
}
mysqli_query($con, "ALTER TABLE `admin` MODIFY `email` VARCHAR(100) DEFAULT NULL");
mysqli_query($con, "ALTER TABLE `admin` MODIFY `password` VARCHAR(255) DEFAULT NULL");

if (!isset($_POST['name'], $_POST['email'], $_POST['password'])) {
    header("location:add_member.php");
    exit;
}

$name     = trim($_POST['name']);
$email    = trim($_POST['email']);
$password = trim($_POST['password']);

$stmt = mysqli_prepare($con, "INSERT INTO admin (name, email, password) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Registered Successfully');
        window.location='view_admin.php';
    </script>";
} else {
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Registration Failed: " . mysqli_error($con) . "');
        window.location='add_member.php';
    </script>";
}
?>
