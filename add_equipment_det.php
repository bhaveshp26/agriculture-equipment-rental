<?php
include_once("connection.php");

// Auto-fix equipments table column sizes if needed
mysqli_query($con, "ALTER TABLE `equipments` MODIFY `eq_id` VARCHAR(50) NOT NULL");
mysqli_query($con, "ALTER TABLE `equipments` MODIFY `description` VARCHAR(500) DEFAULT NULL");

if (!isset($_POST['id'], $_POST['ename'], $_POST['etype'], $_POST['price'],
           $_POST['status'], $_POST['description'])) {
    echo "<script>alert('Missing required fields'); window.location='add_equipment.php';</script>";
    exit;
}

$eq_id       = trim($_POST['id']);
$name        = trim($_POST['ename']);
$eq_type     = trim($_POST['etype']);
$rent_price  = trim($_POST['price']);
$status      = trim($_POST['status']);
$description = trim($_POST['description']);
$filepath    = "";

// Handle file upload
if (!empty($_FILES['id_photo']['name'])) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $max_size      = 5 * 1024 * 1024; // 5 MB

    $file_type = mime_content_type($_FILES['id_photo']['tmp_name']);
    $file_size = $_FILES['id_photo']['size'];

    if (!in_array($file_type, $allowed_types)) {
        echo "<script>alert('Invalid file type. Only JPG, PNG, GIF, WEBP allowed.'); window.location='add_equipment.php';</script>";
        exit;
    }
    if ($file_size > $max_size) {
        echo "<script>alert('File too large. Max 5MB allowed.'); window.location='add_equipment.php';</script>";
        exit;
    }

    $upload_dir = "images/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $safe_name = uniqid() . "_" . basename($_FILES['id_photo']['name']);
    $dest      = $upload_dir . $safe_name;

    if (move_uploaded_file($_FILES['id_photo']['tmp_name'], $dest)) {
        $filepath = $dest;
    } else {
        echo "<script>alert('File upload failed. Please try again.'); window.location='add_equipment.php';</script>";
        exit;
    }
}

$stmt = mysqli_prepare($con,
    "INSERT INTO equipments (eq_id, name, eq_type, rent_price, status, eq_img, description)
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);
mysqli_stmt_bind_param($stmt, "sssssss", $eq_id, $name, $eq_type, $rent_price, $status, $filepath, $description);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Equipment added successfully!');
        window.location='view_equipment.php';
    </script>";
} else {
    $err = mysqli_error($con);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    echo "<script>
        alert('Failed to add equipment: " . addslashes($err) . "');
        window.location='add_equipment.php';
    </script>";
}
?>
