<?php
   
	//TODO : 1. add the password strength checker
	//TODO : 2. add new encryption NOT md5()
	//TODO : 3. maybe add "other" in gender field
	//TODO : 4. make sending a mail
	//TODO :5. make capcha
$fname = $sname = $email = $pass = $confpass = $gender = "";
$fnmaErr = $snameErr = $emailErr = $passErr = $genderErr = "";

	$mysql_host = "mysql8.000webhost.com";
	$mysql_database = "a1814258_test1";
	$mysql_user = "a1814258_user1";
	$mysql_password = "mikemysqluser1123";
	
	mysql_connect($mysql_host, $mysql_user, $mysql_password)or die("cannot connect"); 
	mysql_select_db($mysql_database)or die("cannot select DB");

	if ($_SERVER['REQUEST_METHOD'] == "POST"){
		$fname = test_input($_POST['firstname']);
		$sname = test_input($_POST['secondname']);
		$email = test_input($_POST['email']);
		$pass = test_input($_POST['password']);
		$confpass = test_input($_POST['confirmpassword']);
		$gender = test_input($_POST['gender']);

		if (strlen($fname) >20)
			$fnameErr = "Your first name is too long";
		elseif (empty($fname))
			 $fnameErr = "Your first name is empty";
		elseif (!preg_match("/^[a-zA-Z ]*$/",$fname)) 
			$nameErr = "Only letters and white space allowed";
		elseif (strlen($sname) >20)
			$snameErr =  "Your second name is too long";
		elseif (empty($sname))
			$snameErr = "Your second name is empty";
		elseif (!preg_match("/^[a-zA-Z ]*$/",$sname)) 
			$nameErr = "Only letters and white space allowed";	
		elseif (strlen($email) >50)
			$emailErr = "Your email is too long";
		elseif (empty($email))
			$emailErr = "Your email is empty";
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
			$emailErr = "Invalid email format"; 
		elseif (strlen($pass) >36)
			$passErr = "Your password is too long";
		elseif (empty($pass))
			$passErr = "Your password is empty";
		elseif (!hash_equals($pass, $confpass))
			$passErr = "Your password did not match the confirmation";
		elseif (!hash_equals($gender, "male") &&!hash_equals($gender, "female"))	
			$genderErr = "Your gender is not correct";
		else {
			
			$email = mysql_escape_string($email);
			$sql = "SELECT * FROM users WHERE email='$email'LIMIT 0,1";
			$result = mysql_query($sql);
			if (mysql_num_rows($result)==1)
				$emailErr = "Your email is already using";
			else{
				$mdpass = md5(md5($pass));
				$activation = "123"; // make norm
				$sql = "INSERT INTO users (firstname, lastname, email, hpass, activationCode) VALUES('$fname', '$sname', '$email', '$mdpass', $activation)";
				mysql_query($sql);
				///continue here
			}
		}	
	}

	function test_input($data){
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	function hash_equals($str1, $str2) {
    if(strlen($str1) != strlen($str2)) {
      return false;
    } else {
      $res = $str1 ^ $str2;
      $ret = 0;
      for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
      return !$ret;
    }
  }
  mysql_close();
 ob_end_flush();	
?>

?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>Account registration</title>
        </head>
        <body>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label for="firstname">First name:</label>
                <input type="text" name="firstname">
                <span class="error"> <?php echo $fnameErr;?></span>
                <br>
                <br>
                <label for="secname">Second name:</label> 
                <input type="text" name="secondname" id="secname">
                <span class="error"> <?php echo $snameErr;?></span>
                <br>
                <br>
                <label for="eml">E-mail:</label>
                <input type="email" name="email" id="iml">
                <span class="error"> <?php echo $emailErr;?></span>
                <br>
                <br>
                <label for="passw">Password:</label>
                <input type="password" name="password" id="passw">
                <span class="error"><?php echo $passErr;?></span>
                <br>
                <br>
                <label for="confpassw">Confirm your password:</label>
                <input type="password" name="confirmpassword" id="confpassw">
                <span class="error"><?php echo $passErr;?></span>
                <br>
                <br>
                Gender:
                <input type="radio" name="gender" value="female" id="fml"><label for="fml">Female</label>
                <input type="radio" name="gender" value="male" id="ml"><label for="ml">Male</label>
                <span class="error"> <?php echo $genderErr;?></span>
                <br>
                <br>
                <input type="submit" name="submit" value="Submit">
            </form>
        </body>
    </html>
