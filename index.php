<?php 
require_once("includes/sessions.php"); 
require_once("includes/connection.php"); 
$sql = "SELECT profilepic FROM accounts WHERE id = ".$_SESSION['user_id'];
$q=$conn->prepare($sql);
$q->execute();
$row = $q->fetch(PDO::FETCH_ASSOC);
if(!empty($row['profilepic'])){
	$ppsrc = $row['profilepic'];
}else{
	$ppsrc = 'images/'.$_SESSION['user_gender'].'.jpg';
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>welcome</title>
</head>
<body>
	<p>
		Hello 
		<?php 
		if($_SESSION['user_gender']== 'male'){
			echo "Mr. ";
		}else{
			echo "Miss/Mrs. ";
		}
		echo $_SESSION['user_name']; 
		?>
	</p>
	<img src=<?php echo $ppsrc; ?> width = "150px" />
	<br />
	<p><a href="photo_upload.php">Update profile picture</a></p>
	<p><a href="update_password.php">Click here to change your password</a></p>
	<p><a href="logout.php">Click here to logout</a></p>
</body>
</html>