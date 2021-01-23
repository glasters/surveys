<?php
    // <!-- Авторизация -->
    
    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

    $pass = md5($pass."sergey");

    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';

    $result = $pdo->prepare("SELECT * FROM users WHERE login = ? AND pass = ?");
    $result->bindValue(1, $login, PDO::PARAM_STR);
    $result->bindValue(2, $pass, PDO::PARAM_STR);
    $result->execute();
    $user=NULL;
    if ($result!=NULL)
    $user = $result->fetch();

    if ($user == NULL) {
        setcookie('failedAuth', 'Failed authorization', time() + 1, "/");
        header('Location: /');
    }

    session_start();
    $_SESSION["user"] = $user["login"];
    header('Location: /');
?>