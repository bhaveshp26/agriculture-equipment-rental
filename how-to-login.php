<?php 
session_start();
if(isset($_SESSION["email"])){
  header("location:index.php");
}
include("navbar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login Choice - RentHouse</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color:#32CD32; 
    }

    .sign-in-form-section {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      background: linear-gradient(to right, #6dd5ed, #2193b0);
    }

    .sign-up {
      background-color: rgba(255, 255, 255, 0.9);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
      max-width: 600px;
      width: 100%;
      text-align: center;
    }

    .sign-up h3 {
      font-size: 36px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .sign-up p {
      font-size: 16px;
      margin-bottom: 30px;
    }

    .sign-up .btn {
      font-size: 18px;
      padding: 10px 20px;
      border-radius: 50px;
      margin-bottom: 10px;
      transition: all 0.3s ease;
    }

    .sign-up .btn-info {
      background-color: #32CD32;
      border: none;
    }

    .sign-up .btn-info:hover {
      background-color: #32CD32;
    }
  </style>
</head>
<body>
  <section class="container-fluid sign-in-form-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12 sign-up">
          <h3>How do you want to Login?</h3>
          <hr>
          <p>If you want to sign in as a User, click on the User Login button, otherwise click on the Owner Login button. For administrative access, click on the Admin Login button.</p>
          <button type="button" class="btn btn-info" onclick="window.location.href='user_login.php'">User Login</button>
          <!--<button type="button" class="btn btn-info" onclick="window.location.href='owner-login.php'">Owner Login</button>
       -->   <button type="button" class="btn btn-info" onclick="window.location.href='admin-login.php'">Admin Login</button>
        </div>
      </div>
    </div>
    <img src="images/login.png" class="side-img" alt="register">
  </section>
</body>
</html>
