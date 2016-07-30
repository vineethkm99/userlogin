<?php  
$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$gender = $_POST['gender'];
$pass = $_POST['password']

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec($sql);
    //echo "inserted";
	}
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

?>