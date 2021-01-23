<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once './src/header.php'
?>

<section class="wrapper">
    <div class="container w-50 my-3">
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/auth/auth-security.php';
        ?>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';

        $surveyId = filter_var(trim($_GET['id']), FILTER_SANITIZE_STRING);
        $login = $_SESSION["user"];
        $result = $pdo->prepare("SELECT count(*) as c FROM surveys WHERE surveys.login=? and surveys.id=? ");
        $result->bindValue(1, $login, PDO::PARAM_STR);
        $result->bindValue(2, $surveyId, PDO::PARAM_INT);
        $result->execute();
        $count = $result->fetch();
        
        if ($count['c'] <= 0) {
            echo "Вам не доступны результаты опроса";
            exit();
        }
        $result = $pdo->prepare("SELECT title FROM surveys WHERE surveys.login=? and surveys.id=? ");
        $result->bindValue(1, $login, PDO::PARAM_STR);
        $result->bindValue(2, $surveyId, PDO::PARAM_INT);
        $result->execute();
        $title = $result->fetch();
        $testName=$title['title'];
        $result = $pdo->prepare("SELECT questionId,answer,question, COUNT(*) as c FROM result JOIN surveys ON result.surveyId=surveys.id JOIN surveyquestion ON surveyquestion.id=result.questionId WHERE result.surveyId=? GROUP BY questionId,answer,question  ORDER BY questionId");
        $result->bindValue(1, $surveyId, PDO::PARAM_INT);
        $result->execute();
        ?>
        <?php if ($result != NULL) { ?>
            <h2><?php echo 'Опрос: ', $testName ?> </h2>
            <?php $item_question;
            $i = 1;
            while ($item = $result->fetch()) {
                newAnswer:
                $item_question = $item['questionId'] ?>
                
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center active">
                        <?php echo $i++, '. ', $item['question'] ?>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo $item['answer'] ?>
                        <span class="badge bg-primary rounded-pill"><?php echo $item['c'] ?></span>
                    </li>
                    <?php while ($item = $result->fetch()) {
                        if ($item_question != $item['questionId']) {
                            goto newAnswer;
                        } ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo $item['answer'] ?>
                            <span class="badge bg-primary rounded-pill"><?php echo $item['c'] ?></span>
                        </li>
                    <?php } ?>

                </ul>
        <?php }
        } ?>
    </div>
</section>