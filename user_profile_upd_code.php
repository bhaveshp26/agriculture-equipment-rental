<?php
include_once("connection.php");

if (!isset($_POST['name'], $_POST['email'])) {
    header("location:user_dashboard.php");
    exit;
}

$name    = trim($_POST['name']);
$email   = trim($_POST['email']);
$contact = trim($_POST['contact']);
$address = trim($_POST['address']);

if (!empty(trim($_POST['password1']))) {
    $pass1 = trim($_POST['password1']);
    $pass2 = trim($_POST['password2']);
    if ($pass1 !== $pass2) {
        echo "<script>
            alert('Passwords do not match');
            history.back();
        </script>";
        exit;
    }
    $password = password_hash($pass1, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($con,
        "UPDATE user_reg SET name=?, password=?, confirm_password=?, contact=?, address=? WHERE email=?"
    );
    mysqli_stmt_bind_param($stmt, "ssssss", $name, $password, $password, $contact, $address, $email);
} else {
    $stmt = mysqli_prepare($con,
        "UPDATE user_reg SET name=?, contact=?, address=? WHERE email=?"
    );
    mysqli_stmt_bind_param($stmt, "ssss", $name, $contact, $address, $email);
}

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Updated successfully');
        window.location='user_dashboard.php?tid=" . urlencode($email) . "';
    </script>";
} else {
    $err = mysqli_error($con);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Update failed: " . addslashes($err) . "');
        history.back();
    </script>";
}
?>
