<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Coffee Grand</title>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
        
        <link rel="stylesheet" href="Bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="Bootstrap/css/fontawesome.min.css">
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="loginStyles.css">
        
    </head>
    <body>
        <?php

        include 'db.php';
        $msg='';
        $check = 0;
        $success = false;
        if(!empty($_POST['email']) && isset($_POST['email']) &&  !empty($_POST['password']) &&  isset($_POST['password']) )
        {
            $check = 1;
            // имя пользователя и пароль отправлены из формы
            $email=$_POST['email'];
            $password=$_POST['password'];
            $FIO=$_POST['FIO'];
            $date=$_POST['dataRoz'];
            $passCheck=$_POST['repeatPass'];
            // регулярное выражение для проверки написания адреса электронной почты
            
            //$password=md5($password); // encrypted password
            $activation=md5($email.time()); // encrypted email+timestamp
            $count=mysqli_query($connection,"SELECT ID FROM users WHERE email='$email'");
            $id = mt_rand(100000, 999999);
            // проверка адреса электронной почты
            if(mysqli_num_rows($count) < 1)
            {
                echo "<script>swal({
                color: '#fff',
                title: 'Регистрация выполнена успешно, пожалуйста, проверьте электронную почту.',
                width: '600px',
                confirmButtonColor: '#ff7878',
                background: '#292929',

                });</script>";
                //$msg = "";
                $success = true;
                mysqli_query($connection,"INSERT INTO users VALUES('$id','$FIO', '$email', '$date', 0, '$password','$activation', default)");
                // отправка письма на электронный ящик
                include 'smtp/Send_Mail.php';
                $to=$email;
                $subject="Подтверждение электронной почты";
                $body='Здравствуйте! <br/> <br/> Пожалуйста, подтвердите адрес вашей электронной почты, и можете начать использовать ваш аккаунт на сайте. <br/> <br/> <a href="'.$base_url.'activation.php?code='.$activation.'">'.$base_url.'activation/'.$activation.'</a>';

                
                Send_Mail($to,$subject,$body);
                
            }
            else
            {
                $msg= 'Данный адрес электронный почты уже занят, пожалуйста, введите другой. '; 
            }
            
        }
        ?>
        <script src="https://kit.fontawesome.com/b488d68d7d.js" crossorigin="anonymous"></script> 
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">COFFEE GRAND <i class="fa-solid fa-mug-saucer"></i></a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="mainPage.php">Главная</a></li>
                        <li><a href="MenuPage.php">Меню</a></li>
                        <li><a href="sale.php">Скидка</a></li>
                        <?php

                        if (!isset($_COOKIE["admin"]) or !isset($_COOKIE["user"])) {
                                setcookie("admin", 0);
                                setcookie("user", 0);
                            }
                            
                            if ($_COOKIE["admin"] == 1)
                            {
                                 echo "<li><a href='adminPanel.php'>Панель администратора</a></li>";
                                 echo "<li><a href='profilePage.php'><i class='fa-solid fa-user'></i></a></li>";
                            }

                            if ($_COOKIE["user"] == 1)
                            {
                                 echo "<li><a href='profilePage.php'><i class='fa-solid fa-user'></i></a></li>";
                            }

                            if ($_COOKIE["admin"] == 0 and $_COOKIE["user"] == 0) {
                                echo "<li class = 'active'><a href='loginForm.php'>Вход</a></li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>


         <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="container1">
        <div class="login-container">
            <?php 

            if ($check == 0) {
                echo "<input id='item-1' type='radio' name='item' class='sign-in' checked><label for='item-1' class='item'>Вход</label>";
                echo "<input id='item-2' type='radio' name='item' class='sign-up'><label for='item-2' class='item'>Регистрация</label>";
            }elseif ($check == 1) {
                echo "<input id='item-1' type='radio' name='item' class='sign-in'><label for='item-1' class='item'>Вход</label>";
                echo "<input id='item-2' type='radio' name='item' class='sign-up' checked><label for='item-2' class='item'>Регистрация</label>";
            }
                
            
            
            ?>

            <div class="login-form">
                <form action="signIn.php" method="POST" id="sendLogin">
                <div class="sign-in-htm">
                    <div class="group">
                        <input placeholder="E-mail" id="user" type="text" class="input" name="mail">
                    </div>
                    <div class="group">
                        <input placeholder="Пароль" id="pass" type="password" class="input" data-type="password" name="password1">
                    </div>

                    <div class="group">
                        <input type="submit" class="button" value="Войти">
                    </div>
                    <div class="hr"></div>
                    <div class="footer">
                        <p class='msg' id='errormsg'><?php 
                        if (!empty($_GET['error'])) {
                            echo $_GET['error'] ;
                        }
                        
                        ?></p>
                        <!--<a href="#forgot">Забыли пароль?</a>-->
                    </div>
                </div>
                </form>


                <form action="" method="POST" id="send">
                <div class="sign-up-htm">
                    <div class="group">
                        <input placeholder="ФИО" id="user" type="text" class="input reg" name="FIO">
                    </div>

                    <div class="group">
                        <input placeholder="E-mail" id="emailCheck" type="text" class="input reg" name="email" value="">
                    </div>

                    <div class="group">
                        <input onfocus="(this.type='date')" onblur="(this.type='text')" type = "text" max="" placeholder="Дата рождения" id="user dat" type="text" class="input reg" name="dataRoz">
                    </div>

                    <div class="group">
                        <input placeholder="Пароль" id="pass passcheck" type="password" class="input reg" data-type="password" name="password">
                    </div>
                    <div class="group">
                        <input placeholder="Повторите пароль" id="pass secondPass" type="password" class="input reg" data-type="password" name="repeatPass">
                    </div>

                    <div class="group">
                        <input type="submit" class="button" value="Зарегистрироваться">
                    </div>
                    </form>
                    <div class="hr"></div>
                    <div class="footer">
                        <p class='msg' id='errormsg1'><?php echo $msg; ?></p>
                        
                            
                         
                        
                        <label for="item-1">Уже есть аккаунт?</a> 
                </div>
            </div>
        </div>
    </div>

        <script> 

            document.getElementById('send').addEventListener("submit", function(e) {
                
                if (document.getElementById('pass passcheck').value != document.getElementById('pass secondPass').value) 
                {
                    swal({
                        color: '#fff',
                        title: "Пароли не совпадают",
                        width: '600px',
                        heightAuto: 'false',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                    });
                    e.preventDefault();
                    return false;
                }

                if (document.getElementById('pass passcheck').value.length < 6) 
                {
                    swal({
                        color: '#fff',
                        title: "Пароль должен быть больше 6 символов",
                        width: '600px',
                        heightAuto: 'false',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                    });
                    e.preventDefault();
                    return false;
                }

                var regInputs = document.getElementsByClassName('reg');
                for (var i = regInputs.length - 1; i >= 0; i--) {
                    if (regInputs[i].value == "") 
                    {
                        swal({
                        color: '#fff',
                        title: "Не все поля заполнены",
                        width: '600px',
                        heightAuto: 'false',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                        });
                        e.preventDefault();
                        return false;
                    }
                }
                
                if (Date.parse(document.getElementById('user dat').value) >= new Date()) 
                {
                    swal({
                        color: '#fff',
                        title: "Дата рождения не может быть больше текущей",
                        width: '600px',
                        heightAuto: 'false',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                    });
                    e.preventDefault();
                    return false;
                }

                if (Date.parse(document.getElementById('user dat').value) <= new Date(1902, 1, 1, 0, 0, 0, 0)) 
                {
                    swal({
                        color: '#fff',
                        title: "Некоректная дата рождения",
                        width: '600px',
                        heightAuto: 'false',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                    });
                    e.preventDefault();
                    return false;
                }

                const regEmail = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/;
                if (!regEmail.test(document.getElementById('emailCheck').value)) 
                {
                    swal({
                        color: '#fff',
                        title: "Неверный формат email",
                        width: '600px',
                        heightAuto: 'false',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                    });
                    e.preventDefault();
                    return false;
                }

                
            });

            
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="Bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>