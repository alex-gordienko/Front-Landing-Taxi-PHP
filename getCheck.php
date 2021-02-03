<?php
include 'config.php';//подключаем БД
$redicet = $_SERVER['HTTP_REFERER'];


if(isset($_REQUEST['add'])){          // Если нажата кнопка "Отправить данные"
    $snd = new getCheck();
    $snd->sendData();
}

if(isset($_REQUEST['getCost'])){      //Если нажата кнопка "Ориентировочная стоимость"
    $price = new getCheck();
    $price->getPrice();
}

class getCheck{
    function getClients($fstName, $sndName, $thrdName, $mail){ //Проверка валидности клиента
        $config =new config();
        $isClient =$config->connect();
        $r = $isClient->query("SELECT * FROM `client`");
        while ($result = mysqli_fetch_array($r)) { //среди уже существующих в базе
            if($result['FirstName']===$fstName && $result['SecondName']===$sndName && $result['ThirdName']===$thrdName){
                return $result['ID_Client']; //Если находится такое же ФИО, то возвращается его ID
                $config->closeDB();
                exit;
            }
          }
        $config->closeDB();
        return 0; // Иначе 0
    }

    function sendData(){
        $config =new config();
        $zapros =$config->connect(); //Метод для подключения к базе (переменной zapros присваивается ссылка на базу)
        $res = $zapros->query("SELECT max(`Number_of_Check`) FROM `check`");
        $row= mysqli_fetch_array($res);
        $index= $row['max(`Number_of_Check`)'];
        $newIndex= ($index+1);  //Находится ИД последнего заказа (для добавления нового в хвост)

        $firstName=mysqli_real_escape_string($zapros, $_REQUEST["firstName"]);//получаем данные
        $secondName=mysqli_real_escape_string($zapros, $_REQUEST['secondName']);
        $thirdName=mysqli_real_escape_string($zapros, $_REQUEST['thirdName']);
        $Type=mysqli_real_escape_string($zapros, $_REQUEST['Type']);
        $Date=mysqli_real_escape_string($zapros, $_REQUEST['date']);
        $Time=mysqli_real_escape_string($zapros, $_REQUEST['time']);
        $arrPoint=mysqli_real_escape_string($zapros, $_REQUEST['arrivePoint']);
        $destPoint=mysqli_real_escape_string($zapros, $_REQUEST['destPoint']);
        $comment=mysqli_real_escape_string($zapros, $_REQUEST['Comment']);
        $phone=mysqli_real_escape_string($zapros, $_REQUEST['phone']);
        $email=mysqli_real_escape_string($zapros, $_REQUEST['contact_email']);

        $ID = $this->getClients($firstName, $secondName, $thirdName, $email); // Нахождение ИД клиента

        if($ID!=0){ //если не нулевое, то обновляем количество поездок
            $rs = $zapros->query("UPDATE `client` SET `Count_of_Checks`=`Count_of_Checks`+1  where `ID_Client`={$ID}");
            $newID= $ID;

            $rs = $zapros->query("SELECT `Count_of_Checks` FROM `client` where `ID_Client`={$ID}"); //нахождение последнего ИД
            $rw= mysqli_fetch_array($rs);
            $checkCount= $rw['Count_of_Checks'];
        }
        else{ // Иначе - создаём нового клиента
            $rs = $zapros->query("SELECT max(`ID_Client`) FROM `client`"); //нахождение последнего ИД
            $rw= mysqli_fetch_array($rs);
            $indx= $rw['max(`ID_Client`)'];
            $newID= ($indx+1);

            $setUser = $zapros->query("INSERT INTO `client` SET `ID_Client`=$newID, `FirstName`='$firstName', `SecondName`='$secondName', `ThirdName`='$thirdName', `Phone`='$phone', `email`='$email', `Count_of_Checks`=1");
            if (!$setUser) {
                echo "<p>Error: " . $resultSet . "<br>" . $zapros->error. "</p>";
            }
            // Добавляем данные о новом юзере
        }

            $rw = $zapros->query("SELECT `ID_Class` FROM `class` where `Name`='$Type'"); //нахождение ИД класса авто
            $rd= mysqli_fetch_array($rw);
            $type= $rd['ID_Class'];

            $FinalPrice = $this->getPrice();
            

        // Добавляем заказ
        $resultSet="INSERT INTO `check` SET `Number_of_Check`=$newIndex,`ID_Client`={$newID},`Status`=0, `Type`=$type,`Date`='$Date',`Time`='$Time',`Arrive_point`='$arrPoint',`Dest_point`='$destPoint',`commentar`='$comment',`ID_auto`=0,`Price`={$FinalPrice}";
        if ($zapros->query($resultSet) === TRUE) {
            //сообщение с переадресация
            echo '<script type="text/javascript">alert("Ваш заказ успешно добавлен. Ожидайте звонка в ближайшие 5 минут")</script>';
            echo'<script language="JavaScript" type="text/javascript">
            function changeurl(){eval(self.location="index.php");}
            window.setTimeout("changeurl();",100);
            </script>';
        } else {
            echo '<script type="text/javascript">alert("Ошибка ввода. Пользователь с таким ФИО и e-mail уже зарегистрирован")</script>';
            echo'<script language="JavaScript" type="text/javascript">
            function changeurl(){eval(self.location="index.php");}
            window.setTimeout("changeurl();",100);
            </script>';
        }
        
        $config->closeDB();
        exit; 
    }
    function getPrice(){
        $firstName=$_REQUEST["firstName"];//получаем данные
        $secondName= $_REQUEST['secondName'];
        $thirdName=$_REQUEST['thirdName'];
        $email=$_REQUEST['contact_email'];
        $Type=$_POST['Type'];
        $config =new config();
        $check= new getCheck();
        $zapros =$config->connect(); //Метод для подключения к базе (переменной zapros присваивается ссылка на базу)
        $ID_cl=$check->getClients($firstName, $secondName, $thirdName, $email);

        $rs = $zapros->query("SELECT `Count_of_Checks` FROM `client` where `ID_Client`={$ID_cl}"); //нахождение последнего ИД
        $rw= mysqli_fetch_array($rs);
        $checkCount= $rw['Count_of_Checks'];
            

        $rw = $zapros->query("SELECT * FROM `class` where `Name`='$Type'"); //нахождение ИД класса авто
        $rd= mysqli_fetch_array($rw);
        $type= $rd['ID_Class'];
        $i= $rd['Cost'];

        $rd = $zapros->query("SELECT AVG(`Tarif`) FROM `auto` WHERE `ID_Class`=$type"); //тариф на авто
        $req= mysqli_fetch_array($rd);
        $idx= $req['AVG(`Tarif`)'];

        $getPrice = ($i+$idx);

        if($checkCount < 50){
            $finalPrice = ($getPrice - (($getPrice / 100) * $checkCount));
        }
        else{
            $finalPrice = ($getPrice - (($getPrice / 100) * 50));
        }
        echo '<script type="text/javascript">alert("Стоимость поездки таким типом авто: '.$i.' грн.\n Средняя стоимость проката авто из этого типа: '. $idx.' грн.\n Итоговая ориентировочная стоимость: '.$getPrice.'грн. \n Ранее, вы пользовались нашими услугами уже '.$checkCount.' раз.\n С учётом вашего накопительного балла, стоимость вашей поездки: '.$finalPrice.' грн.\n(Без учёта дальности поездки)")</script>';
        echo'<script language="JavaScript" type="text/javascript">
        function changeurl(){eval(self.location="check.php");}
        window.setTimeout("changeurl();",10);
        </script>';
        
        $config->closeDB();
        return $finalPrice;
    }
   
}
?>



