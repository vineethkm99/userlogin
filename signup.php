<?php 
	session_start();
?>
<?php require_once("includes/connection.php");?>
<?php 
// START FORM PROCESSING
$msg = array();
if (isset($_POST['name'])) { // Form has been submitted.
	$name = $_POST['name'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$gender = $_POST['gender'];
	$pass = $_POST['password'];
	$hashed_pass = sha1($pass);

	// check if already created
	$sql = "SELECT id FROM accounts WHERE email= '$email' OR mobile= '$mobile' ";
	$q=$conn->prepare($sql);
	$q->execute();
	$i=0;
	foreach($q->fetch(PDO::FETCH_ASSOC) as $row){
		$i++;
	}
	// if no problems with db add to db
	if($i==0){
		$sql = "INSERT INTO accounts (name, email, mobile , gender, hashed_pass)
	    VALUES ('$name' , '$email', '$mobile' , '$gender' , '$hashed_pass')";
	    // use exec() because no results are returned
	    $conn->exec($sql);
	    // redirect
	    $_SESSION['user_id'] = $conn->lastInsertId();
	    $_SESSION['user_name'] = $name;
	    $_SESSION['user_gender'] = $gender;
	    header("Location: photo_upload.php");
	    exit;
	}
	else{
		array_push($msg, 'This email or mobile is already registered');
	}
} else { // Form has not been submitted.
	$name = "";
	$email = "";
	$mobile = "";
	$gender = "";
	$pass = "";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>
	<style type="text/css">
		.error{color: red;}
	</style>
	<script type="text/javascript" src="javascript/jquery-3.0.0.min.js"></script>
<!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 --> <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
 </head>
<body>
	<p>Create an account....<br></p>
	<?php 
		// display error message
		if(!empty($msg)){
			echo "<p>Error:<br>";
			foreach ($msg as $key) {
				echo $key."<br>";
			}
			echo "</p>";
		}
	?>
	<form action="signup.php" method="post" id="signupform">
		<div>Name:</div>
		<input type="text" name="name" value=<?php echo $name; ?>>
		<div>Email:</div>
		<input type="email" name="email" value=<?php echo $email; ?>>
		<div>Mobile No.</div>
		<input type="text" name="mobile" value=<?php echo $mobile; ?>>
		<div>Password:</div>
		<input type="password" name="password" id="password" value=<?php echo ""; ?>>
		<div>Confirm Password:</div>
		<input type="password" name="cpassword" id="cpassword" value=<?php echo ""; ?>><span></span>
		<div>Gender:</div>
		<input type="radio" name="gender" value="male" class="required" <?php if($gender == 'male'){echo "checked";}?>> Male
		<input type="radio" name="gender" value="female" <?php if($gender == 'female'){echo "checked";}?>> Female<br>
		<input type="submit" name="Signup">
	</form>
	<p></p>
	<script type="text/javascript" src="javascript/validate.js"></script>
	<script type="text/javascript">
		
	</script>
</body>
</html>