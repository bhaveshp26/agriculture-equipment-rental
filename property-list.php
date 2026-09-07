<?php 
include("config/config.php");
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Arial, sans-serif;
  line-height: 1.6;
  color: #333;
  padding: 20px;
  background-color: #f0e9d8; /* Soft background color for a vacation feel */
}

.container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  gap: 20px;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  border-radius: 12px;
  overflow: hidden;
  background-color: #fff; /* White background */
  transition: box-shadow 0.3s ease;
  width: 100%;
  max-width: 400px; /* Maximum width for larger screens */
  min-height: 500px; /* Ensuring uniform height */
  padding: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.card-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  width: 100%;
}

.card-title {
  font-size: 28px;
  color: #444; /* Slightly darker title */
  margin-bottom: 15px;
}

.card-location {
  color: #777;
  margin-bottom: 15px;
}

.card-image {
  width: 100%;
  height: 250px; /* Standardized image height */
  object-fit: cover;
  border-bottom: 1px solid #eee; /* Softer border */
}

.btn {
  padding: 12px 20px; /* Increased padding for better touch interaction */
  background-color: #818dd6; /* Neutral gray background */
  color: black; /* Black text */
  text-align: center;
  text-decoration: none; /* Remove underline */
  border: none;
  border-radius: 5px;
  transition: background-color 0.3s ease;
  margin-top: 10px; /* Added margin to separate from location */
  display: inline-block; /* Make sure it behaves like a block element */
}

.btn:hover {
  background-color:#5b6ac2; /* Darker gray on hover */
  cursor: pointer; /* Change cursor to pointer on hover */
}

.btn:active {
  background-color: #555; /* Even darker gray when clicked */
}

@media (max-width: 768px) {
.container {
    flex-direction: column;
  }

.card {
    max-width: 100%; /* Full width on smaller screens */
    padding: 10px;
  }

.card-title {
    font-size: 22px;
  }

.card-location {
    font-size: 14px;
  }

.btn {
    padding: 8px 0;
    font-size: 14px;
  }
}
</style>
</head>
<body>
<div class="container">
<?php 

$sql="SELECT * FROM add_property";
$query=mysqli_query($db,$sql);

if(mysqli_num_rows($query)>0)
{
  while ($rows=mysqli_fetch_assoc($query)) {
    $property_id=$rows['property_id'];

?>

<div class="card">
<?php

$sql2="SELECT * FROM property_photo where property_id='$property_id'";
$query2=mysqli_query($db,$sql2);

if(mysqli_num_rows($query2)>0)
{
  $row=mysqli_fetch_assoc($query2); 
  $photo=$row['p_photo'];
  echo  '<img class="card-image" src="owner/'.$photo.'">'; 
}?>

<h4 class="card-title"><b><?php echo $rows['property_type'];?></b></h4> 
<p class="card-location"><?php echo $rows['city'].', '.$rows['district']?></p> 
<a href="view-property.php?property_id=<?php echo $rows['property_id'];?>" class="btn btn-primary btn-block">View Property</a>
</div>

<?php 
  }
}
?>
</div>
</body>
</html>
