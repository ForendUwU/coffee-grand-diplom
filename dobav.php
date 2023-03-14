<?php 
	session_start();
	include 'db.php';
	$idTovara = $_POST['id'];
	$a = $_SESSION['order'];

	$sql = "SELECT idTov FROM cart where idZak='$a' and idTov='$idTovara'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_array($result);

        if (is_null($row)) {
        	$query=mysqli_query($connection,"insert into cart values (default, '$a', '$idTovara', 1);");

        }
        else
        {
        	$sql1 = "SELECT kolvoTov FROM cart where idZak='$a' and idTov='$idTovara'";
        	$result1 = mysqli_query($connection, $sql1);
        	$row1 = mysqli_fetch_array($result1);
        	$b = $row1['kolvoTov'] + 1;

        	$query=mysqli_query($connection,"update cart set kolvoTov='$b' where idTov='$idTovara';");
        }

        $sql2 = "SELECT sum(kolvoTov) as totalKolvo FROM cart where idZak='$a'";
        $result2 = mysqli_query($connection, $sql2);
        $row2 = mysqli_fetch_array($result2);
        $_SESSION['kolvo'] = $row2['totalKolvo'];
	echo json_encode($row2['totalKolvo']);
?>