<?php require_once './src/header.php' ?>
<!-- Прохождение опроса -->

<section class="wrapper">
    <div class="container w-50 my-3">
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/auth/auth-security.php';
        ?>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';

        $surveyId = filter_var(trim($_GET['id']), FILTER_SANITIZE_STRING);
        $login = $_SESSION["user"];
        $result = $pdo->prepare("SELECT count(*) as c FROM result WHERE result.user=? and result.surveyId=(SELECT id FROM surveys WHERE surveys.idHash=?) ");
        $result->bindValue(1, $login, PDO::PARAM_STR);
        $result->bindValue(2, $surveyId, PDO::PARAM_STR);
        $result->execute();
        $count = $result->fetch();
        if ($count['c'] > 0) {
            echo "Вы уже прошли тест";
            exit();
        }





        $result = $pdo->prepare("SELECT surveyquestion.id,surveyquestion.surveyId,surveyquestion.question,surveyanswer.id as 'idAnswer',surveyanswer.surveyIdQuestion,surveyanswer.type,surveyanswer.answer FROM surveyquestion join surveyanswer on surveyquestion.id=surveyanswer.surveyIdQuestion WHERE surveyquestion.surveyId=(SELECT id FROM surveys WHERE surveys.idHash=?)");
        $result->bindValue(1, $surveyId, PDO::PARAM_INT);
        $result->execute();
        ?>
        <?php if ($result != NULL) { ?>
            <form id="takeSurveyForm">
                <br>
                <?php $item_question;
                $i = 0;
                while ($item = $result->fetch()) {
                    newQuestion:
                    $item_question = $item['surveyIdQuestion'] ?>

                    <div class="form-group">
                        <label><?php echo $item['question'] ?></label>
                        <?php if ($item['type'] == 'check') { ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="<?php echo $item['id'] . '-' . $item['question']  ?>" id="<?php echo $item['id'] ?>_answer1" value="<?php echo $item['answer'] ?>" checked>
                                <label class="form-check-label" for="<?php echo $item['id'] ?>_answer1">
                                    <?php echo $item['answer'] ?>
                                </label>
                            </div>
                        <?php } else { ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="<?php echo $item['id'] . '-' . $item['question']  ?>" id="<?php echo $item['id'] ?>_answer1" value="<?php echo $item['answer'] ?>" checked>
                                <label class="form-check-label" for="<?php echo $item['id'] ?>_answer1">
                                    <input type="text" id=text class="form-control" value=<?php echo $item['answer'] ?>>
                                </label>
                            </div>


                        <?php } ?>
                        <?php while ($item = $result->fetch()) {
                            if ($item_question != $item['surveyIdQuestion']) {
                                goto newQuestion;
                            } ?>
                            <?php if ($item['type'] == 'check') { ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="<?php echo $item['id'] . '-' . $item['question']  ?>" id="<?php echo $item['id'] ?>_answer1" value="<?php echo $item['answer'] ?>">
                                    <label class="form-check-label" for="<?php echo $item2['id'] ?>_answer1">
                                        <?php echo $item['answer'] ?>
                                    </label>
                                </div>
                            <?php } else { ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="<?php echo $item['id'] . '-' . $item['question']  ?>" id="<?php echo $item['id'] ?>_answer1" value="<?php echo $item['answer'] ?>">
                                    <label class="form-check-label" for="<?php echo $item['id'] ?>_answer1">
                                        <input type="text" id=text class="form-control" value=<?php echo $item['answer'] ?>>
                                    </label>
                                </div>
                            <?php } ?>
                        <?php } ?>

                    </div>
                <?php $i++;
                } ?>
                <?php if ($i > 0) { ?>
                    <input type="hidden" id="surveyIdTakeSurvey" name="surveyIdTakeSurvey" value="<?php echo $surveyId ?>">
                    <input type="submit" name="takeSurvey" value="Отправить" class="btn btn-success takeSurveyBtn">
                <?php } ?>
            </form>
        <?php } ?>
    </div>
</section>