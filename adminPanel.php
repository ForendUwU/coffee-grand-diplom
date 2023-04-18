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
    <body class="panel">
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
                                echo "<li  class='active'><a href='profilePage.php'>Админская панель</a></li>";
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

        <form id="myForm" method="POST" action="adminPanel.php">
            <div class="container">
                <select class="selectTable minimal dropdown-menu selTable" name="table">
                    
                                <option class="dropdown-item" id = "null" value="null">Выберете таблицу</option>
                                <option class="dropdown-item" id = "users" value="users">Пользователи</option>
                                <option class="dropdown-item" id = "zakazy" value="zakazy">Заказы</option>
                                <option class="dropdown-item" id = "tovar" value="tovar">Товары</option>
                                <option class="dropdown-item" id = "category" value="category">Категории</option>
                                <option class="dropdown-item" id = "cart" value="cart">Корзина</option>
                            

                    
                    
                </select>
            </div>
        </form>

        <br>
        <br>

        <?php 

            include 'db.php';
            if (isset($_POST['table'])) {
                $table_name = $_POST['table'];

                if (!is_null($table_name)) 
                {
                    if ($table_name != 'null') 
                    {
                        setcookie("table_name", $table_name);
                        $query = "SELECT * FROM $table_name";
                        $result = mysqli_query($connection, $query);

                        echo "<div class='container fTable'>";
                        echo "<table>";

                        if ($table_name == 'users') {
                            echo "<tr>
                                    <th>ID</th>
                                    <th>ФИО</th>
                                    <th>E-Mail</th>
                                    <th>Дата рождения</th>
                                    <th>Кол-во бонусных баллов</th>
                                    <th>Пароль</th>
                                    <th>Код активации профиля</th>
                                    <th>Статус активации профиля</th>
                                  </tr>";
                        }
                        else if($table_name == 'zakazy')
                        {

                            echo "<tr>
                                    <th>ID</th>
                                    <th>ФИО пользователя</th>
                                    <th>Дата заказа</th>
                                    <th>Время заказа</th>
                                    <th>Сумма заказа</th>
                                  </tr>";
                        }
                        else if($table_name == 'tovar')
                        {

                            echo "<tr>
                                    <th>ID</th>
                                    <th>Наименование</th>
                                    <th>Описание</th>
                                    <th>Цена, руб.</th>
                                    <th>Фото</th>
                                    <th>Категория</th>
                                  </tr>";
                        }
                        else if($table_name == 'category')
                        {

                            echo "<tr>
                                    <th>ID</th>
                                    <th>Название категории</th>
                                  </tr>";
                        }
                        else if($table_name == 'cart')
                        {

                            echo "<tr>
                                    <th>ID</th>
                                    <th>ID заказа</th>
                                    <th>Название товара</th>
                                    <th>Кол-во товаров</th>
                                  </tr>";
                        }

                            if ($table_name == 'zakazy') {
                                $query = "SELECT zakazy.ID, users.FIO, zakazy.dateZak, zakazy.vremyaZak, zakazy.sumZakaza FROM zakazy inner join users on zakazy.idUser = users.ID order by id asc";
                                $result = mysqli_query($connection, $query);
                                while ($row = mysqli_fetch_assoc($result)) 
                                {
                                    echo "<tr>";
                                    foreach ($row as $value) 
                                    {
                                        echo "<td>" . $value . "</td>";
                                    }
                                    echo "</tr>";
                                }
                            }else if ($table_name == 'tovar') {
                                $query = "SELECT tovar.ID, tovar.naim, tovar.opis, tovar.cena, tovar.photo, category.nazv FROM tovar inner join category on tovar.idCat = category.ID";
                                $result = mysqli_query($connection, $query);
                                while ($row = mysqli_fetch_array($result))
                                { 
                                    echo "<tr>";
                                        echo "<td>". $row['ID'] . "</td>";
                                        echo "<td>". $row['naim'] . "</td>";
                                        echo "<td>". $row['opis'] . "</td>";
                                        echo "<td>". $row['cena'] . "</td>";
                                        echo "<td><img src=img/".$row['photo']." alt=''></td>";
                                        echo "<td>". $row['nazv'] . "</td>";

                                    echo "</tr>";
                                }
                            }
                            else if ($table_name == 'cart') {
                                $query = "SELECT cart.ID, cart.idZak, tovar.naim, cart.kolvoTov FROM cart inner join tovar on cart.idTov = tovar.ID";
                                $result = mysqli_query($connection, $query);
                                while ($row = mysqli_fetch_assoc($result)) 
                                {
                                    echo "<tr>";
                                    foreach ($row as $value) 
                                    {
                                        echo "<td>" . $value . "</td>";
                                    }
                                    echo "</tr>";
                                }
                            }
                            else
                            {

                            while ($row = mysqli_fetch_assoc($result)) 
                            {
                                echo "<tr>";
                                    foreach ($row as $value) 
                                    {
                                        echo "<td>" . $value . "</td>";
                                    }
                                echo "</tr>";
                            }
                            }
                        echo "</table>";
                        echo "</div>";
                    }
                    else
                    {
                        $table_name = 'null';
                        setcookie("table_name", $table_name);
                    }
                }
            }
            else
            {
                $table_name = 'null';
                setcookie("table_name", $table_name);
            }


            

            
         ?>

    <script src="js.cookie.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        
            $('select[name="table"]').change(function() {
                this.setAttribute("selected", "true");
                $('#myForm').submit();
                
            });

            document.addEventListener("DOMContentLoaded", function(event) { 
                var n = Cookies.get('table_name');
                
                if (n == 'users') 
                {
                    var option = document.getElementById('users');
                    option.selected = true;
                }
                else if (n == 'zakazy') 
                {
                    var option = document.getElementById('zakazy');
                    option.selected = true;
                }
                else if (n == 'tovar') 
                {
                    var option = document.getElementById('tovar');
                    option.selected = true;
                }
                else if (n == 'category') 
                {
                    var option = document.getElementById('category');
                    option.selected = true;
                }
                else if (n == 'cart') 
                {
                    var option = document.getElementById('cart');
                    option.selected = true;
                }
                else if (n == 'null') 
                {
                    var option = document.getElementById('null');
                    option.selected = true;
                }
            });
        

        window.addEventListener("beforeunload", function(event) {
                Cookies.set('table_name', 'null');
            
        });

    </script>
    </body>
</html>
