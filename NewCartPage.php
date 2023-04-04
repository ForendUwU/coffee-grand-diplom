<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Coffee Grand</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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
         	<div class="container">
        <div class="row row-cols-1  row-cols-lg-4 g-3 ">
        	 <?php
                        include 'db.php';
                        $sql = 'SELECT * FROM tovar inner join cart on cart.idTov = tovar.ID ';
                        $result = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_array($result))
                        {      
                    ?>
        <div class="col mt-3">
          <div class="card shadow-sm" style="max-width:380px;min-width: 200px">
            <img src="img/ame1.jpg" class = "card-img-top" alt="">

            <div class="card-body">
              <p class="card-text"><?php echo $row['naim'];?> </p>
              <div class="d-flex justify-content-between align-items-center">
                
                <small class="text-muted">9 mins</small>
              </div>
            </div>
          </div>
        </div>
    <?php }
     mysqli_close($connection);?>
       
		</div><?php } ?>
		</div>
	
</body>
</html>