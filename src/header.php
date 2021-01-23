<?php if (!isset($_SESSION)) {
    session_start();
} ?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">

    <link rel="stylesheet" href="/css/style.css">


    <link rel="stylesheet" href="css/bootstrap.min.css">

    <script src="/js/jquery-3.5.1.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>


    <script type="text/javascript" src="/js/radio-buttons.js"></script>


    <script type="text/javascript" src="/js/ajax-handlers.js"></script>
    <title>Опросы</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="/">Главная</a>
            <!-- Проверка cookie для alert -->
            <div class="auth justify-content-end">
                <?php
                if ($_COOKIE['failedReg'] != '') {
                    echo "<script type='text/javascript'>alert('Пользователь с таким логином уже существует');</script>";
                }
                if ($_COOKIE['failedAuth'] != '') {
                    echo "<script type='text/javascript'>alert('Неверный логин или пароль');</script>";
                }
                if ($_COOKIE['goodReg'] != '') {
                    echo "<script type='text/javascript'>alert('Регистрация успешно завершена, теперь Вы можете авторизоваться');</script>";
                }
                ?>
                <!-- Проверяем наличие авторизации -->
                <?php if (!isset($_SESSION["user"])) : ?>
                    <button class="btn btn-outline-danger my-2 my-sm-0 btn-width " data-toggle="modal" data-target="#authModal">Вход | Регистрация</button>
                <?php else : ?>
                    <form action="/src/auth/exit.php" method="post">
                        <button class="btn btn-outline-danger my-2 my-sm-0">Выход</button>
                    </form>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <!-- Модальное окно, вызывается принажатии кнопки "Вход | Регистрация" -->
    <div class="modal" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authModalLabel">Опросы</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <!-- radio-buttons.js -->
                        <div class="change-auth">
                            <div class="input-group">
                                <div id="radioBtn" class="btn-group">
                                    <a class="btn btn-primary btn-sm active" data-toggle="acc" data-title="Enter">Вход</a>
                                    <a class="btn btn-primary btn-sm notActive" data-toggle="acc" data-title="Registration">Регистрация</a>
                                </div>
                            </div>
                        </div>
                        <div class="enter">
                            <form action="/src/auth/enter.php" method="post">
                                <input type="text" class="form-control" name="login" placeholder="Введите логин" pattern="^[a-zA-Z][a-zA-Z0-9-_.]{2,255}$" required><br>
                                <input type="password" class="form-control" name="pass" placeholder="Введите пароль" required><br>
                                <button class="btn btn-success" type="submit">Войти</button>
                            </form>
                        </div>
                        <div class="registration">
                            <form action="/src/auth/registration.php" method="post">
                                <input type="text" class="form-control" name="login" placeholder="Введите логин" required pattern="^[a-zA-Z][a-zA-Z0-9-_.]{2,255}$" minlength="3" maxlength="30"><br>
                                <input type="password" class="form-control" name="pass" placeholder="Введите пароль"><br>
                                <button class="btn btn-success" type="submit">Зарегистрировать</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>