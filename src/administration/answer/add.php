<?php
    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';

    $question = filter_var($_POST['questionIdA'], FILTER_SANITIZE_STRING);
    $answer = filter_var($_POST['answerAdd'], FILTER_SANITIZE_STRING);
    $type="check";
    if (isset($_POST['check'])) $type="text";
    if (!isset($_SESSION)) { session_start(); }
    $login=$_SESSION["user"];
    $result = $pdo->prepare("SELECT COUNT(*) as c FROM surveyquestion JOIN surveys ON surveys.id=surveyquestion.surveyId  WHERE surveyquestion.id=? and surveys.login=?");
    $result->bindValue(1, $question, PDO::PARAM_INT);
    $result->bindValue(2, $login, PDO::PARAM_STR);
    $result->execute();
    $count=$result->fetch();
    if ($count['c']>0)
    {
    $result = $pdo->prepare("INSERT INTO surveyanswer (answer, surveyIdQuestion,type) VALUES (?, ?,?)");
    $result->bindValue(1, $answer, PDO::PARAM_STR);
    $result->bindValue(2, $question, PDO::PARAM_STR);
    $result->bindValue(3, $type, PDO::PARAM_STR);
    $result->execute();
    }
?>