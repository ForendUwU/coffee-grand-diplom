<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Coffee Grand</title>
        <link rel="stylesheet" href="Bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="Bootstrap/css/fontawesome.min.css">
        <link rel="stylesheet" href="styles.css">
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
                        <li><a href="sale.php">Скидка</a></li>
                        <?php 
                        //setcookie("admin", "", time() - 3600);
                        //setcookie("user", "", time() - 3600);
                            if (!isset($_COOKIE["admin"]) or !isset($_COOKIE["user"])) {
                                setcookie("admin", 0);
                                setcookie("user", 0);
                            }
                            
                            if ($_COOKIE["admin"] == 1)
                            {
                                 
                                 echo "<li class='active'><a href='profilePage.php'><i class='fa-solid fa-user'></i></a></li>";
                            }

                            if ($_COOKIE["user"] == 1)
                            {
                                 echo "<li  class='active'><a href='profilePage.php'><i class='fa-solid fa-user'></i></a></li>";
                            }

                            if ($_COOKIE["admin"] == 0 and $_COOKIE["user"] == 0) {
                                echo "<li><a href='loginForm.php'>Вход</a></li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

        <div id="headerwrap-profile">
            <div class="container">
                <div class="row centered">
                    <div class="col-lg-8 col-lg-offset-2">
                        <h1>Профиль</h1>
                        <i class='fa-solid fa-user'></i>
                        <?php 
                            include 'db.php';
                            $user = $_COOKIE["userID"];
                            $res=mysqli_query($connection,"SELECT FIO FROM users WHERE ID='$user'");
                            $row = mysqli_fetch_array($res);
                            echo "<h2>".$row["FIO"]."</h2>";
                            $res=mysqli_query($connection,"SELECT bonusPoints FROM users WHERE ID='$user'");
                            $row = mysqli_fetch_array($res);
                            echo "<h3>Бонусные баллы: ".$row["bonusPoints"]."</h3>";
                         ?>
                         <form action="logOut.php" method="POST"><button type="submit" class="btn">Выход</button></form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container wb">
            <div class="row centered">
                <br><br>
                <div class="col-lg-8 col-lg-offset-2">
                    <h4>История заказов</h4>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-6">
                    <h3>Дата</h3>
                    <hr>
                    <?php 
                        session_start();
                        include 'db.php';
                        $sql = 'SELECT dateZak FROM zakazy where idUser='.$_COOKIE["userID"].' and dateZak != 0000-00-00';
                        $result = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_array($result))
                        {   
                            echo "<h3>".$row['dateZak']."</h3>";
                        }
                        mysqli_close($connection);
                    ?>
                    <hr>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-6">
                    <h3>Сумма</h3>
                    <hr>
                    <?php 
                        include 'db.php';
                        $sql = 'SELECT sumZakaza FROM zakazy where idUser='.$_COOKIE["userID"].' and dateZak != 0000-00-00';
                        $result = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_array($result))
                        {   
                            echo "<h3>".$row['sumZakaza']." руб.</h3>";
                        }
                        mysqli_close($connection);
                    ?>
                    <hr>
                </div>
                

                
            </div>
        </div>

        <!--
        <div id="dg">
            <div class="container">
                <div class="row centered">
                    <h4>Last works</h4>
                    <br>
                    <div class="col-lg-4">
                        <div class="tilt">
                            <a href="#"><img src="img/1.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="tilt">
                            <a href="#"><img src="img/1.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="tilt">
                            <a href="#"><img src="img/1.png" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -->

        <!--<div class="container wb">
            <div class="row centered">
                <br><br>
                <div class="col-lg-8 col-lg-offset-2">
                    <h4>Атмосфера</h4>
                    <p>Кофейни всегда ассоциируются с обычной точкой продажи напитков и выпечки. Но кофейня — это прежде всего место, где вы можете отдохнуть душой.
                    Наше семейное заведение с первого посещения располагает к себе искренностью и душевностью, уютом и дружелюбием, ведь не даром оно называется именно «Кофта» — слово, которое у каждого вызовет ассоциацию с комфортом и теплом.</p>
                    <p><br><br></p>
                </div>
                <div class="col-lg-2"></div>
                <div class="col-lg-10 col-lg-offset-1">
                    <img src="img/cafe.jpg" alt="" class="img-responsive">
                </div>
            </div>
        </div>
        -->

        <!--
        <div id="lg">
            <div class="container">
                <div class="row centered">
                    <h4>PArtners</h4>
                    <div class="col-lg-2 col-lg-offset-1">
                        <img src="img/1.png" alt="">
                    </div>
                    <div class="col-lg-2">
                        <img src="img/1.png" alt="">
                    </div>
                    <div class="col-lg-2">
                        <img src="img/1.png" alt="">
                    </div>
                    <div class="col-lg-2">
                        <img src="img/1.png" alt="">
                    </div>
                    <div class="col-lg-2">
                        <img src="img/1.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        -->

        <!--<div id="r">
            <div class="container">
                <div class="row centered">
                    <div class="col-lg-8 col-lg-offset-2">
                        <h4>Получите кофе бесплатно!</h4>
                        <p>Перейдите на вкладку меню, зарегестрируйтесь и получите бонусные баллы, которое вы сможете потратить, чтобы получить кофе абсолютно бесплатно!</p>
                    </div>
                </div>
            </div>
        </div>
    -->

        <div id="f">
            <div class="container">
                <div class="row centered">
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitch"></i></a>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="Bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>