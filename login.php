<?php 
	session_start();
?>
<?php require_once("includes/connection.php"); ?>
<?php 
	$msg = array();
	if (isset($_POST['email'])) { // Form has been submitted.
		$email = $_POST['email'];
		$pass = $_POST['password'];
		$hashed_pass = sha1($pass);

		$sql = "SELECT id,name,gender FROM accounts WHERE email= '$email' AND hashed_pass= '$hashed_pass' LIMIT 1";
		$q=$conn->prepare($sql);
		$q->execute();
		$row = $q->fetch(PDO::FETCH_ASSOC);
		if(empty($row)){
			array_push($msg, 'Email or password is incorrect');
		}
		else{
			$_SESSION['user_id'] = $row['id'];
			$_SESSION['user_name'] = $row['name'];
			$_SESSION['user_gender'] = $row['gender'];
			header("Location: index.php");
			exit;
		}
	}
	else{// form is nt submitted
		if (isset($_GET['logout']) && $_GET['logout'] == 1) {
			array_push($msg, "You are now logged out.");
		} 
		$email = "";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<?php 
		if(!empty($msg)){
			echo "<p>";
			foreach ($msg as $key) {
				echo $key."<br>";
			}
			echo "</p>";
		}
	?>
	<form action="login.php" method="post">
		<div>Email:</div>
		<input type="email" name="email" value=<?php echo $email; ?>>
		<div>Password:</div>
		<input type="password" name="password" value="">
		<input type="submit" name="Login">
	</form>
	<a href="signup.php">Don't have an account?? Click here to get one</a>
</body>
</html>