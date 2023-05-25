<?php 
include 'db.php';

echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js'></script>";

$table = $_COOKIE["table_name"];

if (isset($_POST["sub"])) {
	$dobOrDel = $_POST["sub"];
}


if ($dobOrDel == 'dobav') {

	if ($table == 'users') {
		$a=$_POST["FIO"];
		$b=$_POST["email"];
		$c=$_POST["dataRozd"];
		$d=$_POST["kolvoBonus"];
		$e=$_POST["parol"];
		$f=$_POST["activCode"];
		$g=$_POST["status"];

    	if ($g == 'Статус активации профиля - 1') {
    		$g = 1;
    	}else{ $g=0; }

		$query=mysqli_query($connection,"insert into users values(".rand(100000, 999999).", '$a', '$b', '$c', $d, '$e', '$f', '$g')");
		if ($query==true)
			{
				
				header("Location: adminPanel.php"); 
			}
		else echo "Ошибка";
		mysqli_close($connection);
	}elseif ($table == 'zakazy') {
		$a=$_POST["userID"];
		$b=$_POST["dataZakaza"];
		$c=$_POST["vremyaZak"];
		$d=$_POST["sumZak"];

		$query=mysqli_query($connection,"insert into zakazy values(default, '$a', '$b', '$c', $d)");
		if ($query==true)
			{
				
				header("Location: adminPanel.php"); 
			}
		else echo "Ошибка";
		mysqli_close($connection);
	}elseif ($table == 'tovar') {
		$a=$_POST["naim"];
		$b=$_POST["opis"];
		$c=$_POST["cena"];
		$d=$_POST["photo"];
		$e=$_POST["cat"];

		$query=mysqli_query($connection,"insert into tovar values(default, '$a', '$b', '$c', '$d', '$e')");
		if ($query==true)
			{
				
				header("Location: adminPanel.php"); 
			}
		else echo "Ошибка";
		mysqli_close($connection);
	}elseif ($table == 'category') {
		$a=$_POST["categoryInp"];

		$query=mysqli_query($connection,"insert into category values(default, '$a')");
		if ($query==true)
			{
				
				header("Location: adminPanel.php"); 
			}
		else echo "Ошибка";
		mysqli_close($connection);
	}elseif ($table == 'cart') {
		$a=$_POST["idZak"];
		$b=$_POST["idTov"];
		$c=$_POST["kolvo"];

		$query=mysqli_query($connection,"insert into cart values(default, '$a', '$b', '$c')");
		if ($query==true)
			{
				
				header("Location: adminPanel.php"); 
			}
		else echo "Ошибка";
		mysqli_close($connection);
	}
}
else
{
	if ($table == 'users') {
		$a=$_POST["forUdal"];

		$query=mysqli_query($connection,"delete from users where ID=$a");
		if ( $query==true) header("Location: adminPanel.php");
		else echo "Ошибка";
		mysqli_close($connection);
	}

	if ($table == 'zakazy') {
		$a=$_POST["forUdal"];

		$query=mysqli_query($connection,"delete from zakazy where ID=$a");
		if ( $query==true) header("Location: adminPanel.php");
		else echo "Ошибка";
		mysqli_close($connection);
	}

	if ($table == 'tovar') {
		$a=$_POST["forUdal"];

		$query=mysqli_query($connection,"delete from tovar where ID=$a");
		if ( $query==true) header("Location: adminPanel.php");
		else echo "Ошибка";
		mysqli_close($connection);
	}

	if ($table == 'category') {
		$a=$_POST["forUdal"];

		$query=mysqli_query($connection,"delete from category where ID=$a");
		if ( $query==true) header("Location: adminPanel.php");
		else echo "Ошибка";
		mysqli_close($connection);
	}

	if ($table == 'cart') {
		$a=$_POST["forUdal"];

		$query=mysqli_query($connection,"delete from cairo_ps_surface_restrict_to_level(surface, level) where ID=$a");
		if ( $query==true) header("Location: adminPanel.php");
		else echo "Ошибка";
		mysqli_close($connection);
	}
}
?>

