<?php

    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';

    $answerId = filter_var($_POST['idAnswerEdit'], FILTER_SANITIZE_STRING);
    $answer = filter_var($_POST['answerEdit'], FILTER_SANITIZE_STRING);
    if (!isset($_SESSION)) { session_start(); }
    $login=$_SESSION["user"];
    $type="check";
    if (isset($_POST['check'])) $type="text";
    $result = $pdo->prepare("UPDATE surveyanswer join surveyquestion ON surveyquestion.id=surveyanswer.surveyIdQuestion join surveys ON surveys.id=surveyquestion.surveyId SET answer=?,type=? WHERE surveyanswer.id=? and surveys.login=?");
    $result->bindValue(1, $answer, PDO::PARAM_STR);
    $result->bindValue(2, $type, PDO::PARAM_STR);
    $result->bindValue(3, $answerId, PDO::PARAM_INT);
    $result->bindValue(4, $login, PDO::PARAM_STR);
    $result->execute();
?>