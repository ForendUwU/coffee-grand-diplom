<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Coffee Grand</title>
        <link rel="stylesheet" href="Bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="Bootstrap/css/fontawesome.min.css">
        <link rel="stylesheet" href="styles.css">
        <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
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
                        <li class="active"><a href="sale.php">Скидка</a></li>
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
                                echo "<li><a href='loginForm.php'>Вход</a></li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

        <div id="headerwrap-menu">
            <div class="container">
                <div class="row centered">
                    <div class="col-lg-8 col-lg-offset-2">
                        <h1>Скидка</h1>
                        <h2>Здесь находится ваш личный QR-код. Покажите его при заказе и получите бонусные баллы</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="qr">
            <div class="container">
                <div class="row centered">
                <?php 
                    include 'db.php';
                    if ($_COOKIE["user"] == 1)
                    {
                        $user = $_COOKIE["userID"];
                        echo "<img src='http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=".$user."'>";
                    }

                    if ($_COOKIE["admin"] == 1)
                    {

                        echo "<video id='preview' class = 'embed-responsive-item'></video>
                        <script type='text/javascript'>
                        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
                        scanner.addListener('scan', function (content) {
                            res.innerHTML = content;
                            $('#res').css({'color' : 'red'});

                            $.ajax({
                                type: 'POST',
                                url: 'getPoints.php',
                                data: {userID:content},
                                success: function(data) {
                                    result = JSON.parse(data);
                                    $('#res').html(content).css({'color' : 'green'});
                                },
                                fail: function(data) {
                                    $('#res').html(content).css({'color' : 'red'});
                                }
                            });
                        });
                        Instascan.Camera.getCameras().then(function (cameras) {
                            if (cameras.length > 0) {
                                scanner.start(cameras[0]);
                            } else {
                                console.error('No cameras found.');
                            }
                        }).catch(function (e) {
                            console.error(e);
                        });
                        </script>
                        <p id = 'res'></p>";


                    }

                    if ($_COOKIE["user"] == 0 && $_COOKIE["admin"] == 0) 
                    {
                        echo "<div class='container needEn'>
                            <div class='row centered'>
                            <h1>Для того, чтобы воспользоваться скидкой, войдите в свой профиль</h1>
                            </div>
                        </div>";
                    }

                
                ?>
                </div>
            </div>
        </div>

        
        <div id="f">
            <div class="container">
                <div class="row centered">
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitch"></i></a>
                </div>
            </div>
        </div>
        </footer>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="Bootstrap/js/bootstrap.min.js"></script>
        
            
    </body>
</html>
