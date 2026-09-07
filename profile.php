<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("location:user_login.php");
    exit;
}
include('navbar.php');
include_once('connection.php');

$u_email = $_SESSION["email"];

// Handle profile update
if (isset($_POST['update_profile'])) {
    $name    = trim($_POST['name']);
    $contact = trim($_POST['contact']);
    $address = trim($_POST['address']);

    $stmt = mysqli_prepare($con, "UPDATE user_reg SET name=?, contact=?, address=? WHERE email=?");
    mysqli_stmt_bind_param($stmt, "ssss", $name, $contact, $address, $u_email);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Profile updated successfully');</script>";
    }
    mysqli_stmt_close($stmt);
}

$stmt = mysqli_prepare($con, "SELECT * FROM user_reg WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $u_email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$rows   = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$rows) {
    echo "<script>alert('No user profile found for this account. Please register first.'); window.location='user_login.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background-color: #f0f8ff; font-family: 'Segoe UI', sans-serif; }
        .profile-card {
            max-width: 500px; margin: 40px auto; background: white;
            border-radius: 10px; padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .profile-card img { border-radius: 50%; display: block; margin: 0 auto 15px; }
    </style>
</head>
<body>
<div class="profile-card">
    <img src="images/avatar.png" alt="Avatar" height="100" width="100">
    <h4 class="text-center"><?php echo htmlspecialchars($rows['name']); ?></h4>
    <p class="text-center text-muted"><?php echo htmlspecialchars($rows['email']); ?></p>
    <hr>
    <p><b>Contact:</b> <?php echo htmlspecialchars($rows['contact']); ?></p>
    <p><b>Address:</b> <?php echo htmlspecialchars($rows['address']); ?></p>

    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#updateModal">Update Profile</button>
    <a href="view_booking_code.php?temail=<?php echo urlencode($rows['email']); ?>" class="btn btn-success btn-block mt-2">My Bookings</a>
    <a href="logout.php" class="btn btn-danger btn-block mt-2">Logout</a>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Profile</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($rows['name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="<?php echo htmlspecialchars($rows['email']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Contact</label>
                        <input type="text" class="form-control" name="contact" value="<?php echo htmlspecialchars($rows['contact']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($rows['address']); ?>">
                    </div>
                    <button type="submit" name="update_profile" class="btn btn-success btn-block">Save Changes</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
