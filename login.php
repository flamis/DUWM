<?php
	$mysql_host = "mysql8.000webhost.com";
	$mysql_database = "a1814258_test1";
	$mysql_user = "a1814258_user1";
	$mysql_password = "mikemysqluser1123";
	
	mysql_connect($mysql_host, $mysql_user, $mysql_password)or die("cannot connect"); 
	mysql_select_db($mysql_database)or die("cannot select DB");
	
  $email= $_POST['email'];
  $pass = $_POST['pass'];
  
  $email = stripslashes($email);
  $pass = stripslashes($pass);
  // PLZ make sure it is really SECURE!!!
  $email = mysql_real_escape_string($email);
  $pass = mysql_real_escape_string($pass);
  
  if (strlen($email)>50){
	  echo "Email is too long";
  }elseif (strlen($email)==0 || $email == null){
	  echo "Email is empty";
  }elseif (strlen($pass)>36){
	  echo "Password is too long";
  } elseif (strlen($pass)==0 || $pass == null){
	  echo "Password is empty";
  } else {   
    
	$mdpass = md5(md5($pass)); //TODO : add normal hash function(encription)
	
	$sql = "SELECT * FROM users WHERE email='$email' AND hpass='$mdpass' LIMIT 0,1";
	$result = mysql_query($sql); 
	
	$count = mysql_num_rows($result);
	if ($count==1){
		//Success
		echo "here must be :go to the main";
		session_register("myusername");
		session_register("mypassword"); 
		//header("location:index.php");
		//TODO: go to the users page
		//learn about phpsessions
	} else {
		echo "Your email or password is wrong<br>";
		//TODO:return to login
	}
  }
  mysql_close();
  ob_end_flush();
?>
