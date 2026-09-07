<?php 
include("header1.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>User Register - Gateway-paradise</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f8ff; /* Light Blue Background */
    }

    .container {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 10px 0px 30px rgba(0, 0, 0, 0.1);
      width: 700px;
	  height:750px;
      margin: 50px auto;
    }

    .container h3 {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 30px;
    }

    .form-group label {
      font-weight: bold;
	  font-size:18px;
    }

    .btn-primary {
      background-color: #2193b0;
      border: none;
      transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #6dd5ed;
    }

    .form-group img {
      display: block;
      margin: 20px auto;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }
    .side-img{
      height: 50;;
      width:100;
      position: flex;
    }

    .form-group .btn {
      width: 100%;
      padding: 10px;
      border-radius: 50px;
      transition: all 0.3s ease;
    }

    .form-group .btn:hover {
      transform: scale(1.05);
    }

    .text-right {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
 
    <h3 class="text-center">Equipment Registration </h3>
    
    <hr color="green"> </hr><br>
    <form method="POST" action="add_equipment_det.php" enctype="multipart/form-data">
	<div class="form-group">
        <label><h5>Id:</h5></label>
        <input type="number" class="form-control" id="id" placeholder="Enter Id " name="id" required>
      </div><br>
      <div class="form-group">
        <label><h5>Equipment Name:</h5></label>
        <input type="text" class="form-control" id="full_name" placeholder="Enter Equipment Name" name="ename" required>
      </div><br>
      <div class="form-group">
        <label><h5>Equipment Type:</h5></label>
        <input type="text" class="form-control" id="email" placeholder="Enter Email" name="etype" required>
      </div><br>
      <div class="form-group">
        <label><h5>Rent Price:</h5></label>
        <input type="text" class="form-control"  placeholder="Enter Price" name="price" required>
      </div><br>
      <div class="form-group">
        <label><h5>Equipemt Status:</h5></label>
        <input type="text" class="form-control"  placeholder="Enter Status" name="status" required>
      </div><br>
	  <br>
      <div class="form-group">
        <label for="card_photo"><h5>Upload your Selected Picture:</h5></label>
        <input type="file" name="id_photo" accept="image/*">
      </div> <br>
      <div class="form-group">
        <label for="address"><h5>Description:</h5></label>
        <textarea class="form-control" id="address" placeholder="Enter Description" name="description" rows="3" required> </textarea>
      </div>
  
      <hr color="green"></hr> <br>
      <button type="submit" id="submit" name="owner_register" class="btn btn-success btn-block"><h5>Register</h5></button>
      <div class="form-group text-right">
       <!-- <label>Register as an <a href="owner-register.php">Owner</a>?</label><br>  -->
      </div><br><br>
    </form>
  </div>
</body>
</html>
