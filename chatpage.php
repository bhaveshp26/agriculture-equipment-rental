<?php
session_start();
include("navbar.php");
include("config/config.php");

if (!isset($_SESSION["email"])) {
    die("User not logged in.");
}

$u_email = $_SESSION["email"];

// Determine if the current user is an owner or tenant
$sql_owner = "SELECT owner_id, full_name FROM owner WHERE email='$u_email'";
$result_owner = mysqli_query($db, $sql_owner);
$is_owner = mysqli_num_rows($result_owner) > 0;

$sql_tenant = "SELECT tenant_id, full_name FROM tenant WHERE email='$u_email'";
$result_tenant = mysqli_query($db, $sql_tenant);
$is_tenant = mysqli_num_rows($result_tenant) > 0;

if (!$is_owner && !$is_tenant) {
    die("User not identified as either owner or tenant.");
}

$owner_id = $is_owner ? mysqli_fetch_assoc($result_owner)['owner_id'] : null;
$tenant_id = $is_tenant ? mysqli_fetch_assoc($result_tenant)['tenant_id'] : null;

// Ensure owner_id and tenant_id are set in the URL parameters or POST data
if ($is_owner && isset($_POST['tenant_id'])) {
    $tenant_id = $_POST['tenant_id'];
} elseif ($is_tenant && isset($_POST['owner_id'])) {
    $owner_id = $_POST['owner_id'];
} elseif ($is_owner && isset($_GET['tenant_id'])) {
    $tenant_id = $_GET['tenant_id'];
} elseif ($is_tenant && isset($_GET['owner_id'])) {
    $owner_id = $_GET['owner_id'];
} else {
    die("Owner ID or Tenant ID not set in the URL parameters or POST data.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Interface</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .display-chat {
            height: 300px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .message {
            margin-bottom: 8px;
            max-width: 70%;
            padding: 10px;
            border-radius: 10px;
        }
        .message p {
            margin: 5px 0;
        }
        .sent {
            background-color: #dcf8c6;
            color: #333;
            margin-left: auto;
            max-width: 80%;
        }
        .received {
            background-color: #e2e2e2;
            color: #333;
            margin-right: auto;
            max-width: 80%;
        }
        .timestamp {
            font-size: 12px;
            color: #999;
            margin-left: 5px;
        }
        .form-group {
            margin-bottom: 10px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <center><h3>Send Messages</h3></center>
    <div class="display-chat">
        <?php
        $sql1 = "SELECT c.*, t.full_name AS tenant_name, o.full_name AS owner_name
                 FROM chat c
                 JOIN tenant t ON c.tenant_id = t.tenant_id
                 JOIN owner o ON c.owner_id = o.owner_id
                 WHERE (c.owner_id='$owner_id' AND '$owner_id' IS NOT NULL) 
                    OR (c.tenant_id='$tenant_id' AND '$tenant_id' IS NOT NULL)
                 ORDER BY c.timestamp ASC";
        
        $query1 = mysqli_query($db, $sql1);

        if (mysqli_num_rows($query1) > 0) {
            while ($row = mysqli_fetch_assoc($query1)) {
                $sender_name = $row['sender_type'] == 'tenant' ? $row['tenant_name'] : $row['owner_name'];
                ?>
                <div class="message <?php echo $row['sender_type'] == ($is_tenant ? 'tenant' : 'owner') ? 'sent' : 'received'; ?>">
                    <p>
                        <span class="sender"><?php echo $sender_name; ?>:</span>
                        <span class="message-text"><?php echo $row['message']; ?></span>
                        <span class="timestamp"><?php echo $row['timestamp']; ?></span>
                    </p>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="message">
                <p>No previous chat available.</p>
            </div>
            <?php
        }
        ?>
    </div>
    <form class="form-horizontal" method="POST" action="send-message.php?owner_id=<?php echo $owner_id; ?>&tenant_id=<?php echo $tenant_id; ?>">
        <div class="form-group">
            <div class="col-sm-10">
                <textarea name="message" class="form-control" placeholder="Type your message here..."></textarea>
            </div>
            <div class="col-sm-2">
                <input type="submit" name="send_message" class="btn btn-primary" formmethod="post" value="Send">
            </div>
        </div>
    </form>
</div>
</body>
</html>
