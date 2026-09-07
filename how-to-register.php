<?php 
include("navbar.php");
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
 
    <h3 class="text-center">User Registration &nbsp;<img src="images/avatar.png" width="100" alt="register"></h3>
    
    <hr><br>
    <form method="POST" action="user_register.php" enctype="multipart/form-data">
      <div class="form-group">
        <label for="full_name"><h5>Full Name:</h5></label>
        <input type="text" class="form-control" id="full_name" placeholder="Enter Full Name" name="name" required>
      </div><br>
      <div class="form-group">
        <label for="email"><h5>Email:</h5></label>
        <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required>
      </div><br>
      <div class="form-group">
        <label for="password1"><h5>Password:</h5></label>
        <input type="password" class="form-control" id="password1" placeholder="Enter Password" name="password1" required>
      </div><br>
      <div class="form-group">
        <label for="password2"><h5>Confirm Password:</h5></label>
        <input type="password" class="form-control" id="password2" name="password2" placeholder="Enter Password Again" required>
      </div> <br>
      <div class="form-group">
        <label for="phone_no"><h5>Phone No.:</h5></label>
        <input type="text" class="form-control" id="phone_no" pattern="[789][0-9]{9}" max-length="10" placeholder="Enter Phone No." name="phone_no" required>
      </div> <br>
      <div class="form-group">
        <label for="address"><h5>Address:</h5></label>
        <textarea class="form-control" id="address" placeholder="Enter Address" name="address" rows="3" required> </textarea>
      </div>
   <!--   <div class="form-group">
        <label for="id_type">Type of ID:</label>
        <select class="form-control" name="id_type" required>
          <option>Citizenship</option>
          <option>Driving Licence</option>
        </select>
      </div>
      <div class="form-group">
        <label for="card_photo">Upload your Selected Card:</label>
        <input type="file" class="form-control-file" name="id_photo" accept="image/*" onchange="preview_image(event)" required>
      </div>
      <div class="form-group">
        <label>Your selected File:</label><br>
        <img src="" id="output_image" height="200px" required>
      </div>
      <hr>--> <br>
      <button type="submit" id="submit" name="tenant_register" class="btn btn-success btn-block" onclick="return Validate()"><h5>Register</h5></button>
      <div class="form-group text-right">
       <!-- <label>Register as an <a href="owner-register.php">Owner</a>?</label><br>  -->
      </div><br><br>
    </form>
  </div>

  <script>
    function preview_image(event) {
      var reader = new FileReader();
      reader.onload = function() {
        var output = document.getElementById('output_image');
        output.src = reader.result;
      }
      reader.readAsDataURL(event.target.files[0]);
    }

    function Validate() {
      var password = document.getElementById("password1").value;
      var confirmPassword = document.getElementById("password2").value;
      if (password != confirmPassword) {
        alert("Passwords do not match.");
        return false;
      }
      return true;
    }
  </script> -->
</body>
</html>
