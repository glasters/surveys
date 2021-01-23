<?php
    $id = $_POST["id"];
    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';
    if (!isset($_SESSION)) { session_start(); }
    $login=$_SESSION["user"];
    $result = $pdo->prepare("SELECT COUNT(*) as c FROM surveyquestion JOIN surveys ON surveys.id=surveyquestion.surveyId  WHERE surveyquestion.id=? and login=?");
    $result->bindValue(1, $id, PDO::PARAM_INT);
    $result->bindValue(2, $login, PDO::PARAM_STR);
    $result->execute();
    $count=$result->fetch();
    if ($count['c']>0)
    {
    $result = $pdo->prepare("DELETE FROM surveyquestion  WHERE surveyquestion.id=?");
    $result->bindValue(1, $id, PDO::PARAM_INT);
    $result->execute();
    }
?>