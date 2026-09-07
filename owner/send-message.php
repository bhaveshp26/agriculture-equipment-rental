<?php
session_start();
include("../config/config.php");

if (!isset($_SESSION["email"])) {
    die("User not logged in.");
}

$u_email = $_SESSION["email"];

// Fetch owner and tenant information based on session email
$sql_owner = "SELECT owner_id FROM owner WHERE email='$u_email'";
$result_owner = mysqli_query($db, $sql_owner);
$is_owner = mysqli_num_rows($result_owner) > 0;

if (!$is_owner) {
    die("owner not found ");
}

// Retrieve owner_id and tenant_id from URL parameters
if (!isset($_GET['owner_id'], $_GET['tenant_id'])) {
    die("Owner ID or Tenant ID not set in the URL parameters.");
}

$owner_id = $_GET['owner_id'];
$tenant_id = $_GET['tenant_id'];

if (isset($_POST['send_message'])) {
    $message = $_POST['message'];

    // Directly set sender_type as 'owner' in the SQL query
    $sql = "INSERT INTO chat (message, owner_id, tenant_id, sender_type) VALUES ('$message', '$owner_id', '$tenant_id', 'owner')";
    if (mysqli_query($db, $sql)) {
        header("Location: chatpage.php?owner_id=$owner_id&tenant_id=$tenant_id");
    } else {
        echo "Error: ". mysqli_error($db);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
</head>
<body>
    <form method="POST">
        <input type="hidden" name="owner_id" value="<?php echo $owner_id;?>">
        <input type="hidden" name="tenant_id" value="<?php echo $tenant_id;?>">
        <textarea name="message" placeholder="Type your message here..."></textarea>
        <input type="submit" name="send_message" value="Send">
    </form>
</body>
</html>