<?php
include "../config/config.php";

$bookingId = $_POST['bookingId'];

$sql = "UPDATE booking SET booked = 'No' WHERE booking_id =?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $bookingId); // Adjust the parameter type as needed
$stmt->execute();

echo "OK";
?>
