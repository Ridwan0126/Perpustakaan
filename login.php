<?php 

session_start();

require 'mysql.php';

if(isset($_POST['submit']))
{
	$sql="select * from users where username='".$_POST['username']."' AND password='".$_POST['password']."'";
	
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_array($result);
	
	//print_r($data);
	
	if(!empty($data))
	{
		$_SESSION['user_role']=$data['role'];
		$_SESSION['username']=$data['username'];
		
		header('location:dashboard.php');
		
	}

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Login form</h2>
  <form method="post">
    <div class="mb-3 mt-3">
      <label for="email">Username:</label>
      <input type="text" class="form-control" id="email" placeholder="Enter username" name="username">
    </div>
    <div class="mb-3">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
    </div>
   
   
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    <a href="registration.php">register</a>
  </form>
</div>

</body>
</html>
