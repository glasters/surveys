<?php
    $id = $_POST["id"];
    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';
    if (!isset($_SESSION)) { session_start(); }
    $login=$_SESSION["user"];
    $result = $pdo->prepare("SELECT COUNT(*) as c FROM surveyanswer join surveyquestion ON surveyquestion.id=surveyanswer.surveyIdQuestion join surveys ON surveys.id=surveyquestion.surveyId  WHERE surveyanswer.id=? and surveys.login=?");
    $result->bindValue(1, $id, PDO::PARAM_INT);
    $result->bindValue(2, $login, PDO::PARAM_STR);
    $result->execute();
    $count=$result->fetch();
    if ($count['c']>0)
    {
    $result = $pdo->prepare("DELETE FROM surveyanswer WHERE id=?");
    $result->bindValue(1, $id, PDO::PARAM_INT);
    $result->execute();
    }
?>