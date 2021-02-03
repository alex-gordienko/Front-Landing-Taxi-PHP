<?php
include 'config.php';
session_start();
if ($_SESSION['auth_admin'] == "yes_a") {

    $case= new editCheck();
    $ID_check=$_REQUEST['setCar'];

    if (isset($_REQUEST['setCar'])) { 
        $case->setCarFormLoad($ID_check);
    }

    if (isset($_REQUEST['ID_car'])) {
        $ID_check=$_REQUEST['Number_of_check'];
        $ID_car=$_REQUEST['Type'];
        $case->setCar($ID_check, $ID_car); 
    }

    if (isset($_REQUEST['delete'])) { 
        $ID_check=$_REQUEST['delete'];
        $case->deleteCheck($ID_check);
    }

    if (isset($_REQUEST['setFinish'])) { 
        $ID_check=$_REQUEST['setFinish'];
        $case->finishCheck($ID_check);
    }
    if (isset($_REQUEST['reOpen'])) { 
        $ID_check=$_REQUEST['reOpen'];
        $case->reOpenCheck($ID_check);
    }

}
else {
	header("Location: login.php");
}
class editCheck{
    function deleteCheck($id){          //удаление заказа из базы
        $config= new config();
        $zapros=$config->connect();
        $delete=$zapros->query("DELETE FROM `check` WHERE `check`.`Number_of_Check` ='$id'");
        if($delete){
            echo '<script type="text/javascript">alert("Заказ удалён")</script>';
            echo'<script language="JavaScript" type="text/javascript">
            function changeurl(){eval(self.location="adminForm.php");}
            window.setTimeout("changeurl();",100);
            </script>';
        }
        else {
            echo "Error: " . $delete . "<br>" . $zapros->error;
        }
    }
    function finishCheck($id){          //завершение заказа из базы
        $config= new config();
        $zapros=$config->connect();
        $delete=$zapros->query("UPDATE `check` SET `check`.`Status`=1 WHERE `check`.`Number_of_Check` ='$id'");
        if($delete){
            echo '<script type="text/javascript">alert("Заказ успешно завершён")</script>';
            echo'<script language="JavaScript" type="text/javascript">
            function changeurl(){eval(self.location="adminForm.php");}
            window.setTimeout("changeurl();",100);
            </script>';
        }
        else {
            echo "Error: " . $delete . "<br>" . $zapros->error;
        }

    }
    function reOpenCheck($id){          //Восстановление заказа из базы
        $config= new config();
        $zapros=$config->connect();
        $delete=$zapros->query("UPDATE `check` SET `check`.`Status`=0 WHERE `check`.`Number_of_Check` ='$id'");
        if($delete){
            echo '<script type="text/javascript">alert("Заказ успешно возобновлён")</script>';
            echo'<script language="JavaScript" type="text/javascript">
            function changeurl(){eval(self.location="adminForm.php");}
            window.setTimeout("changeurl();",100);
            </script>';
        }
        else {
            echo "Error: " . $delete . "<br>" . $zapros->error;
        }

    }
    function setCar($id_check, $id_car){      //Установка авто нужного типа в заказ
        $config= new config();
        $zapros=$config->connect();
        $delete=$zapros->query("UPDATE `check` SET `check`.`ID_auto` ='$id_car' where `check`.`Number_of_Check`='$id_check'");
        if($delete){
            echo '<script type="text/javascript">alert("Успешно обновлено")</script>';
            echo'<script language="JavaScript" type="text/javascript">
            function changeurl(){eval(self.location="adminForm.php");}
            window.setTimeout("changeurl();",100);
            </script>';
        }
        else {
            echo "Error: " . $delete . "<br>" . $zapros->error;
        }
    }
    function setCarFormLoad($id){           //форма для выбора авто под заказ
        $config= new config();
        $zapros=$config->connect();
        $getID=$zapros->query("SELECT `Type` FROM `check` WHERE `check`.`Number_of_Check` ='$id'");
        $result = mysqli_fetch_array($getID);
        $ID= $result['Type'];

        echo '<!DOCTYPE html>
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
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <figure>
                            <img src="img/adminLogo.jpg" height="100%" width="100%" alt="Header image">
                        </figure>
                    </div>
                            <div class="tm-content-div">
                                <section class="tm-section">
                                    <header>
                                        <h2 class="tm-blue-text tm-welcome-title tm-margin-b-45">Выберите авто для заказа № '; echo $id; echo '</h2>
                                    </header>

                                    <form method="POST" class="contact-form" action="editCheck.php" enctype="">
                                            <input type="hidden" name="Number_of_check" value="'.$id.'">
                                            <div class="form-group">    
                                                <label class="tm-body-text">Выберите авто</label>
                                                <select name="Type">';
                                                    $getTypes=$zapros->query("SELECT * FROM `auto` join `driver` join `class` on `auto`.`ID_driver`=`driver`.`ID_Driver` and `class`.`ID_Class`=`auto`.`ID_Class` where `class`.`ID_Class`=$ID AND `driver`.`ID_Driver`!=0");
                                                        while ($result = mysqli_fetch_array($getTypes)) { //среди уже существующих в базе
                                                        echo "<option>".$result['ID_auto']."</option>";
                                                        }
                                                
        echo'                                   </select>
                                            </div>
                                            <input type="submit" name="ID_car" class="float-right tm-button" value="Подтвердить">
                                    </form>    
                                </section>

                                <section class="tm-section">
                                    <header>
                                        <h2 class="tm-blue-text tm-section-title tm-margin-b-45">Список доступных авто по данному классу</h2>
                                    </header>
                                    <div class="row">                                                                
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="tm-body-text" style="background-color: rgba(0,0,0,0.5);">
                                            <table cellspacing="5" cellpadding="10"><tr><th>Id</th><th>Модель</th><th>Номер</th><th>ФИО водителя</th></tr>';
                                                    $getAuto=$zapros->query("SELECT * FROM `auto` join `driver` join `class` on `auto`.`ID_driver`=`driver`.`ID_Driver` and `class`.`ID_Class`=`auto`.`ID_Class` where `class`.`ID_Class`=$ID");
                                                        while ($result = mysqli_fetch_array($getAuto)) { //среди уже существующих в базе
                                                            echo "<tr>";
                                                            echo "<td>".$result["ID_auto"]."</td>";
                                                            echo "<td>".$result["Model_of_auto"]."</td>";
                                                            echo "<td>".$result["Number_of_auto"]."</td>";
                                                            echo "<td>".$result["Firstname"]." ".$result["Secondname"]." ".$result["Thirdname"]."</td>";
                                                            echo "</tr>";
                                                            }
        echo '
                                            </table>
                                            </div>  
                                        </div>  
                                    </div>
                                    <hr>   
                                </section> 
                            </div>  
                </div> 
            </div>
        
        </body>
        </html>';
    }
} 
?>