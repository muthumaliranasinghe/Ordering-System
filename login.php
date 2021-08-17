<?php  

$host = "localhost";
$user = "root";
$password= "";
$db = "abc_company";

mysql_connect($host,$user,$password);
mysql_select_db($db);

if(isset($_POST['submit'])){
	$uname = $_POST['username'];
	$password = $_POST['password'];

	$sql = "SELECT * FROM login WHERE user='".$uname."' AND  password= '".$password."' limit 1";

	$result = mysql_query($sql);

	if(mysql_num_rows($result)==1){
		header('Location: order.php');
		exit();
	}
	else{
		echo "You have Entered Incorrect username or Password";
		exit();
	}
}
?>