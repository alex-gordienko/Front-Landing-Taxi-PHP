<?php
include 'config.php';

if(isset($_REQUEST['getCheck'])){          // Если нажата кнопка "Отправить данные"
    $snd = new getReview();
    $snd->sendReview();
}
if(isset($_REQUEST['delete'])){          // Если нажата кнопка "Отправить данные"
    $ID_Review=$_REQUEST['delete'];
    $snd = new getReview();
    $snd->deleteReview($ID_Review);
}
if(isset($_REQUEST['good'])){          // Если нажата кнопка "Отправить данные"
    $ID_Review=$_REQUEST['good'];
    $snd = new getReview();
    $snd->goodReview($ID_Review);
}

class getReview{
    function goodReview($id){          //завершение заказа из базы
        $config= new config();
        $zapros=$config->connect();
        $delete=$zapros->query("UPDATE `commentar` SET `commentar`.`isGood`=1 WHERE `commentar`.`ID_comment` ='$id'");
        if($delete){
            echo '<script type="text/javascript">alert("Отзыв одобрен")</script>';
            echo'<script language="JavaScript" type="text/javascript">
            function changeurl(){eval(self.location="adminForm.php");}
            window.setTimeout("changeurl();",100);
            </script>';
        }
        else {
            echo "Error: " . $delete . "<br>" . $zapros->error;
        }

        } 
    function deleteReview($id){          //удаление заказа из базы
        $config= new config();
        $zapros=$config->connect();
        $delete=$zapros->query("DELETE FROM `commentar` WHERE `commentar`.`ID_comment` ='$id'");
        if($delete){
            echo '<script type="text/javascript">alert("Отзыв удалён")</script>';
            echo'<script language="JavaScript" type="text/javascript">
            function changeurl(){eval(self.location="adminForm.php");}
            window.setTimeout("changeurl();",100);
            </script>';
        }
        else {
            echo "Error: " . $delete . "<br>" . $zapros->error;
        }
    }

    function sendReview(){
        $config =new config();
        $zapros =$config->connect(); //Метод для подключения к базе (переменной zapros присваивается ссылка на базу)
        $res = $zapros->query("SELECT max(`ID_comment`) FROM `commentar`");
        $row= mysqli_fetch_array($res);
        $index= $row['max(`ID_comment`)'];
        $newIndex= ($index+1);  //Находится ИД последнего заказа (для добавления нового в хвост)

        $ID_check=mysqli_real_escape_string($zapros, $_REQUEST["check_num"]);//получаем данные
        $Comment=mysqli_real_escape_string($zapros, $_REQUEST['contact_message']);


        // Добавляем заказ
        $resultSet="INSERT INTO `commentar` SET `ID_comment`=$newIndex, `ID_Check`=$ID_check, `Comment`='$Comment'";
        if ($zapros->query($resultSet) === TRUE) {
            //сообщение с переадресация
            echo '<script type="text/javascript">alert("Ваш Отзыв успешно добавлен")</script>';
            echo'<script language="JavaScript" type="text/javascript">
            function changeurl(){eval(self.location="index.php");}
            window.setTimeout("changeurl();",100);
            </script>';
        } else {
            echo '<script type="text/javascript">alert("Извините, заказа по такому номеру не существует")</script>';
            echo'<script language="JavaScript" type="text/javascript">
            function changeurl(){eval(self.location="review.php");}
            window.setTimeout("changeurl();",100);
            </script>';
        }
        
        $config->closeDB();
        exit; 
    }
}

?>