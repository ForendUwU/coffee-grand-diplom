<?php 
	session_start();
	include 'db.php';

	$isBonus = $_POST['bonus'];

	$a = $_SESSION['order'];
	$sql3 = "SELECT bonusPoints FROM users inner join zakazy on users.ID = zakazy.idUser where zakazy.ID='$a'";
    $result3 = mysqli_query($connection, $sql3);
    $row3 = mysqli_fetch_array($result3);
    $bonusPointsVal = $row3['bonusPoints'];


	$sql2 = "SELECT sum(tovar.cena * cart.kolvoTov) as totalSum FROM tovar inner join cart on cart.idTov = tovar.ID where idZak='$a'";
    $result2 = mysqli_query($connection, $sql2);
    $row2 = mysqli_fetch_array($result2);
    $sum = $row2['totalSum'];


	$user = $_COOKIE['userID'];
    if ($isBonus == 1) {
    	$check = $sum - ($bonusPointsVal * 0.001);
    	if ($check < 0) {
    		$updatedPoints = $bonusPointsVal - ($sum * 1000);
    		$query=mysqli_query($connection,"update users set bonusPoints = ".$updatedPoints." where ID='$user'; ");
    	}
    	else
    	{
			$sum = $sum - ($bonusPointsVal * 0.001);
    		$query=mysqli_query($connection,"update users set bonusPoints = 0 where ID='$user'; ");
    	}
    }
    else
    {
    	$query=mysqli_query($connection,"update users set bonusPoints = bonusPoints + 200 where ID='$user'; ");
    }
    

	
	$query=mysqli_query($connection,"update zakazy set idUser='$user', dateZak = CURDATE(), vremyaZak = CURTIME(), sumZakaza = '$sum' where ID='$a'; ");

	unset($_SESSION['order']);
	$query=mysqli_query($connection,"insert into zakazy values (default, '$user', 1999-01-01, '00:00:00', 0); ");
	$_SESSION['kolvo'] = 0;
	$_SESSION['successZak'] = 1;
	header("Location: MenuPage.php")
?>