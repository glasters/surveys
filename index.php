<?php require_once './src/header.php' ?>

<!-- Определяем авторизован ли пользователь -->
<?php
$user = $_SESSION["user"];
?>
<section class="wrapper">
    <div class="container my-3">
        <!-- Только зарегистрированным пользователям доступен функционал -->
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/auth/auth-security.php';
        ?>
        <!-- Загружаем список опросов в выпадающий список -->
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';
        $login = $_SESSION["user"];

        $result = $pdo->query("SELECT `title`,`idHash` FROM `surveys` where `login`='$login'");
        ?>
        <div class="dropdown text-center">
            <button class="btn btn-secondary dropdown-toggle mb-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php if ($result == NULL) { ?>
                    Опросы не загружены
                <?php } else { ?>
                    Выберите опрос для прохождения
                <?php } ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php if ($result != NULL) { ?>
                    <?php while ($item = $result->fetch()) { ?>
                        <a class="dropdown-item" href="/take-survey.php?id=<?php echo $item['idHash'] ?>">
                            <?php echo $item['title'] ?>
                        </a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <?php
        //генерируем ссылки на отчеты в выпадающем списке
        $result = $pdo->query("SELECT * FROM `surveys` where `login`='$login'");
        ?>
        <div class="dropdown text-center">
            <button class="btn btn-secondary dropdown-toggle mb-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php if ($result == NULL) { ?>
                    Отчеты по вопросам не загружены
                <?php } else { ?>
                    Выберите отчет по вопросам
                <?php } ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php if ($result != NULL) { ?>
                    <?php while ($item = $result->fetch()) { ?>
                        <a class="dropdown-item" href="/take-result.php?id=<?php echo $item['id'] ?>">
                            <?php echo $item['title'] ?>
                        </a>
                    <?php } ?>
                <?php }
                //генерируем ссылки на отчеты в выпадающем списке
                $result = $pdo->query("SELECT `title`,`id` FROM `surveys` where `login`='$login'"); ?>
            </div>
        </div>
        
        <div class="dropdown text-center">
            <button class="btn btn-secondary dropdown-toggle mb-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php if ($result == NULL) { ?>
                    Отчеты по пользователям не загружены
                <?php } else { ?>
                    Выберите отчет по по пользователям
                <?php } ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php if ($result != NULL) { ?>
                    <?php while ($item = $result->fetch()) { ?>
                        <a class="dropdown-item" href="/take-resultUser.php?id=<?php echo $item['id'] ?>">
                            <?php echo $item['title'] ?>
                        </a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <div class="mb-3 text-center">
            <a href="surveys.php" class="btn btn-secondary" role="button">Редактировать опросы</a>
        </div>
    </div>
</section>