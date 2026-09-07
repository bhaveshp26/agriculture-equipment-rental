<html>
<head>
<link href="bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet" type="text/css" media="all"/>
<style>
body {
	background-image: url('/agriculture/images/bg5.webp');
	background-size: 100% 100%;
}
.container {
	height: 750px;
	width: 700px;
	background-color: white;
	border-radius: 20px;
	box-shadow: 10px 0px 30px rgba(0, 0, 0, 0.1);
	margin: 50px auto;
}
input.form-control {
	border-radius: 0;
	box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}
</style>
</head>
<body>
<form action="contact_code.php" method="post">
<br>
<div class="container">
<center><br>
<img src="/agriculture/images/logo2.png" height="70" width="70"><br>
<h5>Contact Us</h5>
<hr>
</center>
<label><b>Name:</b></label>
<div class="col">
    <input type="text" class="form-control" placeholder="Full name" name="name">
</div><br>
<label><b>Email Id:</b></label>
<div class="col">
    <input type="email" class="form-control" placeholder="Email Id" name="email" required>
</div><br>
<label><b>Contact:</b></label>
<div class="col">
    <input type="text" class="form-control" pattern="[789][0-9]{9}" maxlength="10" placeholder="Contact Number" name="contact" required>
</div><br>
<label><b>Message:</b></label>
<div class="col">
    <textarea class="form-control" placeholder="Message" name="message" rows="3"></textarea>
</div><br>
<center>
    <button type="submit" class="btn btn-success" style="border-radius:0;">Submit</button>
</center>
<hr color="green">
&nbsp;&nbsp;&nbsp;&nbsp;<img src="/agriculture/images/image5.webp" height="30" width="30"> <b>9739271324</b>&nbsp;&nbsp;
&nbsp;&nbsp;<img src="/agriculture/images/image6.webp" height="30" width="30"><b>farmer@gmail.com</b><br><br>
&nbsp;&nbsp;&nbsp;&nbsp;<img src="/agriculture/images/image8.jfif" height="30" width="30"><b>RPD Cross Tilakwadi Belgavi</b><br>
</div>
</form>
</body>
</html>
