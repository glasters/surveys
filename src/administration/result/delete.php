<?php
    $id = $_POST["id"];
    $user = $_POST["user"];
    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';
    if (!isset($_SESSION)) { session_start(); }
    $login=$_SESSION["user"];
    $result = $pdo->prepare("SELECT COUNT(*) as c FROM result JOIN surveys ON surveys.id=result.surveyId  WHERE result.surveyId=? and login=?");
    $result->bindValue(1, $id, PDO::PARAM_INT);
    $result->bindValue(2, $login, PDO::PARAM_STR);
    $result->execute();
    $count=$result->fetch();
    if ($count['c']>0)
    {
    $result = $pdo->prepare("DELETE FROM result  WHERE result.surveyId=? and result.user=?");
    $result->bindValue(1, $id, PDO::PARAM_INT);
    $result->bindValue(2, $user, PDO::PARAM_STR);
    $result->execute();
    }
?>