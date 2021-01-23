<?php
    // <!-- Строка подключения к базе данных -->
    
    $host1 = '127.0.0.1';
    $db1   = 'survey';
    $user1 = 'root';
    $pass1 = 'root';
    $charset1 = 'utf8';

    $dsn = "mysql:host=$host1;dbname=$db1;charset=$charset1";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false
    ];
    $pdo = new PDO($dsn, $user1, $pass1, $opt);
?>