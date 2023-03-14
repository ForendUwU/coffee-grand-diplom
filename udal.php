<?php 
	session_start();
	include 'db.php';
	$infa = $_POST['idTov'];
	$query=mysqli_query($connection,"delete from cart where idTov=".$infa);
	var_dump($infa);

	$zakazNum = $_SESSION['order'];
    $sql2 = "SELECT sum(kolvoTov) as totalKolvo FROM cart where idZak='$zakazNum'";
    $result2 = mysqli_query($connection, $sql2);
    $row2 = mysqli_fetch_array($result2);
    $_SESSION['kolvo'] = $row2['totalKolvo'];
    echo $_SESSION['kolvo'];

	header("Location: cartPage.php")
?>