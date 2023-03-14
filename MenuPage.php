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
                        <li class="active"><a href="MenuPage.php">Меню</a></li>
                        <li><a href="sale.php">Скидка</a></li>
                        <?php
                        session_start();
                        include 'db.php';
                        if (!isset($_SESSION["order"])) {
                            $sql = 'SELECT max(ID) as maxId FROM zakazy';
                            $result = mysqli_query($connection, $sql);
                            $row = mysqli_fetch_array($result);
                            $_SESSION["order"] = $row['maxId'];
                        }

                            if (!isset($_COOKIE["admin"]) or !isset($_COOKIE["user"])) {
                                setcookie("admin", 0);
                                setcookie("user", 0);
                            }
                            
                            if ($_COOKIE["admin"] == 1)
                            {
                                
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
                        <h1>Меню</h1>
                        <h2>Здесь вы можете заказать кофе и выпечку</h2>
                        <?php 
                            if ($_COOKIE["admin"] == 0 and $_COOKIE["user"] == 0) {
                                echo "<h2>Но для начала войдите в свой аккаунт</h2>";
                            }
                            else
                            {
                                echo "<div class='zak d-flex flex-row'>
                                <div>
                                        <a href='cartPage.php'>
                                            <button>Корзина</button>   
                                        </a>
                                </div>";

                                include 'db.php';
                                $zakazNum = $_SESSION['order'];
                                $sql2 = "SELECT sum(kolvoTov) as totalKolvo FROM cart where idZak='$zakazNum'";
                                $result2 = mysqli_query($connection, $sql2);
                                $row2 = mysqli_fetch_array($result2);
                                $_SESSION['kolvo'] = $row2['totalKolvo'];
                           
                                if (isset($_SESSION['kolvo'])) {
                                    echo "<div class='count'><h3 id='kolvo'>".$_SESSION['kolvo']."</h3></div>
                                    </div>";
                                }
                                else
                                {
                                    echo "<div class='count'><h3 id='kolvo'>0</h3></div>
                                    </div>";
                                }
                                        
                            }
                         ?>
                        
                    </div>
                </div>
            </div>
        </div>








         <div class="container tovSel">
            
        <?php 
        echo "<select class='selectTov minimal dropdown-menu'>";
        echo "<option class='dropdown-item' value='999'>Все</option>";
                    $sql = 'SELECT ID, nazv FROM category';
                    $result = mysqli_query($connection, $sql);
                    while ($row = mysqli_fetch_array($result))
                    {   
                        echo "<option class='dropdown-item' value='".$row['ID']."'>".$row['nazv']."</option>";
                    }
                    echo "</select>";
        ?>
            
        </div>


        <div class="container w">
            <div class="row centered ins">
                <br><br>
                <?php 
                    

                    include 'db.php';


                    $sql = 'SELECT ID, naim, opis, cena, photo FROM tovar';
                    $result = mysqli_query($connection, $sql);
                    while ($row = mysqli_fetch_array($result))
                    {   
                        echo "<div class='col-12 col-sm-6 col-md-4 col-lg-3 tov'>
                        
                        <img src=img/".$row['photo']." alt=''>
                        <h4>".$row['naim']."</h4>
                        <h3>".$row['opis']."</h3>
                        <h4>".$row['cena']." руб.</h4>
                        <button class='fb' type='submit' name='addBtn' value=".$row['ID'].">Добавить</button>
                        
                        </div>
                        ";
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
            <br><br>
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


<script src="https://unpkg.com/cookielib/src/cookie.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

        <?php if (isset($_GET['success'])) {?>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Заказ успешно оформлен',
                    showConfirmButton: true,
                    confirmButtonColor: '#ff7878'
                })
            </script>
        <?php 
            $_SESSION['successZak'] = 0;
        } ?>

        <script>
            if(getCookie('user') == 0 && getCookie('admin') == 0)
            {
                $('.fb').attr('disabled', true);
            }



            $(document).delegate(".fb","click", function() {
                let idTov = $(this).val();
                
                $.ajax({
                    type: "POST",
                    url: 'dobav.php',
                    data: {id:idTov},
                    success: function(data) {
                        result = JSON.parse(data);
                        $('#kolvo').html(result);


                    },
                    error: function(data) {
                        alert("Что то пошло не так(");
                    }
                });
            });



            $('.selectTov').change(function() {
                let idCat = $(this).val();
                
                $.ajax({
                    type: "POST",
                    url: 'filter.php',
                    data: {id:idCat},
                    success: function(data) {
                        result = JSON.parse(data);
                        let i=0;
                         console.log(result)
                         $('.ins').html("<br><br>");
                        for (let key in result.cena) {
                            
                            $('.ins').append("<div class='col-12 col-sm-6 col-md-4 col-lg-3 tov'> <img src=img/"+result.photo[key]+" alt=''> <h4>"+result.naim[key]+"</h4><h3>"+result.opis[key]+"</h3><h4>"+result.cena[key]+" руб</h4><button onclick='ins1()' class='fb' type='submit' name='addBtn' value="+result.id[key]+">Добавить</button></div>");
                        }
                        


                    },
                    error: function(data) {
                        alert("Что то пошло не так(");
                    }
                });
            });
        </script>

        
        <script src="Bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>