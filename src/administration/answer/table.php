<?php if (!isset($_SESSION)) {
    session_start();
}
?>
<!-- Таблица ответов, с возможностью редактирования и удаления -->
<div class="mb-3">
    <button class="btn btn-primary addAnswer" data-toggle="modal" data-target="#addAnswerModal">
        Добавить ответ
    </button>
</div>
<table class="table table-hover table-sm" style="text-align: center;" id="questionsTable">
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Ответ</th>
            <th scope="col">Тип</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';
    $login=$_SESSION["user"];
    $surveyIdQuestion = filter_var(trim($_POST['id']), FILTER_SANITIZE_STRING);
    $result = $pdo->prepare("SELECT * FROM surveyanswer  WHERE surveyIdQuestion = ?");
    $result->bindValue(1, $surveyIdQuestion, PDO::PARAM_INT);
    $result->execute();
    ?>

    <?php while ($item = $result->fetch()) { ?>
        <tr>
            <th scope="row"></th>
            <td><?= $item['answer']  ?></td>
            <td><?= $item['type']  ?></td>
            <td hidden="true"><?= $item['id'] ?></td>
            <td hidden="true"><?= $item['surveyIdQuestion'] ?></td>
            <td>
                <input type="submit" name="editAnswer" value="Изменить" class="btn btn-warning editAnswerBtn">
                <input type="submit" name="deleteAnswer" value="Удалить" class="btn btn-danger deleteAnswerBtn">
            </td>
        </tr>
    <?php } ?>
</table>