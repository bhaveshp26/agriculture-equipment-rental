<?php
session_start();
include("config/config.php");

if (!isset($_SESSION["email"])) {
    die("User not logged in.");
}

if (!isset($_GET['owner_id'], $_GET['tenant_id'])) {
    die("Missing owner or tenant ID.");
}

$u_email   = $_SESSION["email"];
$owner_id  = intval($_GET['owner_id']);
$tenant_id = intval($_GET['tenant_id']);

// Determine sender type using prepared statements
$stmt_owner = mysqli_prepare($db, "SELECT owner_id FROM owner WHERE email = ?");
mysqli_stmt_bind_param($stmt_owner, "s", $u_email);
mysqli_stmt_execute($stmt_owner);
mysqli_stmt_store_result($stmt_owner);
$is_owner = mysqli_stmt_num_rows($stmt_owner) > 0;
mysqli_stmt_close($stmt_owner);

$stmt_tenant = mysqli_prepare($db, "SELECT tenant_id FROM tenant WHERE email = ?");
mysqli_stmt_bind_param($stmt_tenant, "s", $u_email);
mysqli_stmt_execute($stmt_tenant);
mysqli_stmt_store_result($stmt_tenant);
$is_tenant = mysqli_stmt_num_rows($stmt_tenant) > 0;
mysqli_stmt_close($stmt_tenant);

if (!$is_owner && !$is_tenant) {
    die("User not identified as owner or tenant.");
}

$sender_type = $is_owner ? 'owner' : 'tenant';
$sender_id   = $is_owner ? $owner_id : $tenant_id;

if (isset($_POST['send_message']) && !empty(trim($_POST['message']))) {
    $message = trim($_POST['message']);

    $stmt = mysqli_prepare($db,
        "INSERT INTO chat (message, owner_id, tenant_id, sender_id, sender_type) VALUES (?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "siiis", $message, $owner_id, $tenant_id, $sender_id, $sender_type);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: chatpage.php?owner_id=$owner_id&tenant_id=$tenant_id");
        exit;
    } else {
        $err = mysqli_error($db);
        mysqli_stmt_close($stmt);
        echo "<script>alert('Error sending message: " . addslashes($err) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Message</title>
</head>
<body>
    <form method="POST">
        <textarea name="message" placeholder="Type your message here..." required></textarea>
        <input type="submit" name="send_message" value="Send">
    </form>
</body>
</html>
