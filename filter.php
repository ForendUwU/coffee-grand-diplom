<?php 
	include 'db.php';
	$idCategory = $_POST['id'];

	if ($idCategory == 999) {
		$sql = 'SELECT ID, naim, opis, cena, photo FROM tovar';
	}
	else
	{
		$sql = 'SELECT ID, naim, opis, cena, photo FROM tovar where idCat = '.$idCategory;
	}
	
    $result = mysqli_query($connection, $sql);
    $arr = array();
    $b = 0;
    while ($row = mysqli_fetch_array($result))
    {
    	 $b++;
    	// array_push($arr, 'naim' => $row['naim'], 'opis' => $row['opis'], 'cena' => $row['cena'], 'photo' => $row['photo'], 'id' => $row['ID']);
    	$arr['naim'][$b] = $row['naim'];
    	$arr['opis'][$b] = $row['opis'];
    	$arr['cena'][$b] = $row['cena'];
    	$arr['photo'][$b] = $row['photo'];
    	$arr['id'][$b] = $row['ID'];
    }

    echo json_encode($arr);
?>