<?php 
	include 'db.php';
	$email=$_POST['mail'];
    $password=$_POST['password1'];
    $count=mysqli_query($connection,"SELECT ID FROM users WHERE email='$email'");
    if (mysqli_num_rows($count) < 1) {
    	header("Location: loginForm.php?error=Проверьте адрес электронной почты");
    }
    else
    {
    	$countPass=mysqli_query($connection,"SELECT ID FROM users WHERE email='$email' and pass = '$password'");
    	if (mysqli_num_rows($countPass) < 1) {
    		header("Location: loginForm.php?error=Неверный пароль");
    	}
    	else
    	{
    		$countStatus=mysqli_query($connection,"SELECT ID FROM users WHERE email='$email' and pass = '$password' and status = '1'");
    		if (mysqli_num_rows($countStatus) < 1) {
    			header("Location: loginForm.php?error=Подтвердите свой аккаунт на почте");
    		}
    		else
    		{
                $row = mysqli_fetch_array($countStatus);
                setcookie("userID", $row['ID']);
    			setcookie("user", 1);
                if ($email == "1195076@mtp.by" and $password == "adminn") {
                    setcookie("admin", 1);
                    setcookie("user", 0);
                }
    			header("Location: mainPage.php");
    		}
    		
    	}
    }
	
?>