<?php if (!isset($_SESSION)) { session_start(); } ?>
<!-- Таблица вопросов, с возможностью редактирования и удаления -->
<table class="table table-hover table-sm" style="text-align: center;" id="questionsTable">
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Вопрос</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';
    $surveyId=NULL;
    $surveyId = filter_var(trim($_GET['id']), FILTER_SANITIZE_STRING);
    if (isset($_POST['surveyId']))
    $surveyId = filter_var(trim($_POST['surveyId']), FILTER_SANITIZE_STRING);
    $login=$_SESSION["user"];

    if ($surveyId != NULL and isset($_SESSION["user"])) {
        $result = $pdo->prepare("SELECT surveyquestion.id,surveyquestion.surveyId,surveyquestion.question FROM surveyquestion join surveys on surveyquestion.surveyId=surveys.id  WHERE surveyId = ? and login=?");
        $result->bindValue(1, $surveyId, PDO::PARAM_INT);
        $result->bindValue(2, $login, PDO::PARAM_STR);
        $result->execute();
    }

    ?>
    <?php if ($result != NULL) {while ($item = $result->fetch()) { ?>
        <tr>
            <th scope="row"></th>
            <td><?= $item['question'] ?></td>

            <td hidden="true"><?= $item['id'] ?></td>
            <td hidden="true"><?= $item['surveyId'] ?></td>
            <td></td>
            <td><input type="submit" name="editQuestion" value="Изменить" class="btn btn-warning editQuestionBtn">
                <input type="submit" name="deleteQuestion" value="Удалить" class="btn btn-danger deleteQuestionBtn">
            </td>
        </tr>
    <?php }} ?>
</table>