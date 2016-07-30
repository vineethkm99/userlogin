<?php
require_once 'includes/sessions.php';
// In an application, this could be moved to a config file
$upload_errors = array(
	// http://www.php.net/manual/en/features.file-upload.errors.php
	UPLOAD_ERR_OK 			=> "No errors.",
	UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
	UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
	UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
	UPLOAD_ERR_NO_FILE 		=> "No file.",
	UPLOAD_ERR_NO_TMP_DIR 	=> "No temporary directory.",
	UPLOAD_ERR_CANT_WRITE 	=> "Can't write to disk.",
	UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
);
if(isset($_POST['submit'])) {
	// process the form data
	$tmp_file = $_FILES['file_upload']['tmp_name'];
	$target_file = basename($_FILES['file_upload']['name']);
  
	$file_type = $_FILES['file_upload']['type'];
	$allowed_files = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
	if(in_array($file_type, $allowed_files)){
		checkNMove($tmp_file, $target_file);
	}else{
		$message = "File format not supported";
	}
}
function checkNMove($tmp_file, $toTarget='')
{
	if(!file_exists('images/'.$toTarget)){
		moveFile($tmp_file, $toTarget);
	}else{
		$toTarget = 'image'.random_string(3).'.jpg';
		checkNMove($tmp_file, $toTarget);
	}
}
function random_string($length=0) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}
function moveFile($tmp_file, $target='')
{
	require_once("includes/connection.php");
	if(move_uploaded_file($tmp_file, "images/".$target)) {
		$message = "File uploaded successfully.";
		$sql = "UPDATE accounts
			SET profilepic = 'images/".$target."'
			WHERE id = ".$_SESSION['user_id'];
		$conn->exec($sql);
		header("Location: index.php");
	    exit;
	} else {
		$error = $_FILES['file_upload']['error'];
		$message = $upload_errors[$error];
	}
}
?>
<html>
	<head>
		<title>Update picture</title>
	</head>
	<body>
		<?php if(!empty($message)) { echo "<p>".$message."</p>"; } ?>
		<p>Upload your photo for the profile</p>
		<form action="photo_upload.php" enctype="multipart/form-data" method="POST">

		  <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
		  <input type="file" name="file_upload" />
		  <br />
		  <input type="submit" name="submit" value="Upload" />
		</form>
		<a href="index.php">No ?? You don't wanna upload ? Fine. Just skip it</a>
	</body>
</html>