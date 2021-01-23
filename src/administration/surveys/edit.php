<?php

    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';

    $title = filter_var(trim($_POST['titleEdit']), FILTER_SANITIZE_STRING);
    $id = filter_var(trim($_POST['idEdit']), FILTER_SANITIZE_STRING);
    if (!isset($_SESSION)) { session_start(); }
    $login=$_SESSION["user"];
    $result = $pdo->prepare("UPDATE surveys SET title=? WHERE id=? and  login=?");
    $result->bindValue(1, $title, PDO::PARAM_STR);
    $result->bindValue(2, $id, PDO::PARAM_INT);
    $result->bindValue(3, $login, PDO::PARAM_STR);
    $result->execute();
?>