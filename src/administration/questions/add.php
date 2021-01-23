<?php
    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';

    $surveyId = filter_var(trim($_POST['surveyIdAdd']), FILTER_SANITIZE_STRING);
    $question = filter_var(trim($_POST['questionAdd']), FILTER_SANITIZE_STRING);
    if (!isset($_SESSION)) { session_start(); }
    $login=$_SESSION["user"];
    $result = $pdo->prepare("SELECT COUNT(*) as c FROM surveys where id=? and login=?");
    $result->bindValue(1, $surveyId, PDO::PARAM_INT);
    $result->bindValue(2, $login, PDO::PARAM_STR);
    $result->execute();
    $count=$result->fetch();
    if ($count['c']>0)
    {
    $result=$pdo->prepare("INSERT INTO surveyquestion (surveyId, question) VALUES (?,?)");
    $result->bindValue(1,$surveyId, PDO::PARAM_INT);
    $result->bindValue(2,$question, PDO::PARAM_STR);
    $result->execute();
    }

?>