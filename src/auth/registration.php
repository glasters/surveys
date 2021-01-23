<?php
    // <!-- Регистрация -->

    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

    $pass = md5($pass."sergey");

    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';
    
    
    $result = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $result->bindValue(1, $login, PDO::PARAM_STR);
    $result->execute();
    $user = $result->fetch();

    if ($user != NULL) {
        setcookie('failedReg', 'Failed registration', time() + 1, "/");
        header('location: /');
    }
    
    $result = $pdo->prepare("INSERT INTO users (login, pass ) VALUES (?,?)");
    $result->bindValue(1, $login, PDO::PARAM_STR);
    $result->bindValue(2, $pass, PDO::PARAM_STR);
    $result->execute();
    setcookie('goodReg', 'Good registration', time() + 1, "/");

    header('location: /');
?>