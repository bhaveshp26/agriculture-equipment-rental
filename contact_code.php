<?php
include_once("connection.php");

if (!isset($_POST['name'], $_POST['email'], $_POST['contact'], $_POST['message'])) {
    header("location:contact.php");
    exit;
}

$name    = trim($_POST['name']);
$email   = trim($_POST['email']);
$contact = trim($_POST['contact']);
$message = trim($_POST['message']);

$stmt = mysqli_prepare($con, "INSERT INTO contact (name, email, contact, message) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $contact, $message);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('We will contact you as soon as possible');
        window.location='contact.php';
    </script>";
} else {
    $err = mysqli_error($con);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Error submitting form. Please try again.');
        window.location='contact.php';
    </script>";
}
?>
