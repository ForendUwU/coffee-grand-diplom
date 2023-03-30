<?php
function Send_Mail($to,$subject,$body)
{

require 'PHPMailer.php';
    require 'SMTP.php';
    require 'Exception.php';
    // Формирование самого письма
    
    
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
        $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};
    // Настройки вашей почты
    $mail->Host       = 'smtp.mail.ru'; // SMTP сервера вашей почты
    $mail->Username   = 'coffeegrandhelper@mail.ru'; // Логин на почте
    $mail->Password   = 'UMtMy0efXcVTcNm2L7MX'; // Пароль на почте
    $mail->Port       = 465;
    $mail->SMTPSecure = "ssl";
    $mail->setFrom('coffeegrandhelper@mail.ru', 'Помощник Coffee Grand'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress($to);
    
    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body; 
	$mail->send();

}
?>