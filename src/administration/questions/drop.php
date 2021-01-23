<?php if (!isset($_SESSION)) {
    session_start();
}
require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';
$login = $_SESSION["user"];
$surveyId = $_GET["id"];
if ($surveyId === null) $surveyId = $_POST["id"];
$result = $pdo->prepare("SELECT surveyquestion.id,surveyquestion.question FROM surveyquestion join surveys on surveys.id=surveyquestion.surveyId where login=? and surveyId=?");
$result->bindValue(1, $login, PDO::PARAM_STR);
$result->bindValue(2, $surveyId, PDO::PARAM_INT);
$result->execute();
while ($item = $result->fetch()) {  ?>
    <button class="dropdown-item" id=<?php echo $item['id'] ?> type="button"><?php echo $item['question'] ?></button>

<?php } ?>