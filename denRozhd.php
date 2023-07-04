<?php 
	session_start();
	include 'db.php';
	include 'smtp/Send_Mail.php';

	$sql1 = "SELECT ID, email FROM users where DATE_FORMAT(dateRozhd, '%m-%d') = DATE_FORMAT(NOW(), '%m-%d')";
    $result1 = mysqli_query($connection, $sql1);

    if ($result1->num_rows > 0) 
    {
		$usersEmails = array();
		while($row1 = mysqli_fetch_array($result1)) 
		{
        	//$usersEmails[] = $row1["email"];
        	array_push($usersEmails, $row1["email"]);
    	}

    	foreach ($usersEmails as $userEmail) 
		{
			$query=mysqli_query($connection,"update users set bonusPoints = bonusPoints + 3000 where email='$userEmail'; ");

			try {
    		$to=$userEmail;
    		$subject="Поздравляем с днём рождения";
    		$body='Здравствуйте! Поздравляем вас с этим прекрасным днём.
    		<br>
    		В подарок вы получаете 3000 бонусных баллов, которые вы можете использовать на сайте при заказе!';
    		Send_Mail($to,$subject,$body);
    		}
    		catch (Exception $e) {
    			   				$_SESSION['den'] = 1;
				header('Location: adminPanel.php');
			}


		}	
	}

	$_SESSION['den'] = 1;
	header('Location: adminPanel.php');
?>