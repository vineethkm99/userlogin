<?php 
require_once("includes/sessions.php"); 
require_once("includes/connection.php"); 
$msg = array();
// form submitted
if(isset($_POST['password'])){
	$hashed_old_pass = sha1($_POST['password']);
	$hashed_new_pass = sha1($_POST['npassword']);
	try{ 
		$sql = "UPDATE accounts SET hashed_pass = '$hashed_new_pass' WHERE id = ".$_SESSION['user_id']." AND hashed_pass = ".$hashed_old_pass;
        $q=$conn->prepare($sql);
        $q->execute();
		header("Location: index.php");
		exit;
    }
	catch(PDOException $e)
    {
    	array_push($msg, "Original Password is incorrect");
    }
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Update Password</title>
	<style type="text/css">	.error {color: red;} </style>
	<script type="text/javascript" src="javascript/jquery-3.0.0.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
</head>
<body> 
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
	<form action="update_password.php" method="post" id="update_pass">
		<div>Present Password:</div>
		<input type="password" name="password" id="password" value=<?php echo ""; ?>>
		<div>New Password:</div>
		<input type="password" name="npassword" id="npassword" value=<?php echo ""; ?>><span></span>
		<div>Confirm New Password:</div>
		<input type="password" name="cnpassword" id="cnpassword" value=<?php echo ""; ?>><br>
		<input type="submit" name="Change password">
	</form>
	<script type="text/javascript">
		$(document).ready(function(){
    $("#update_pass").validate({
        rules: {
            password: {
                required: true,
                minlength: 5
            },
            npassword:{
            	required: true,
                minlength: 5
            },
            cnpassword : {
                minlength : 5,
                equalTo : '[name="npassword"]'
            }
        },
        messages: {
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            npassword: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            cnpassword: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
	</script>
</body>
</html>