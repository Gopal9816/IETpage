<?php
session_start();
if (isset($_SESSION['userSession'])!="") {
	header("Location: home.php");
}
require_once 'dbconnect.php';

if(isset($_POST['btn-signup'])) {
	
	$uname = strip_tags($_POST['username']);
	$email = strip_tags($_POST['email']);
	$upass = strip_tags($_POST['password']);
   $memno = strip_tags($_POST['memno']);
	
	$uname = $DBcon->real_escape_string($uname);
	$email = $DBcon->real_escape_string($email);
	$upass = $DBcon->real_escape_string($upass);
   $memno = $DBcon->real_escape_string($memno);
	
	$hashed_password = password_hash($upass, PASSWORD_DEFAULT); // this function works only in PHP 5.5 or latest version
	
	$check_email = $DBcon->query("SELECT email FROM tbl_users WHERE email='$email'");
	$count=$check_email->num_rows;
   $check_memno = $DBcon->query("SELECT * FROM tbl_members WHERE memno='$memno'");
	$count_mem=$check_memno->num_rows;
	if($count_mem==1){
	   if ($count==0) {
		
		   $query = "INSERT INTO tbl_users(username,email,password) VALUES('$uname','$email','$hashed_password')";
                   $query_next = "UPDATE tbl_members SET username='$uname' WHERE memno='$memno'";
	      	   if ($DBcon->query($query) && $DBcon->query($query_next)) {
			                   $query_stat = "SELECT * FROM tbl_users WHERE username='$uname'";
                                           $query_sec = $DBcon->query($query_stat);
                                           $userRow = $query_sec->fetch_array(); 
                                           $user_id = $userRow['user_id'];
                                           $query_third = "UPDATE tbl_members SET user_id=$userRow[user_id] WHERE memno='$memno'";
                                           $DBcon->query($query_third);     
                                           $msg = "<div class='alert alert-success'>
 						   <span class='glyphicon glyphicon-info-sign'></span> &nbsp; successfully registered !
					   </div>";
		   }else {
			   $msg = "<div class='alert alert-danger'>
						   <span class='glyphicon glyphicon-info-sign'></span> &nbsp; error while registering !
					   </div>";
		   }
		
	   } else {
		
		
		   $msg = "<div class='alert alert-danger'>
 					   <span class='glyphicon glyphicon-info-sign'></span> &nbsp; sorry email already taken !
				   </div>";
			
	   }
        } else {
            $msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid Membership Number! 
				</div>"; 
        }
	
	$DBcon->close();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sign Up!</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>

<div class="signin-form">

	<div class="container">
     
        
       <form class="form-signin" method="post" id="register-form">
      
        <h2 class="form-signin-heading">Sign Up</h2><hr />
        
        <?php
		if (isset($msg)) {
			echo $msg;                       
 		}
		?>
          
        <div class="form-group">
        <input type="text" class="form-control" placeholder="Username" name="username" required  />
        </div>
        
        <div class="form-group">
        <input type="email" class="form-control" placeholder="Email address" name="email" required  />
        <span id="check-e"></span>
        </div>
        
        <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="password" required  />
        </div>
       
        <div class="form-group">
        <input type="text" class="form-control" placeholder="IET Membership number" name="memno" required  />
        </div>
     	<hr />
        
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-signup">
    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account
			</button> 
            <a href="index.php" class="btn btn-default" style="float:right;">Log In Here</a>
        </div> 
      
      </form>

    </div>
    
</div>

</body>
</html>