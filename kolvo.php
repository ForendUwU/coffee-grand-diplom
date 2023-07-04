<?php 
	session_start();
	include 'db.php';
	$infa = $_POST['val'];
	$idTovara = $_POST['id'];
	$a = $_SESSION['order'];

	$query=mysqli_query($connection,"update cart set kolvoTov='$infa' where idTov='$idTovara' and idZak='$a';");
	
	$sql = "SELECT sum(tovar.cena * cart.kolvoTov) as totalSum FROM tovar inner join cart on cart.idTov = tovar.ID where idZak='$a'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_array($result);

     $b = $_COOKIE['userID'];
	$sql1 = "SELECT bonusPoints FROM users where ID='$b'";
        $result1 = mysqli_query($connection, $sql1);
        $row1 = mysqli_fetch_array($result1);

        $arr = array();
        $arr['sum'] =$row['totalSum'];
        $arr['saleSum'] = round($row['totalSum'] - ($row1['bonusPoints'] * 0.001), 2);
         
                    
	echo json_encode($arr);
?>