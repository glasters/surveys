<?php if (!isset($_SESSION)) { session_start(); }
?>
<!-- Таблица опросов, с возможностью редактирования и удаления -->      
<table class="table table-hover table-sm" style="text-align: center;" id="surveysTable">
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Название</th>
            <th scope="col">Ссылка</th>
            <th scope="col"></th>
        </tr>
    </thead>
        <?php
            require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';
            $login=$_SESSION["user"];
            $result = $pdo->query("SELECT * FROM `surveys`  where `login`='$login'");
        ?>
        
        <?php if ($result!==false) while($item = $result->fetch()) { ?>
            <tr>
            <th scope="row"></th>
            <td><?= $item['title'] ?></td>
            <td><a href="/take-survey.php?id=<?php echo $item['idHash'] ?>">http://surveys/take-survey.php?id=<?php echo $item['idHash'] ?></a></td>
            <td hidden="true"><?= $item['id'] ?></td>
            <td><input type="submit" name="editSurvey" value="Изменить" class="btn btn-warning editSurveyBtn">
                <input type="submit" name="deleteSurvey" value="Удалить" class="btn btn-danger deleteSurveyBtn"></td>
            </tr>
        <?php }?>
</table>