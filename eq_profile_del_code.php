<?php
include_once("connection.php");

if (!isset($_POST['id'])) {
    header("location:view_equipment.php");
    exit;
}

$eq_id = trim($_POST['id']);

$stmt = mysqli_prepare($con, "DELETE FROM equipments WHERE eq_id = ?");
mysqli_stmt_bind_param($stmt, "s", $eq_id);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Equipment deleted successfully');
        window.location='view_equipment.php';
    </script>";
} else {
    $err = mysqli_error($con);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Delete failed: " . addslashes($err) . "');
        window.location='view_equipment.php';
    </script>";
}
?>
