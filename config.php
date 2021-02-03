<?php

 class config{
// Подключаемся к mysql серверу
    function connect(){
        $host = 'localhost'; // Хост
        $user = 'root'; // Имя пользователя
        $pass = '18ebyhwb'; // Пароль
        $db_name = 'taxi1'; // Имя базы данных
        $link = mysqli_connect($host, $user, $pass, $db_name);
        if (!$link) {
            echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
            exit;
        }
        return $link;
    }
    function closeDB(){
        @mysqli_close($link);
    }
 }
?>