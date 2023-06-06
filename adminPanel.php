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
                                echo "<li  class='active'><a href='profilePage.php'>Панель администратора</a></li>";
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

        <?php 

            session_start();
            
            if (isset($_SESSION['den'])) {
                $al = $_SESSION['den'];
                if ($al == 1) {
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11.6.15/dist/sweetalert2.all.min.js'></script>
                    <script>
                        Swal.fire({
                        title: 'Пользователи поздравлены',
                        width: '600px',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',
                        padding: '8% 0 0 0',
                        });
                    </script>";
                    $_SESSION['den'] = 0;
                }
            }
            
        ?>

        <div class="container">
            <div class="row centered">
                <form action="denRozhd.php" method="POST">
                    <button type="submit" class="dobavButton selButton">Поздравить с днём рождения</button>
                </form>
            </div>
        </div>

        <div class="container">
            <div class="row centered">
                <form action="otchet.php" method="POST">
                    <button type="submit" class="dobavButton selButton">Отчёт по продажам за прошлый месяц</button>
                </form>
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
                        echo "<table id='myTable' class='display'>";
                        echo "<thead>";
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

                        echo "</thead>";
                        echo "<tbody>";

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
                                $query = "SELECT cart.ID, cart.idZak, tovar.naim, cart.kolvoTov FROM cart inner join tovar on cart.idTov = tovar.ID order by cart.ID asc";
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
                            echo "</tbody>";
                        echo "</table>";
                        echo "</div>";


                        echo "<br><br>";
                        echo "<form action='insDel.php' method='POST' id='send'>";

                        if ($table_name == 'users') {
                        echo "<div class = 'container centered dobavUdal'>";
                        echo "<div class = 'dobavBlock' id = 'dobav'>";
                        echo "<h2 style = 'color:white'>Добавление</h2>";
                        
                            echo "<div class = 'inp'><input name = 'FIO' id = 'FIOCheck' class='inpInf userField' placeholder = 'ФИО'></input></div>";
                            echo "<div class = 'inp'><input name = 'email' id = 'mailCheck' class='inpInf userField' placeholder = 'E-Mail'></input></div>";
                            echo "<div class='inp'><input name = 'dataRozd' id = 'dateCheck' onfocus=\"this.type='date'\" onblur=\"this.type='text'\" class='inpInf userField' placeholder='Дата рождения'></div>";
                            echo "<div class = 'inp'><input name = 'kolvoBonus' id = 'kolvoBonusCheck' class='inpInf userField' placeholder = 'Кол-во бонусных баллов'></input></div>";
                            echo "<div class = 'inp'><input name = 'parol' id = 'passCheck' class='inpInf userField' placeholder = 'Пароль'></input></div>";
                            echo "<div class = 'inp'><input name = 'activCode' id = 'activationCheck' class='inpInf userField' placeholder = 'Код активации профиля'></input></div>";
                            echo "<div class = 'inp'><select name = 'status' class='inpInf selDobav' placeholder = 'Статус активации профиля'>
                            <option class = 'dobavOption'>Статус активации профиля - 1</option>
                            <option class = 'dobavOption'>Статус активации профиля - 0</option>
                            </select></div>";
                            echo "<button name = 'sub' value = 'dobav' type = 'submit' class = 'dobavButton'>Добавить</button>";
                        
                        echo "</div>";

                        echo "<div class = 'udalBlock'>";
                        echo "<h2 style = 'color:white'>Удаление</h2>";
                        echo "<div class = 'inp'><select id = 'del' class='selectUdal minimal dropdown-menu'>";
                        $query = "SELECT ID, FIO FROM users";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_array($result)) 
                        {
                            echo "<option name = 'forUdal' value = ".$row['ID'].">".$row['FIO']."</option>";
                        }
                        echo "</select></div>";

                        echo "<button id = 'delButton' name = 'sub' value = 'udal' type = 'button' class = 'dobavButton'>Удалить</button>";
                        echo "</div>";

                        echo "</div>";
                    }elseif ($table_name == 'zakazy') {
                        echo "<div class = 'container centered dobavUdal'>";
                        echo "<div class = 'dobavBlock' id = 'dobav'>";
                        echo "<h2 style = 'color:white'>Добавление</h2>";
                        
                            echo "<div class = 'inp'><select name = 'userID' class='inpInf selDobav' placeholder = 'ФИО пользователя'>";
                            $query = "SELECT ID, FIO FROM users";
                            $result = mysqli_query($connection, $query);
                            while ($row = mysqli_fetch_array($result)) 
                            {
                                echo "<option class = 'dobavOption' value = ".$row['ID'].">".$row['FIO']."</option>";
                            }
                            echo "</select></div>";
                            echo "<div class='inp'><input name = 'dataZakaza' id = 'dateCheck2' onfocus=\"this.type='date'\" onblur=\"this.type='text'\" class='inpInf userField' placeholder='Дата заказа'></div>";
                            echo "<div class='inp'><input name = 'vremyaZak' id = 'timeCheck' onfocus=\"this.type='time'\" onblur=\"this.type='text'\" class='inpInf userField' placeholder='Время заказа'></div>";
                            echo "<div class = 'inp'><input name = 'sumZak' id = 'sumCheck' class='inpInf userField' placeholder = 'Сумма заказа, руб.'></input></div>";
                            echo "<button name = 'sub' value = 'dobav' type = 'submit' class = 'dobavButton'>Добавить</button>";
                        
                        echo "</div>";

                        echo "<div class = 'udalBlock'>";
                        echo "<h2 style = 'color:white'>Удаление</h2>";
                        echo "<div class = 'inp'><select id = 'del' class='selectUdal minimal dropdown-menu'>";
                        $query = "SELECT ID FROM zakazy order by ID asc";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_array($result)) 
                        {
                            echo "<option name = 'forUdal' value = ".$row['ID'].">".$row['ID']."</option>";
                        }
                        echo "</select></div>";

                        echo "<button id = 'delButton' name = 'sub' value = 'udal' type = 'button' class = 'dobavButton'>Удалить</button>";
                        echo "</div>";

                        echo "</div>";
                    }elseif ($table_name == 'tovar') {
                        echo "<div class = 'container centered dobavUdal'>";
                        echo "<div class = 'dobavBlock' id = 'dobav'>";
                        echo "<h2 style = 'color:white'>Добавление</h2>";
                        
                            echo "<div class = 'inp'><input name = 'naim' id = 'nazvCheck' class='inpInf userField' placeholder = 'Наименование'></input></div>";
                            echo "<div class = 'inp'><input name = 'opis' id = 'opisCheck' class='inpInf userField' placeholder = 'Описание'></input></div>";
                            echo "<div class = 'inp'><input name = 'cena' id = 'cenaCheck' class='inpInf userField' placeholder = 'Цена, руб.'></input></div>";
                            echo "<div class = 'inp'><input name = 'photo' id = 'fotoCheck' class='inpInf userField' placeholder = 'Фото'></input></div>";
                            echo "<div class = 'inp'><select name = 'cat' class='inpInf selDobav' placeholder = 'Название категории'>";
                            $query = "SELECT ID, nazv FROM category";
                            $result = mysqli_query($connection, $query);
                            while ($row = mysqli_fetch_array($result)) 
                            {
                                echo "<option class = 'dobavOption' value = ".$row['ID'].">".$row['nazv']."</option>";
                            }
                            echo "</select></div>";
                            echo "<button name = 'sub' value = 'dobav' type = 'submit' class = 'dobavButton'>Добавить</button>";
                        
                        echo "</div>";

                        echo "<div class = 'udalBlock'>";
                        echo "<h2 style = 'color:white'>Удаление</h2>";
                        echo "<div class = 'inp'><select id = 'del' class='selectUdal minimal dropdown-menu'>";
                        $query = "SELECT ID, naim, opis FROM tovar";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_array($result)) 
                        {
                            echo "<option name = 'forUdal' value = ".$row['ID'].">".$row['naim'].", ".$row['opis']."</option>";
                        }
                        echo "</select></div>";

                        echo "<button id = 'delButton' name = 'sub' value = 'udal' type = 'button' class = 'dobavButton'>Удалить</button>";
                        echo "</div>";

                        echo "</div>";
                    }elseif ($table_name == 'category') {
                        echo "<div class = 'container centered dobavUdal'>";
                        echo "<div class = 'dobavBlock' id = 'dobav'>";
                        echo "<h2 style = 'color:white'>Добавление</h2>";
                        
                            echo "<div class = 'inp'><input name = 'categoryInp' id = 'nazvCatCheck' class='inpInf userField' placeholder = 'Название категории'></input></div>";
                            echo "<button name = 'sub' value = 'dobav' type = 'submit' class = 'dobavButton'>Добавить</button>";
                        
                        echo "</div>";

                        echo "<div class = 'udalBlock'>";
                        echo "<h2 style = 'color:white'>Удаление</h2>";
                        echo "<div class = 'inp'><select id = 'del' class='selectUdal minimal dropdown-menu'>";
                        $query = "SELECT ID, nazv FROM category";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_array($result)) 
                        {
                            echo "<option name = 'forUdal' value = ".$row['ID'].">".$row['nazv']."</option>";
                        }
                        echo "</select></div>";

                        echo "<button id = 'delButton' name = 'sub' value = 'udal' type = 'button' class = 'dobavButton'>Удалить</button>";
                        echo "</div>";

                        echo "</div>";
                    }elseif ($table_name == 'cart') {
                        echo "<div class = 'container centered dobavUdal'>";
                        echo "<div class = 'dobavBlock' id = 'dobav'>";
                        echo "<h2 style = 'color:white'>Добавление</h2>";
                        
                            echo "<div class = 'inp'><select name = 'idZak' class='inpInf selDobav' placeholder = 'ID zakaza'>";
                            $query = "SELECT ID FROM zakazy order by ID asc";
                            $result = mysqli_query($connection, $query);
                            while ($row = mysqli_fetch_array($result)) 
                            {
                                echo "<option class = 'dobavOption' value = ".$row['ID'].">".$row['ID']."</option>";
                            }
                            echo "</select></div>";
                            echo "<div class = 'inp'><select name = 'idTov' class='inpInf selDobav' placeholder = 'ID zakaza'>";
                            $query = "SELECT ID, naim FROM tovar";
                            $result = mysqli_query($connection, $query);
                            while ($row = mysqli_fetch_array($result)) 
                            {
                                echo "<option class = 'dobavOption' value = ".$row['ID'].">".$row['naim']."</option>";
                            }
                            echo "</select></div>";
                            echo "<div class = 'inp'><input name = 'kolvo' id = 'kolvoCheck' class='inpInf' placeholder = 'Кол-во товаров'></input></div>";
                            echo "<button name = 'sub' value = 'dobav' type = 'submit' class = 'dobavButton'>Добавить</button>";
                        
                        echo "</div>";

                        echo "<div class = 'udalBlock'>";
                        echo "<h2 style = 'color:white'>Удаление</h2>";
                        echo "<div class = 'inp'><select id = 'del' class='selectUdal minimal dropdown-menu'>";
                        $query = "SELECT ID FROM cart order by ID asc";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_array($result)) 
                        {
                            echo "<option name = 'forUdal' value = ".$row['ID'].">".$row['ID']."</option>";
                        }
                        echo "</select></div>";

                        echo "<button id = 'delButton' name = 'sub' value = 'udal' type = 'button' class = 'dobavButton'>Удалить</button>";
                        echo "</div>";

                        echo "</div>";
                    }
                        echo "</form>";
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


            
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
            <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
            <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>

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
        

        //window.addEventListener("beforeunload", function(event) {
                //Cookies.set('table_name', 'null1');
            
        //});




        $(document).ready(function() {
            $('#myTable').DataTable({
            "paging": true,
            "pageLength": 10, 
            "lengthChange": false, 
            "searching": true, 
            "ordering": false, 
            "info": false, 
            "autoWidth": false, 
            "language": { 
            "paginate": {
                "first": "Первая",
                "last": "Последняя",
                "next": "Следующая",
                "previous": "Предыдущая"
                
            },
            "search": "Найти:",
            zeroRecords: "Нет соответствующих записей"
        }
    });
});

        

        document.getElementById('send').addEventListener("submit", function(e) {

            var regInputs = document.getElementsByClassName('userField');
            for (var i = regInputs.length - 1; i >= 0; i--) {
                if (regInputs[i].value == "") 
                {
                    swal({
                        title: '<h2 style = "color: white">Не все поля заполнены</h2>',
                        width: '600px',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                    });
                    e.preventDefault();
                    return false;
                }
            }
if (Cookies.get('table_name') == 'users') {
            if (document.getElementById('passCheck').value.length < 6) 
                {
                    swal({
                        title: '<h2 style = "color: white">Длина пароля должна быть больше 6 символов</h2>',
                        width: '600px',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                    });
                    e.preventDefault();
                    return false;
                }
                
                if (Date.parse(document.getElementById('dateCheck').value) >= new Date()) 
                {
                    swal({
                        title: '<h2 style = "color: white">Дата не должна быть больше текущей</h2>',
                        width: '600px',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                    });
                    e.preventDefault();
                    return false;
                }

                if (!/^[a-zA-Z0-9]*$/.test(document.getElementById('activationCheck').value)) 
                {
                    swal({
                        title: '<h2 style = "color: white">Код активации профиля должен содержать только английские буквы и цифры</h2>',
                        width: '600px',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                    });
                    e.preventDefault();
                    return false;
                }

                if (/[0-9]/.test(document.getElementById('FIOCheck').value)) 
                {
                    swal({
                        title: '<h2 style = "color: white">ФИО не должно содержать цифр</h2>',
                        width: '600px',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                    });
                    e.preventDefault();
                    return false;
                }

                if (document.getElementById('kolvoBonusCheck').value < 0 || !/^[0-9]*$/.test(document.getElementById('kolvoBonusCheck').value)) 
                {
                    swal({
                        title: '<h2 style = "color: white">Кол-во баллов не может быть отрицательным и содержать буквы</h2>',
                        width: '600px',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                    });
                    e.preventDefault();
                    return false;
                }

                if (!/\S+@\S+\.\S+/.test(document.getElementById('mailCheck').value)) 
                {
                    swal({
                        title: '<h2 style = "color: white">Неправильный формат e-mail</h2>',
                        width: '600px',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                    });
                    e.preventDefault();
                    return false;
                }
}else if(Cookies.get('table_name') == 'zakazy'){
                if (Date.parse(document.getElementById('dateCheck2').value) >= new Date()) 
                {
                    swal({
                        title: '<h2 style = "color: white">Дата не должна быть больше текущей</h2>',
                        width: '600px',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                    });
                    e.preventDefault();
                    return false;
                }

                if (document.getElementById('sumCheck').value < 0) 
                {
                    swal({
                        title: '<h2 style = "color: white">Cумма заказа не может быть отрицательной</h2>',
                        width: '600px',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                    });
                    e.preventDefault();
                    return false;
                }
}else if(Cookies.get('table_name') == 'tovar'){
                if (document.getElementById('cenaCheck').value <= 0 || !/^[0-9]*$/.test(document.getElementById('cenaCheck').value)) 
                {
                    swal({
                        title: '<h2 style = "color: white">Цена товра не может быть 0 или меньше нуля, также содержать символы</h2>',
                        width: '600px',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                    });
                    e.preventDefault();
                    return false;
                }

}else if(Cookies.get('table_name') == 'cart'){
                if (document.getElementById('kolvoCheck').value <= 0 || !/^[0-9]*$/.test(document.getElementById('kolvoCheck').value)) 
                {
                    swal({
                        title: '<h2 style = "color: white">Количество товра не может быть 0 или меньше нуля, также содержать символы</h2>',
                        width: '600px',
                        confirmButtonColor: '#ff7878',
                        background: '#292929',

                    });
                    e.preventDefault();
                    return false;
                }

}
            });

        $('#delButton').click(function() {
                let id = document.getElementById('del').value;
                let preSub = 'del';
                $.ajax({
                    type: "POST",
                    url: 'insDel.php',
                    data: {forUdal:id, sub:preSub},
                    success: function(data) {
                         location.reload(true);
                         
                    },
                    error: function(data) {
                        alert("Что то пошло не так(");
                    }
                });
            });

    </script>
    </body>
</html>
