<?php
include("connection.php");

if (isset($_POST['book_property'])) {
    if (isset($_SESSION["email"])) {
        $u_email = $_SESSION["email"];
        $property_id = $_GET['property_id'];

        $sql = "SELECT * FROM tenant WHERE eq_id='$u_id'";
        $query = mysqli_query($db, $sql);

        if (mysqli_num_rows($query) > 0) {
            $rows = mysqli_fetch_assoc($query);
            $tenant_id = $rows['tenant_id'];

            $sql1 = "UPDATE add_property SET booked='Yes' WHERE property_id='$property_id'";
            $query1 = mysqli_query($db, $sql1);

            if ($query1) {
                $sql2 = "INSERT INTO booking (property_id, tenant_id) VALUES ('$property_id', '$tenant_id')";
                $query2 = mysqli_query($db, $sql2);

                if ($query2) {
                    echo "<div class='container'><div class='alert' role='alert'>
                            <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span>
                            <center><strong>Thank you for booking this property.</strong></center>
                          </div></div>";
                }
            }
        }
    }
}
?>

<style>
.alert {
    padding: 20px;
    background-color: #DC143C;
    color: white;
}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}
</style>

<script>
window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);
</script>

<div class="container">
    <div class="alert" role='alert'>
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
        <center><strong>Thank you for booking this Equipmnents.</strong></center>
    </div>
</div>
