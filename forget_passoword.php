<html>
<head>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet"
type="text/css" media="all"/>
<style>
        .container{
            height:300px;
            width:400px;
            background-color:white;
            border-radius:10px;

        }
</style>
</head>
<body>
    <form action="forget_password_code.php" method="post"><br><br>
        <div class="container">
          <h5>Create New Password..</h5> 
            <br>
        Enter Email Id:
        <input type="text" name="email"  class="form-control">
        <br>
        Enter New Password:
        <input type="text" name="password1"  class="form-control">
        <br>
        RE_Enter Password
        <input type="text"name="password2" class="form-control">
        <br>
        <input type="submit" id="submit" class="btn btn-success btn-block" value="Submit">
    <br>
	</div> 
    </form>
</body>