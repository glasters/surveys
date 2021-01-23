<?php
require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';

$title = filter_var(trim($_POST['titleAdd']), FILTER_SANITIZE_STRING);

$idHash = uniqid('', true);
if (!isset($_SESSION)) {
    session_start();
}
$login = $_SESSION["user"];
$i=0;
do{
$result=$pdo->query("SELECT count(*) as c FROM `surveys` where `idHash`='$idHash'");
$idHash = uniqid('', true);
$i=$result->fetch();
}while($i['c']>0);
if (isset($_SESSION["user"])) {
    $result = $pdo->prepare('INSERT INTO surveys (title,idHash,login) VALUES (?,?,?)');
    $result->bindValue(1, $title, PDO::PARAM_STR);
    $result->bindValue(2, $idHash, PDO::PARAM_STR);
    $result->bindValue(3, $login, PDO::PARAM_STR);

    $result->execute();
}
?>
