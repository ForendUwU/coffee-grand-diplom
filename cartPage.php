<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Coffee Grand</title>
        <link rel="stylesheet" href="Bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="Bootstrap/css/fontawesome.min.css">
        <link rel="stylesheet" href="styles.css">
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
                        <li class="active"><a href="MenuPage.php">Меню</a></li>
                        <li><a href="sale.php">Скидка</a></li>
                        <?php
                        session_start();
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
                        <h1>Корзина</h1>
                        <h2>Здесь вы можете просмотреть ваш заказ</h2>
                        <div class='back zak'><a href="MenuPage.php"><button>Вернуться к меню</button></a></div>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($_SESSION['kolvo'] != 0) {?>
        <div class="container w">
            <div class="row centered">
                
                <div class="col-lg-8 col-lg-offset-2">
                    <h4>Содержание заказа</h4>
                </div>
            </div>
            <br>

            <div class="row row-cols-2 ins row-cols-lg-4 g-3 centered tovrow">
                
                <?php 
                    

                    include 'db.php';


                    $sql = 'SELECT tovar.naim, tovar.photo, tovar.opis, tovar.cena, tovar.ID, cart.idTov, cart.kolvoTov FROM tovar inner join cart on cart.idTov = tovar.ID where idZak='.$_SESSION["order"]; 
                    $result = mysqli_query($connection, $sql);
                    while ($row = mysqli_fetch_array($result))
                    {   
                        echo "<div class='col mt-4 tov' style='min-width:250px; max-width:250px;'>
                        <img src=img/".$row['photo']." alt=''>
                        <h4>".$row['naim']."</h4>
                        <h3>".$row['opis']."</h3>
                        <h4>".$row['cena']." руб.</h4>
                        <h3 class='kolvoh'><input type='number' id=".$row['idTov']." class='form-control kolvoInp' value='".$row['kolvoTov']."'></input></h3>
                        <form method='POST' action='udal.php'><button class='fb trashBtn' value=".$row['idTov']." name='idTov' type='submit'>Удалить</button></form>
                        </div>";
                    }
                    if (isset($_POST["addBtn"])) {
                        if (!isset($_SESSION["order"])) {
                            $sql = 'SELECT max(ID) as maxId FROM zakazy';
                            $result = mysqli_query($connection, $sql);
                            $row = mysqli_fetch_array($result);
                            $_SESSION["order"] = $row['maxId'];
                        }
                            

                            $sql1 = 'SELECT kolvoTov FROM cart where idZak = '.$_SESSION["order"].' and idTov ='.$_POST["addBtn"];
                            $result1 = mysqli_query($connection, $sql1);
                            $row1 = mysqli_fetch_array($result1);
                            if ($row1) {
                                $query=mysqli_query($connection,'UPDATE cart SET kolvoTov=kolvoTov + 1 where idZak = '.$_SESSION["order"].' and idTov ='.$_POST["addBtn"]);
                            }
                            else
                            {
                                $query=mysqli_query($connection,"insert into cart values(default, ".$_SESSION["order"].",".$_POST["addBtn"].",'1')");
                            }
                            

                            
                    }
                ?>
                
            </div>

                
                

               
            

            <?php 
                        include 'db.php';
                        $sql = 'SELECT sum(tovar.cena * cart.kolvoTov) as totalSum FROM tovar inner join cart on cart.idTov = tovar.ID where idZak='.$_SESSION["order"];
                        $result = mysqli_query($connection, $sql);
                        $row = mysqli_fetch_array($result);

                        
                        $sql1 = 'SELECT bonusPoints FROM users where id='.$_COOKIE['userID'];
                        $result1 = mysqli_query($connection, $sql1);
                        $row1 = mysqli_fetch_array($result1);
                        $sumWithSale = $row['totalSum'] - ($row1['bonusPoints'] * 0.001);

                        echo "<h4 id='sum'>Общая сумма заказа: ".$row['totalSum']." руб.</h4>";
                        if ($sumWithSale < 0) {
                            echo "<h4 id='saleSum'>Сумма заказа с бонусными баллами: 0 руб.</h4>";
                        }
                        else
                        {
                            echo "<h4 id='saleSum'>Сумма заказа с бонусными баллами: ".$sumWithSale." руб.</h4>";    
                        }
                        
                        

                        mysqli_close($connection);
            ?>

        </div>
    

        <div class="container">
            <div class="row centered">
                <!--<form method="POST" action="oform.php">-->
                <div class='back zak'><button id="zakBtn">Заказать</button></div>
               <!--</form>-->
            
            </div>   
        </div>
        <br><br> 

        <?php }else{ ?>

            <div class=" empty">
                <h1>Корзина пуста</h1>
            </div>

        <?php } ?>

        <?php if ($_SESSION['kolvo'] == 0) {?>
        <footer>
        <?php } ?>
            
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

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.15/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.15/dist/sweetalert2.min.css">
        <script>
            document.addEventListener("DOMContentLoaded", function() {
            if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                var els = document.querySelectorAll(".kolvoInp");
                for (var i = 0; i < els.length; i++) {
                els[i].classList.add('kolvoInpM');
                els[i].classList.remove('kolvoInpD');
                }
            } else {
                var els = document.querySelectorAll(".kolvoInp");
                for (var i = 0; i < els.length; i++) {
                els[i].classList.add('kolvoInpD');
                els[i].classList.remove('kolvoInpM');
                }
            }
            });
            




            var btn = document.getElementById('zakBtn');
            btn.addEventListener("click", function () { 
                Swal.fire({
                    title: '<p style="color:black">Хотите ли вы использовать бонусные баллы?</p> <p></p>',
                    showConfirmButton: true,
                    confirmButtonColor: '#34eb5e',
                    confirmButtonText: 'Да',
                    showDenyButton: true,
                    denyButtonColor: '#ff7878',
                    denyButtonText: 'Нет',
                    showCancelButton: true,
                    cancelButtonText: 'Отмена'
                }).then((result) => {
                    if (result.isConfirmed) 
                    {
                        let isBonus = 1;
                        $.ajax({
                        type: "POST",
                        url: 'oform.php',
                        data: {bonus:isBonus},
                        success: function(data) {
                            var url = "http://localhost/diplom/MenuPage.php?success=1";
                            $(location).attr('href',url);

                            },
                        error: function(data) {
                            alert("Что то пошло не так(");
                            }
                        });
                    }
                    else if(result.isDenied)
                    {
                        let isBonus = 0;
                        $.ajax({
                        type: "POST",
                        url: 'oform.php',
                        data: {bonus:isBonus},
                        success: function(data) {
                            var url = "http://localhost/diplom/MenuPage.php?success=1";
                            $(location).attr('href',url);

                            },
                        error: function(data) {
                            alert("Что то пошло не так(");
                            }
                        });
                    }
                })

            });

            

            $('.kolvoInp').change(function() {
                var kolvoTov = $(this).val();
                
                var idTov = $(this).attr('id');
                console.log(idTov);
                    if(!/^[0-9]+$/.test(kolvoTov) || kolvoTov <= 0)
                    {
                        $(this).val(1);
                        Swal.fire({
                        title: '<p style="color:black">Неправильный формат количества</p>',
                        showConfirmButton: true,
                        confirmButtonColor: '#ff7878',
                        });
                        var kolvoTov = $(this).val();

                        $.ajax({
                        type: "POST",
                        url: 'kolvo.php',
                        data: {val:kolvoTov, id:idTov},
                        success: function(data) {
                            result = JSON.parse(data);
                            $('#sum').html("Общая сумма заказа: " + result.sum + " руб.");
                            
                            if (result.saleSum < 0)
                            {
                                $('#saleSum').html("Сумма заказа с использованием бонусных баллов: 0 руб.");
                            }
                            else
                            {
                                $('#saleSum').html("Сумма заказа с использованием бонусных баллов: " + result.saleSum + " руб.");
                            }
                            

                        },
                        error: function(data) {
                            alert("Что то пошло не так(");
                        }
                    });


                    }
                    else
                    {
                        
                        $.ajax({
                        type: "POST",
                        url: 'kolvo.php',
                        data: {val:kolvoTov, id:idTov},
                        success: function(data) {
                            result = JSON.parse(data);
                            $('#sum').html("Общая сумма заказа: " + result.sum + " руб.");
                            
                            if (result.saleSum < 0)
                            {
                                $('#saleSum').html("Сумма заказа с использованием бонусных баллов: 0 руб.");
                            }
                            else
                            {
                                $('#saleSum').html("Сумма заказа с использованием бонусных баллов: " + result.saleSum + " руб.");
                            }

                        },
                        error: function(data) {
                            alert("Что то пошло не так(");
                        }
                    });
                    }
                    
             });
        </script>
    </body>
    </html>