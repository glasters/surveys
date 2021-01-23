<?php
if (!isset($_SESSION)) {
    session_start();
}
require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';
$surveyId = filter_var(trim($_POST['surveyIdTakeSurvey']), FILTER_SANITIZE_STRING); //hashId
$user = $_SESSION["user"];
$result = $pdo->prepare('SELECT count(*) as c FROM result WHERE result.user=? and result.surveyId=(SELECT id FROM surveys WHERE surveys.idHash=?)');
$result->bindValue(1, $user, PDO::PARAM_STR);
$result->bindValue(2, $surveyId, PDO::PARAM_STR);
$result->execute();
$count = $result->fetch();
if ($count['c'] > 0) {
    exit();
}
$result = $pdo->prepare('SELECT id FROM surveys where idHash=?');
$result->bindValue(1, $surveyId, PDO::PARAM_STR);
$result->execute();
$item = $result->fetch();
$id = $item['id'];
$answers = array();
$questionId = array();
$question = array();
$answer = array();
$countAnswer = 0;
foreach ($_POST as $key => $value) {
    if ($key != "surveyIdTakeSurvey") {

        $answers[$key] = $value;
        $questionId1 = explode('-', $key, 2)[0];
        $answer1 = $value;

        $result = $pdo->prepare('SELECT COUNT(*) as c FROM surveyquestion WHERE surveyquestion.surveyId=? and surveyquestion.id=?');
        $result->bindValue(1, $id, PDO::PARAM_INT);
        $result->bindValue(2, $questionId1, PDO::PARAM_INT);
        $result->execute();
        $m = $result->fetch();
        $f = $m['c'];

        if ($f > 0) {

            $questionId[] = $questionId1;
            $answer[] = $answer1;
        }


        $countAnswer += 1;
    }
}
if (count($answer) == $countAnswer) {
    $countToAdd = count($answer);
    for ($i = 0; $i < $countToAdd; $i++) {
        $result = $pdo->prepare('INSERT INTO result ( surveyId, questionId, user, answer) VALUES (?,?,?,?)');
        $result->bindValue(1, $id, PDO::PARAM_INT);
        $result->bindValue(2, $questionId[$i], PDO::PARAM_INT);
        $result->bindValue(3, $user, PDO::PARAM_STR);
        $result->bindValue(4, $answer[$i], PDO::PARAM_STR);
        $result->execute();
    }
}
