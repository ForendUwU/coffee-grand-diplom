<?php
include 'db.php';
 $msg='';
 if(!empty($_GET['code']) && isset($_GET['code']))
 {
 $code=$_GET['code'];
 $c=mysqli_query($connection,"SELECT ID FROM users WHERE activation='$code'");
 if(mysqli_num_rows($c) > 0)
 {
 $count=mysqli_query($connection,"SELECT ID FROM users WHERE activation='$code' and status='0'");
 if(mysqli_num_rows($count) == 1)
 {
mysqli_query($connection,"UPDATE users SET status='1' WHERE activation='$code'");
setcookie("user", 1);
$row = mysqli_fetch_array($count);
setcookie("userID", $row['ID']);
header("Location: mainPage.php");

 $msg="Ваш аккаунт активирован"; 
 }
 else
 {
 $msg ="Ваш аккаунт уже активирован, нет необходимости активировать его снова.";
 header("Location: mainPage.php");
 }
 }
 else
 {
 $msg ="Неверный код активации.";
 }
 }
?>
<?php echo $msg; ?>