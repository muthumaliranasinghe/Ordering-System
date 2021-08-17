<?php

$dsn='mysql:host=localhost;dbname=abc_company';
// $dsn='mysql:host=localhost;dbname=user-login';

$username='root';
$password='';

try{
	$con = new PDO($dsn,$username,$password);

	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $ex){
	echo 'Not Connected';
}

$pnum = "";
$pdate = "";
$empco = "";
$supno = "";


function getPosts(){
	$posts = array();

	$posts[0] = $_POST['pnum'];
	$posts[1] = $_POST['pdate'];
	$posts[2] = $_POST['empco'];
	$posts[3] = $_POST['supno'];

	return $posts;
}

// Insert Details
if(isset($_POST['insert'])){
	$data = getPosts();
	if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4])){
		echo 'Enter Order Data To Insert';
	}else{
		$insertStmt = $con->prepare('INSERT INTO abc_company (po_num,	po_date,	emp_code,	sup_no) VALUES (:pnum,:pdate,:empco,:supno)');
		$insertStmt->execute(array(
		':pnum' => $data[0],
		':pdate' => $data[1],
		':empco' => $data[2],
		':supno' => $data[3]
		));

		if($insertStmt){
			echo "Data Inserted";
		}
	}
}

// Search Details
if(isset($_POST['search'])){
	$data = getPosts();
	if(empty($data[0])){
		echo "Enter Order po number";
	}
	else {
		$searchStmt = $con->prepare('SELECT * FROM abc_company WHERE \po_num = :pnum');
		$searchStmt->execute(array(
			':reg' => $data[0]
		));
		if($searchStmt){
			$user = $searchStmt->fetch();

			$pnum = $user[0];
			$pdate = $user[1];
			$empco = $user[2];
			$supno = $user[3];
			

		}
	}
}

//update details

if(isset($_POST['update'])){
	$data = getPosts();
	if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4])){
		echo 'Enter Order Data To Update';
	}else{
		$updateStmt = $con->prepare('UPDATE abc_company  SET  po_num= :pnum, po_date= :pdate, emp_code =:empco, sup_no =:supno WHERE po_num=:pnum ');
		$updateStmt->execute(array(
		':pnum' => $data[0],
		':pdate' => $data[1],
		':empco' => $data[2],
		':supno' => $data[3],
		
		));

		if($updateStmt){
			echo "Data was updated";
		}
	}
}

//delete details
if (isset($_POST['delete'])) {
	$data = getPosts();
	if(empty($data[0])){
		echo "Enter Order Po No";
	}
	else {
		$deleteStmt = $con->prepare('DELETE FROM abc_company WHERE po_no=:pnum ');
		$deleteStmt->execute(array(
			':pnum' => $data[0]
		));
		if($deleteStmt){
			echo 'Record was deleted';
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Order Information</title>
	<style type="text/css">
	body{
	padding: 0;
	margin: 0;
	font-family: sans-serif;
	background: #FFCCFF
;


}
.box{
	width: 300px;
	padding: 40px;
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%,-50%);
	background: #FF6600
;
	text-align: center;

}
h1{
	color: white;
}

</style>
</head>
<body>
	
	<form class="box"action="order.php" method="POST">
	<h1>ORDER DETAILS</h1>
		<table>
					<tr>
				<td><label>ORDER PO NUMBER</label></td>
				<td><input type="text" name="pnum" value="<?php echo $pnum?>"></td>
			</tr>
			<tr>
				<td><label>PO DATE</label></td>
				<td><input type="text" name="pdate" value="<?php echo $pdate?>"></td>
			</tr>
			<tr>
				<td><label>EMPLOYEE CODE</label></td>
				<td><input type="text" name="empco" value="<?php echo $empco?>"></td>
			</tr>
			<tr>
				<td><label>SUPPLIER NUMBER</label></td>
				<td><input type="text" name="supno" value="<?php echo $supno?>"></td>
			</tr>
			
		</table>
		<input type="submit" name="insert" value="Insert">
		<input type="submit" name="update" value="Update">
		<input type="submit" name="search" value="Search">
		<input type="submit" name="delete" value="Delete">
	</form>

</body>
</html>