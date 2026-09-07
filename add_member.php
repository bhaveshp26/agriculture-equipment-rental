<html>
<head>
<link href="bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet"
type="text/css" media="all"/>
<style>
body{
	background-image:url('/agriculture/images/bg2.jpg');
	background-size:100% 100%;
}
	
		.container{
	border-radius: 0.5em;
	box-shadow: 0 0 1em 0 rgba(51,51,51,0.25);
	display: block;
	background-color:white;
	height:450px;
	max-width: 900px;
	overflow: hidden;
	-webkit-transform: translate(-50%, -50%);
	-ms-transform: translate(-50%, -50%);
	transform: translate(-50%, -50%);
	padding: 2em;
	position: absolute;
		top: 50%;
		left: 50%;
		z-index: 1;
	width: 98%;
}
.divider{
	height:1px;
	background:linear-gradient(to right,#ccc 50% #fff 50%);
	margin:20px 0;
}

</style>		
</head>
<body >
<form action="add_mem.php" method="post">
<!-- <div class="container">-->
<!--<div class="modal-fade" id="tex1">
<form action="t.php" method="post">
<input type="text" name="t1">
<button type="submit"> Submit </button>
</form>
</div> -->
<div class="container">
<h5> ADD MEMBER </h5><br>
<h5> Name :</h5>
<input type="text" class="form-control" name="name" />
<br>
<h5> Email:</h5>
<input type="text" class="form-control" name="email" />
<br>
<h5> Password :</h5>
<input type="text" class="form-control" name="password" />
<br>
<button type='submit' class='btn btn-success'style="width:200px;">SUBMIT</button>
<!-- <button type="button" data_toggle="model" data_target="#text1"> </button>  -->
</body>
</html>