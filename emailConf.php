<?php
include 'db.php';
 $msg='';
 if(!empty($_POST['email']) && isset($_POST['email']) &&  !empty($_POST['password']) &&  isset($_POST['password']) )
 {
// имя пользователя и пароль отправлены из формы
 $email=mysql_real_escape_string($_POST['email']);
 $password=mysql_real_escape_string($_POST['password']);
  $FIO=mysql_real_escape_string($_POST['FIO']);
 $date=mysql_real_escape_string($_POST['dataRoz']);
// регулярное выражение для проверки написания адреса электронной почты
 $regex = '/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/';
 if(preg_match($regex, $email))
 { 
 $password=md5($password); // encrypted password
 $activation=md5($email.time()); // encrypted email+timestamp
 $count=mysqli_query($connection,"SELECT ID FROM users WHERE e-mail='$email'");
 $id = mt_rand(0, 999999);
// проверка адреса электронной почты
 if(mysqli_num_rows($count) < 1)
 {
mysqli_query($connection,"INSERT INTO users VALUES('$id','$FIO', '$email', '$date', 0, '$password','$activation', default)");
// отправка письма на электронный ящик
include 'smtp/Send_Mail.php';
 $to=$email;
 $subject="Подтверждение электронной почты";
 $body='Здравствуйте! <br/> <br/> Мы должны убедиться в том, что вы человек. Пожалуйста, подтвердите адрес вашей электронной почты, и можете начать использовать ваш аккаунт на сайте. <br/> <br/> <a href="'.$base_url.'activation/'.$activation.'">'.$base_url.'activation/'.$activation.'</a>';

Send_Mail($to,$subject,$body);
 $msg= "Регистрация выполнена успешно, пожалуйста, проверьте электронную почту."; 
 }
 else
 {
 $msg= 'Данный адрес электронный почты уже занят, пожалуйста, введите другой. '; 
 }
 }
 else
 {
 $msg = 'Адрес, введенный вами, неверен. Пожалуйста, попробуйте еще раз.'; 
 }
 }
// HTML часть
?>