<?php
    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';
    $id = $_POST["id"];
    if (!isset($_SESSION)) { session_start(); }
    $login=$_SESSION["user"];
    $result = $pdo->prepare('DELETE FROM surveys WHERE id=? and login=?');
    $result->bindValue(1, $id, PDO::PARAM_INT);
    $result->bindValue(2, $login, PDO::PARAM_STR);
    $result->execute();
?>