<?php 
session_start();
if ($_SESSION['auth_admin'] == "yes_a") {

    if (isset($_GET["logout"]))
    {
        unset($_SESSION['auth_admin']);
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>iTaxi-Main</title> 
    <link rel="stylesheet" href="css/bootstrap.min.css">                                                                   
    <link rel="stylesheet" href="css/templatemo-style-admin.css">
    <style>
       body{
        background-image: url(img/taxi-03.jpg); 
        background-repeat: no-repeat;
        background-position: center; 
        background-size: cover;
        background-attachment: fixed;
        }
    </style>
</head>
<body >
    <?php
        include 'config.php';
        $config= new config();
        $zapros=$config->connect();
    ?>
    <p align="right"> <a style="color: red" href="?logout">Выход</a></p>        
    <div class="container">
        <div class="row" >
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <figure>
                    <img src="img/adminLogo.jpg" height="100%" width="100%" alt="Header image">
                </figure>
            </div>
                    <div class="tm-content-div">
                        <!-- Welcome section -->
                        <section class="tm-section">
                            <header>
                                <h2 class="tm-blue-text tm-welcome-title tm-margin-b-45">Заказы в очереди</h2>
                            </header>
                            <div class="tm-body-text" style="background-color: rgba(0,0,0,0.8);">
                                <table border="2" ><tr><th>Id</th><th>ID, ФИО клиента</th><th>Количество поездок и стоимость</th><th>Тип авто</th><th>Дата/время, на когда</th><th>Отправка</th><th>Назначение</th><th>Авто</th><th>Комментарий</th><th>Действия</th></tr>
                                    <?php
                                        $getAuto=$zapros->query("SELECT * FROM `check` join `client` join `class` join `auto` on `check`.`ID_Client`=`client`.`ID_Client` and `check`.`Type`=`class`.`ID_Class` and `check`.`ID_auto`=`auto`.`ID_auto` where `check`.`Status`=0 ORDER BY `Number_of_Check`");
                                        
                                        while ($result = mysqli_fetch_array($getAuto)) { //Вывод списка заказов со статусом 0 - в процессе обработки
                                            $id=$result['Number_of_Check'];
                                            echo "<tr>";
                                            echo "<td>".$result['Number_of_Check']."</td>";
                                            echo "<td>".$result['ID_Client']." ".$result['FirstName']." ".$result['SecondName']." ".$result['ThirdName']." ".$result['Phone']."</td>";
                                            echo "<td>".$result['Count_of_Checks']." поездок. <p> Стоимость: ".$result['Price']." грн.</td>";
                                            echo "<td>".$result['Name']."</td>";
                                            echo "<td> на ".$result['Date']." ".$result['Time']."</td>";
                                            echo "<td>".$result['Arrive_point']."</td>";
                                            echo "<td>".$result['Dest_point']."</td>";
                                            echo "<td>".$result['ID_auto']." ".$result['Model_of_auto']." ".$result['Number_of_auto']."</td>";
                                            echo "<td>".$result['commentar']."</td>";
                                            echo "<td>";
                                            echo "<a style='color: green' href=editCheck.php?setCar=".$id.">Назначить авто</a><br>";
                                            echo "<a style='color: yellow' href=editCheck.php?setFinish=".$id.">Завершить</a><br>";
                                            echo "<a style='color: red' href=editCheck.php?delete=".$id.">Удалить</a><br>";
                                            echo "</td>";
                                            echo "</tr>";
                                            }
                                    ?>
                                </table>
                            </div>

                        </section>
                        <section class="tm-section">
                            <header>
                                <h2 class="tm-blue-text tm-welcome-title tm-margin-b-45">Выполненные заказы</h2>
                            </header>
                            <div class="tm-body-text" style="background-color: rgba(0,0,0,0.8);">
                                <table border="2" ><tr><th>Id</th><th>ID, ФИО клиента и кол-во поездок</th><th>Тип авто</th><th>Дата/время, на когда</th><th>Отправка</th><th>Назначение</th><th>Авто</th><th>Комментарий</th><th>Действия</th></tr>
                                    <?php
                                        $getAuto=$zapros->query("SELECT * FROM `check` join `client` join `class` join `auto` on `check`.`ID_Client`=`client`.`ID_Client` and `check`.`Type`=`class`.`ID_Class` and `check`.`ID_auto`=`auto`.`ID_auto` where `check`.`Status`=1 ORDER BY `check`.`Number_of_Check`");
                                        
                                        while ($result = mysqli_fetch_array($getAuto)) { //Вывод списка заказов со статусом 1 - выполнен
                                            $id=$result['Number_of_Check'];
                                            echo "<tr>";
                                            echo "<td>".$result['Number_of_Check']."</td>";
                                            echo "<td>".$result['ID_Client']." ".$result['FirstName']." ".$result['SecondName']." ".$result['ThirdName']." ".$result['Phone']."</td>";
                                            echo "<td>".$result['Name']."</td>";
                                            echo "<td> на ".$result['Date']." ".$result['Time']."</td>";
                                            echo "<td>".$result['Arrive_point']."</td>";
                                            echo "<td>".$result['Dest_point']."</td>";
                                            echo "<td>".$result['ID_auto']." ".$result['Model_of_auto']." ".$result['Number_of_auto']."</td>";
                                            echo "<td>".$result['commentar']."</td>";
                                            echo "<td>";
                                            echo "<a style='color: yellow' href=editCheck.php?reOpen=".$id.">Возобновить</a><br>";
                                            echo "<a style='color: red' href=editCheck.php?delete=".$id.">Удалить</a><br>";
                                            echo "</td>";
                                            echo "</tr>";
                                            }
                                    ?>
                                </table>
                            </div>

                        </section>
                        <hr>

                            <section id="reviews" class="tm-section">
                                <div class="row">                                                                
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <header>
                                            <h2 class="tm-blue-text tm-margin-b-45">Отзывы</h2>
                                        </header>
                                        <div class="tm-body-text" style="background-color: rgba(0,0,0,0.8);">
                                            <p>Ожидают ревизии</p>
                                            <table border="2"><tr><th>№ заказа</th><th>ФИО клиента</th><th>ФИО водителя</th><th>Авто</th><th>Комментарий</th><th>Удалить</th></tr>
                                            <?php
                                                $getAuto=$zapros->query("SELECT * FROM `commentar` join `check` join `auto` join `driver` join `client` on `commentar`.`ID_Check`=`check`.`Number_of_Check` and `check`.`ID_Client`=`client`.`ID_Client` and `check`.`ID_auto`=`auto`.`ID_auto` and `auto`.`ID_driver`=`driver`.`ID_Driver` WHERE `commentar`.`isGood`=0");
                                                
                                                while ($result = mysqli_fetch_array($getAuto)) { //среди уже существующих в базе
                                                    $id=$result['ID_comment'];
                                                    echo "<tr>";
                                                    echo "<td>".$result['Number_of_Check']."</td>";
                                                    echo "<td>".$result['FirstName']." ".$result['SecondName']." ".$result['ThirdName']."</td>";
                                                    echo "<td>".$result['Firstname']." ".$result['Secondname']." ".$result['Thirdname']."</td>";
                                                    echo "<td>".$result['Model_of_auto'].", № ".$result['Number_of_auto']."</td>";
                                                    echo "<td>".$result['Comment']."</td>";
                                                    echo "<td>";
                                                    echo "<a style='color: green' href=getReview.php?good=".$id.">Пропустить</a><br>";
                                                    echo "<a style='color: red' href=getReview.php?delete=".$id.">Удалить</a><br>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    }
                                                echo "</table>";
                                            ?>
                                        </div>  
                                        <div class="tm-body-text" style="background-color: rgba(0,0,0,0.8);">
                                            <p>Одобренные</p>
                                            <table border="2"><tr><th>№ заказа</th><th>ФИО клиента</th><th>ФИО водителя</th><th>Авто</th><th>Комментарий</th><th>Удалить</th></tr>
                                            <?php
                                                $getAuto=$zapros->query("SELECT * FROM `commentar` join `check` join `auto` join `driver` join `client` on `commentar`.`ID_Check`=`check`.`Number_of_Check` and `check`.`ID_Client`=`client`.`ID_Client` and `check`.`ID_auto`=`auto`.`ID_auto` and `auto`.`ID_driver`=`driver`.`ID_Driver` WHERE `commentar`.`isGood`=1");
                                                
                                                while ($result = mysqli_fetch_array($getAuto)) { //среди уже существующих в базе
                                                    $id=$result['ID_comment'];
                                                    echo "<tr>";
                                                    echo "<td>".$result['Number_of_Check']."</td>";
                                                    echo "<td>".$result['FirstName']." ".$result['SecondName']." ".$result['ThirdName']."</td>";
                                                    echo "<td>".$result['Firstname']." ".$result['Secondname']." ".$result['Thirdname']."</td>";
                                                    echo "<td>".$result['Model_of_auto'].", № ".$result['Number_of_auto']."</td>";
                                                    echo "<td>".$result['Comment']."</td>";
                                                    echo "<td>";
                                                    echo "<a style='color: red' href=getReview.php?delete=".$id.">Удалить</a><br>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    }
                                                echo "</table>";
                                            ?>
                                        </div>  
                                    </div>
                                </div>      
                            </section> 
                            <footer>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0"> 
                                    <tr align="left" height="70">  
                                        <td id="Contacts">
                                            <h6>Contacts:</h6>
                                            <h6>alexoid1999@gmail.com</h6>
                                            <h6>vk.com/alexoid1999</h6>
                                            <h6>instagram.com/alexoid.exe</h6>
                                        </td>
                                        <td>
                                            <h6 align="center"> All materials protected by copyright.</h6>
                                            <h6 align="center">Using only with indication of the author</h6>
                                        </td>
                                        <td>
                                            <h6 align="right">&copy; by AleXoiD 2018</h6>
                                        </td>
                                    </tr>
                                    </table>
                          </footer>
                    </div>  

        </div> <!-- row -->
    </div> <!-- container -->

</body>
</html>
<?php
}
else {
	header("Location: index.php");
}
?>