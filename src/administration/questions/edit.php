<?php

    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';

    $questionId = filter_var(trim($_POST['questionIdEdit']), FILTER_SANITIZE_STRING);
    $question = filter_var(trim($_POST['questionEdit']), FILTER_SANITIZE_STRING);
    if (!isset($_SESSION)) { session_start(); }
    $login=$_SESSION["user"];
    $result = $pdo->prepare("UPDATE surveyquestion , surveys  
    SET question=? WHERE surveys.id = surveyquestion.surveyId and surveyquestion.id=? and login=?");
    $result->bindValue(1, $question, PDO::PARAM_STR);
    $result->bindValue(2, $questionId, PDO::PARAM_INT);
    $result->bindValue(3, $login, PDO::PARAM_STR);
    $result->execute();
?>