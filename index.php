<?php
    session_start();
    include 'config.php';
    $config= new config();
    $zapros=$config->connect();
    class log{
        function logIn($log, $pas){
            $config= new config();
            $zapros=$config->connect();
            $getAdmin=$zapros->query("SELECT * FROM `admin` WHERE `login`='$log' AND `pass`='$pas'");
                if (mysqli_num_rows($getAdmin) > 0)
                {
                    $result = mysqli_fetch_array($getAdmin);
                    $_SESSION['auth_admin'] = "yes_a";
                header("Location: adminForm.php");
                } 
                else {
                    echo '<script type="text/javascript">alert("Неверный логин или пароль")</script>';
                }
            
        }
    }
        
    if (isset($_REQUEST["submit_enter"]))
    {
        $login = $_REQUEST['input_login'];
        $pass = $_REQUEST['input_pass'];
        if ($login && $pass) {
            $set= new log();
            $set->logIn($login, $pass);
        }
        else {
            echo '<script type="text/javascript">alert("Заполните все поля!")</script>';
        }
        
    }
    ?>    
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>iTaxi-Main</title> 
    <link rel="stylesheet" href="css/bootstrap.min.css">                                                                   
    <link rel="stylesheet" href="css/templatemo-style.css">
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
    <div class="container">
        <div class="row" >
            <div class="tm-left-right-container">
                <!-- Left column: logo and menu -->
                <div class="tm-blue-bg tm-left-column">                        
                    <div class="tm-logo-div text-xs-center">
                        <img src="img/cta-ligo2-786x257.png" height="50" alt="Logo">
                        <h1 class="tm-site-name">iTaxi</h1>
                    </div>
                    <nav class="tm-main-nav">
                        <ul class="tm-main-nav-ul">
                                <form class="contact-form" method="post">
								    <input type="text" class="form-control" placeholder="Логин" name="input_login"> 
								    <input type="password" class="form-control" placeholder="Пароль" name="input_pass"> 
									<input type="submit" class="float-right tm-button" name="submit_enter" id="submit_enter" value="Вход">
								</form>
                            <li class="tm-nav-item">
                                <a href="index.php#welcome" class="tm-nav-item-link">Welcome</a>
                            </li>
                            <li class="tm-nav-item">
                                <a href="index.php#about" class="tm-nav-item-link">About Us</a>
                            </li>
                            <li class="tm-nav-item">
                                <a href="check.php" class="tm-nav-item-link">Call iTaxi</a>
                            </li>
                            <li class="tm-nav-item">
                                <a href="review.php" class="tm-nav-item-link">Make Review</a>
                            </li>
                            <li class="tm-nav-item">
                                <a href="index.php#reviews" class="tm-nav-item-link">Reviews</a>
                            </li>
                        </ul>
                    </nav>                                         
                </div> <!-- Left column: logo and menu -->

                <!-- Right column: content -->
                <div class="tm-right-column">
                    <figure>
                        <img src="img/taxi-01.jpg" height="95%" width="95%" alt="Header image" class="img-fluid">
                    </figure>

                    <div class="tm-content-div">
                        <!-- Welcome section -->
                        <section id="welcome" class="tm-section">
                            <header>
                                <h2 class="tm-blue-text tm-welcome-title tm-margin-b-45">Welcome to iTaxi</h2>
                            </header>
                            <p class="tm-body-text">
                            Welcome to iTaxi - best project of on-line order your personal taxi!</p>
                            <p class="tm-body-text">It's service, which give a opportunity to call taxi without ring to operators. So, you should not to spend money to rings</p>
                        </section>
                        <!-- About section -->
                        <section id="about" class="tm-section">
                            <div class="row">                                                                
                                <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 push-lg-4 push-md-5">
                                    <header>
                                        <h2 class="tm-blue-text tm-section-title tm-margin-b-45">Auto</h2>
                                    </header>
                                    <div class="opacity-block">
                                        <p class="tm-body-text">We have a big parking of autos: from budget to premium class.</p>
                                        <p class="tm-body-text">You can choose everyone, what did you like!</p>  
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 pull-lg-8 pull-md-7 tm-about-img-container">
                                    <div class="tm-body-text" style="background-color: rgba(0,0,0,0.5);">
                                    <?php
                                        $getAuto=$zapros->query("SELECT * FROM `auto` WHERE `ID_Class`!=0");
                                        echo "Список Авто из БД";
                                        echo "<table><tr><th>Id</th><th>Модель</th></tr>";
                                        while ($result = mysqli_fetch_array($getAuto)) { //среди уже существующих в базе
                                            echo "<tr><td>".$result['ID_auto']."</td>";
                                            echo "<td>".$result['Model_of_auto']."</td>";
                                            echo "</tr>";
                                            }
                                        echo "</table>";
                                    ?>
                                    </div>  
                                </div>  
                            </div>
                            <hr>
                            <div class="row"> 
                                <div  class="col-lg-8 col-md-7 col-sm-12 col-xs-12 push-lg-4 push-md-5 tm-about-img-container">
                                <div class="tm-body-text" style="background-color: rgba(0,0,0,0.5);">
                                    <?php
                                        $getDrivers=$zapros->query("SELECT * FROM `driver`WHERE `ID_Driver`!=0");
                                        echo "Список Водителей из БД";
                                        echo "<table><tr><th>Id</th><th>ФИО</th><th>Стаж вождения</th></tr>";
                                        while ($result = mysqli_fetch_array($getDrivers)) { //среди уже существующих в базе
                                            echo "<tr><td>".$result['ID_Driver']."</td>";
                                            echo "<td>".$result['Firstname']." ".$result['Secondname']." ".$result['Thirdname']."</td>";
                                            echo "<td>".$result['Stage']." лет </td>";
                                            echo "</tr>";
                                            }
                                        echo "</table>";
                                    ?>
                                    </div>  
                                </div>
                                <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 pull-lg-8 pull-md-7">
                                    <header>
                                        <h2 class="tm-blue-text tm-section-title tm-margin-b-45">Drivers</h2>
                                    </header>
                                    <p class="tm-body-text">Our drivers are professionals in their work!</p>
                                    <p class="tm-body-text">They necessarily bring up you to destination very fast.</p>
                                    <p class="tm-body-text">(Optional) If you want to order the premium car, driver will play a role of your personal driver! You can to order the car for the whole day.</p>
                                    <a href="check.php#" class="tm-button tm-button-wide">Call iTaxi</a>  
                                </div>
                            </div>      
                        </section>  

                        <section id="reviews" class="tm-section">
                            <div class="row">                                                                
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <header>
                                        <h2 class="tm-blue-text tm-margin-b-45">Reviwes</h2>
                                    </header>
                                    <div class="opacity-block">
                                        <p class="tm-body-text">Just look at the real clients feedback!</p>
                                    </div>
                                    <div class="tm-body-text" style="background-color: rgba(0,0,0,0.5);">
                                        <?php
                                            $getAuto=$zapros->query("SELECT * FROM `commentar` join `check` join `auto` join `driver` join `client` on `commentar`.`ID_Check`=`check`.`Number_of_Check` and `check`.`ID_Client`=`client`.`ID_Client` and `check`.`ID_auto`=`auto`.`ID_auto` and `auto`.`ID_driver`=`driver`.`ID_Driver` WHERE `commentar`.`isGood`=1");
                                            echo "<table><tr><th>№ заказа</th><th>ФИО клиента</th><th>ФИО водителя</th><th>Авто</th><th>Комментарий</th></tr>";
                                            while ($result = mysqli_fetch_array($getAuto)) { //среди уже существующих в базе
                                                echo "<tr>";
                                                echo "<td>".$result['Number_of_Check']."</td>";
                                                echo "<td>".$result['FirstName']." ".$result['SecondName']." ".$result['ThirdName']."</td>";
                                                echo "<td>".$result['Firstname']." ".$result['Secondname']." ".$result['Thirdname']."</td>";
                                                echo "<td>".$result['Model_of_auto'].", № ".$result['Number_of_auto']."</td>";
                                                echo "<td>".$result['Comment']."</td>";
                                                echo "</tr>";
                                                }
                                            echo "</table>";
                                        ?>
                                    </div>  
                                </div>
                            </div>      
                        </section> 

                        <hr>
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

                </div> <!-- Right column: content -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->

</body>
</html>