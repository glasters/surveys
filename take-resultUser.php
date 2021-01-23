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
        $page = 1;
        if (isset($_GET['page'])) {
            if (filter_var($_GET['page'], FILTER_VALIDATE_INT))
                $page = $_GET['page'];
        }
        $result = $pdo->prepare("SELECT title FROM surveys WHERE surveys.login=? and surveys.id=? ");
        $result->bindValue(1, $login, PDO::PARAM_STR);
        $result->bindValue(2, $surveyId, PDO::PARAM_INT);
        $result->execute();
        $title = $result->fetch();
        $testName = $title['title'];
        $result = $pdo->prepare("SELECT questionId,answer,question,result.user FROM result JOIN surveys ON result.surveyId=surveys.id JOIN surveyquestion ON surveyquestion.id=result.questionId WHERE result.surveyId=? and result.user=(SELECT distinct user FROM result LIMIT ?, 1) ");
        $result->bindValue(1, $surveyId, PDO::PARAM_INT);
        $result->bindValue(2, $page-1, PDO::PARAM_INT);
        $result->execute();
        ?>
        <?php
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('&', $url);
        $url = $url[0];
        $result2 = $pdo->query("SELECT COUNT(distinct user) as c FROM result WHERE surveyId='$surveyId'");
        $c = $result2->fetch();
        if ($page <= 1) {

        ?>
            <ul class="pagination">
                <?php if ((int)$c['c'] > 0) { ?>
                    <li class="page-item"><a class="page-link">1</a></li>
                <?php } ?>
                <?php if ((int)$c['c'] > 1) { ?>
                    <li class="page-item"><a class="page-link" href="<?php echo $url, '&page=2' ?>">2</a></li>
                <?php } ?>
            </ul>
        <?php } else {

        ?>
            <ul class="pagination">
                <?php if ((int)$c['c'] > ($page - 1)) { ?>
                    <li class="page-item"><a class="page-link" href="<?php echo $url, '&page=', ($page - 1) ?>"><?php echo $page - 1 ?></a></li>
                <?php }
                if ((int)$c['c'] >= ($page)) {  ?>
                    <li class="page-item"><a class="page-link"><?php echo $page ?></a></li>
                <?php }
                if ((int)$c['c'] >= ($page + 1)) { ?>
                    <li class="page-item"><a class="page-link" href="<?php echo $url, '&page=', ($page + 1) ?>"><?php echo ($page + 1) ?></a></li>
                <?php } ?>
            </ul>

        <?php  } ?>
        <?php if ($result != NULL) { ?>

            <?php $item_question;
            $i = 1;
            while ($item = $result->fetch()) { ?>
                <dl class="row">
                    <dt class="col-sm-3 testLabel">Опрос: </dt>
                    <dd class="col-sm-9 testName"><?php echo $testName ?></dd>

                    <dt class="col-sm-3 userLabel">Пользователь: </dt>
                    <dd class="col-sm-9 userName"><?php echo $item['user'] ?></dd>
                </dl>
                <div class="mb-3">
                    <button class="btn btn-danger deleteUserResult" >
                        Удалить ответы пользователя
                    </button>
                </div>
                <?php
                newAnswer:
                $item_question = $item['questionId'] ?>

                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center active">
                        <?php echo $i++, '. ', $item['question'] ?>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo $item['answer'] ?>

                    </li>
                    <?php while ($item = $result->fetch()) {
                        if ($item_question != $item['questionId']) {
                            goto newAnswer;
                        } ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo $item['answer'] ?>

                        </li>
                    <?php } ?>

                </ul>
        <?php }
        } ?>
    </div>
</section>