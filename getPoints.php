<?php 
	session_start();
	include 'db.php';

	$id = $_POST['userID'];

	$sql2 = "SELECT bonusPoints FROM users where ID='$id'";
    $result2 = mysqli_query($connection, $sql2);
    $row2 = mysqli_fetch_array($result2);
    $points = $row2['bonusPoints'];

    if (is_null($row2['bonusPoints'])) {
    	echo json_encode(0);
    }else{
    	echo json_encode(1);
    }
	
    $points += 200;

	$query=mysqli_query($connection,"update users set bonusPoints='$points' where ID='$id'; ");
?>