<?php require_once './src/header.php' ?>
<!-- Только зарегистрированным пользователям доступен функционал -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/auth/auth-security.php';
?>

<section class="wrapper">
    <div class="container my-3">
        <div class="mb-3">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addSurveyModal">
                Добавить опрос
            </button>
        </div>

        <div class="inline-table-surveys">
            <!-- Таблица опросов, с возможностью редактирования и удаления -->
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/administration/surveys/table.php'; ?>
        </div>

        <!-- Модальное окно формы добавления-->
        <div class="modal fade" id="addSurveyModal" tabindex="-1" role="dialog" aria-labelledby="addSModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSModalLabel">Добавить</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="addSurveyForm">
                        <div class="modal-body">
                            <input type="text" placeholder="Название" name="titleAdd" id="titleAdd" required class="form-control">
                            <br>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Сохранить">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Модальное окно с формой редактирования -->
        <div class="modal fade" id="editSurveyModal" tabindex="-1" role="dialog" aria-labelledby="editSModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSModalLabel">Изменить</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editSurveyForm">
                        <div class="modal-body">
                            <input type="text" placeholder="Название" name="titleEdit" id="titleEdit" required class="form-control">
                            <br>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Внести изменения">
                            <input type="hidden" id="idEdit" name="idEdit" value="">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Модальное окно формы добавления-->
        <div class="modal fade" id="addAnswerModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Добавить ответ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="addAnswerForm">
                        <div class="modal-body">
                            <input type="text" placeholder="Ответ" name="answerAdd" id="answerAdd" required class="form-control">
                            <br>
                            <div class="form-check">
                                <input type="checkbox" name="check" class="form-check-input" id="exampleCheck">
                                <label class="form-check-label" for="exampleCheck">Поле для ввода текста</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Сохранить">
                            <input type="hidden" id="questionIdA" name="questionIdA" value="">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Модальное окно с формой редактирования -->
        <div class="modal fade" id="editAnswerModal" tabindex="-1" role="dialog" aria-labelledby="editAModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAModalLabel">Изменить</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editAnswerForm">
                        <div class="modal-body">
                            <input type="text" placeholder="Вопрос" name="answerEdit" id="answerEdit" required class="form-control">
                            <br>
                            <div class="form-check">
                                <input type="checkbox" name="check" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck">Поле для ввода текста</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Внести изменения">
                            <input type="hidden" id="idAnswerEdit" name="idAnswerEdit" value="">
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <?php
        $surveyId = filter_var(trim($_GET['id']), FILTER_SANITIZE_STRING);
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';

        ?>
        <div class="dropdown text-center">
            <button class="btn btn-secondary dropdown-toggle mb-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php if ($surveyId != NULL) { ?>
                    <?php echo filter_var(trim($_GET['title']), FILTER_SANITIZE_STRING); ?>
                <?php } else { ?>
                    Редактировать вопросы
                <?php } ?>
            </button>
            <div class="dropdown-menu surveysMenu" aria-labelledby="dropdownMenuButton">
                <?php
                //включаем выпадающий список опросов ссылками, содержащими Get запросы в файл
                 require_once $_SERVER['DOCUMENT_ROOT'] . '/src/administration/surveys/drop.php'; 
                 ?>
            </div>
        </div>

        <?php if ($surveyId != NULL) { ?>
            <div class="mb-3">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addQuestionModal">
                    Добавить вопрос
                </button>
            </div>

            <div class="inline-table-questions">
                <!-- Таблица вопросов, с возможностью редактирования и удаления -->
                <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/administration/questions/table.php'; ?>
            </div>
            <div class="dropdown text-center">
                <button class="btn btn-secondary dropdown-toggle mb-3" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Редактировать ответы
                </button>
                <div class="dropdown-menu questionMenu" aria-labelledby="dropdownMenuButton2">
                    <?php if (!isset($_SESSION)) {
                        session_start();
                    }
                    $login = $_SESSION["user"];
                    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';
                    $result = $pdo->prepare("SELECT question,surveyquestion.id FROM surveyquestion join surveys on surveys.id=surveyquestion.surveyId where login=? and surveyId=?");
                    $result->bindValue(1, $login, PDO::PARAM_STR);
                    $result->bindValue(2, $surveyId, PDO::PARAM_INT);
                    $result->execute();
                    while ($item = $result->fetch()) { ?>
                        <button class="dropdown-item questionSelect" id=<?php echo $item['id'] ?> type="button"><?php echo $item['question'] ?></button>
                    <?php } ?>
                </div>

            </div>
            <div class="inline-table-answers">

            </div>

            <!-- Модальное окно с формой редактирования -->
            <div class="modal fade" id="editQuestionModal" tabindex="-1" role="dialog" aria-labelledby="editQModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editQModalLabel">Изменить</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editQuestionForm">
                            <div class="modal-body">
                                <input type="text" placeholder="Вопрос" name="questionEdit" id="questionEdit" required class="form-control">
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="Внести изменения">
                                <input type="hidden" id="surveyIdEdit" name="surveyIdEdit" value="<?php echo $surveyId ?>">
                                <input type="hidden" id="questionIdEdit" name="questionIdEdit" value="">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Модальное окно формы добавления-->
            <div class="modal fade" id="addQuestionModal" tabindex="-1" role="dialog" aria-labelledby="addQModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addQModalLabel">Добавить ответ</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="addQuestionForm">
                            <div class="modal-body">
                                <input type="text" placeholder="Вопрос" name="questionAdd" id="questionAdd" required class="form-control">
                                <br>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" value="Сохранить">
                                    <input type="hidden" id="surveyIdAdd" name="surveyIdAdd" value="<?php echo $surveyId ?>">
                                </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php } ?>

    </div>


</section>