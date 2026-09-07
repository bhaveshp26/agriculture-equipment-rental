<?php
include_once("connection.php");

if (!isset($_POST['id'], $_POST['ename'], $_POST['etype'])) {
    header("location:view_equipment.php");
    exit;
}

$eq_id       = trim($_POST['id']);
$name        = trim($_POST['ename']);
$eq_type     = trim($_POST['etype']);
$rent_price  = trim($_POST['price']);
$status      = trim($_POST['status']);
$description = trim($_POST['description']);

$stmt = mysqli_prepare($con,
    "UPDATE equipments SET name=?, eq_type=?, rent_price=?, status=?, description=? WHERE eq_id=?"
);
mysqli_stmt_bind_param($stmt, "ssssss", $name, $eq_type, $rent_price, $status, $description, $eq_id);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Updated successfully');
        window.location='view_equipment.php';
    </script>";
} else {
    $err = mysqli_error($con);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Update failed: " . addslashes($err) . "');
        window.location='view_equipment.php';
    </script>";
}
?>
