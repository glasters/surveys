<?php
    // <!-- Останавливает выполнение скрипта, если пользователь не авторизован  -->
    
    if (!isset($_SESSION["user"])) {
        echo "Вы не авторизованы";
        exit();
    }
?>