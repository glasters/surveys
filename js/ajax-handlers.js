$(document).ready(function () {
    

    // добавление вопроса
    $("body").on("submit", "#addQuestionForm", function (e) {

        let surveyId = surveyIdAdd.value;
        $.ajax({
            url: "/src/administration/questions/add.php",
            type: "POST",
            data: $('#addQuestionForm').serialize(),
            success: function (response) {
                $("#addQuestionModal").modal('hide');
                
                document.location.reload();
            }
        });
        e.preventDefault();
    });

    // удаление вопроса
    $("body").on("click", ".deleteQuestionBtn", function () {
        let tds = $(this).parent('td').siblings('td');
        let row = [];
        $.each(tds, function (i, c) {
            row.push($(c).text());
        });
        let id = row[1];
        let surveyId = row[2];
        $.ajax({
            url: "/src/administration/questions/delete.php",
            type: "POST",
            data: { id: id },
            success: function (response) {
                document.location.reload();
            }
            
        });
    });

    // передать данные в форму изменения вопроса
    $("body").on("click", ".editQuestionBtn", function (e) {
        let tds = $(this).parent('td').siblings('td');
        let row = [];
        $.each(tds, function (i, c) {
            row.push($(c).text());
        });
        $('#questionEdit').val(row[0]);
        $('#questionIdEdit').val(row[1]);
        $('#surveyIdEdit').val(row[2]);
        $("#editQuestionModal").modal();
    });

    // изменение вопроса
    $("body").on("submit", "#editQuestionForm", function (e) {
        let surveyId = surveyIdEdit.value;
        $.ajax({
            url: "/src/administration/questions/edit.php",
            type: "POST",
            data: $('#editQuestionForm').serialize(),
            success: function (response) {
                $("#editQuestionModal").modal('hide');
                $.ajax({
                    url: "/src/administration/questions/table.php",
                    cache: false,
                    type:"POST",
                    data: { surveyId: surveyId }
                }).done(function (html) {
                    $(".inline-table-questions").html(html);
                });
                
            }
        });
        e.preventDefault();
    })
    //Выбор вопроса для добавления ответов
    $("body").on("click", ".questionSelect", function (e) {
        let id = $(this)[0].id;
        let text = $(this)[0].innerText;
        $('#questionIdA').val(id);
        $('#dropdownMenuButton2').html(text);
        $.ajax({
            url: "/src/administration/answer/table.php",
            type: "POST",
            data: {id:id}
        }).done(function (html) {
            $(".inline-table-answers").html(html);
        });
    });
    // добавление ответа
    $("body").on("submit", "#addAnswerForm", function (e) {
        $.ajax({
            url: "/src/administration/answer/add.php",
            type: "POST",
            data: $('#addAnswerForm').serialize(),
            success: function (response) {
                $("#addAnswerModal").modal('hide');
                let id=$('#questionIdA').val();
                $.ajax({
                    url: "/src/administration/answer/table.php",
                    type: "POST",
                    data: {id:id}
                }).done(function (html) {
                    $(".inline-table-answers").html(html);
                });
                $("#answerAdd").val('');
            }
        });
        e.preventDefault();
    });
    //удаление ответа
    $("body").on("click", ".deleteAnswerBtn", function () {
        let tds = $(this).parent('td').siblings('td');
        let row = [];
        $.each(tds, function (i, c) {
            row.push($(c).text());
        });
        let id = row[2];
        $.ajax({
            url: "/src/administration/answer/delete.php",
            type: "POST",
            data: { id: id },
            success: function (response) {
                let id=$('#questionIdA').val();
                $.ajax({
                    url: "/src/administration/answer/table.php",
                    type: "POST",
                    data: {id:id}
                }).done(function (html) {
                    $(".inline-table-answers").html(html);
                });
            }
        });
    });
    // добавление опроса
    $("body").on("submit", "#addSurveyForm", function (e) {
        $.ajax({
            url: "/src/administration/surveys/add.php",
            type: "POST",
            data: $('#addSurveyForm').serialize(),
            success: function (response) {
                $("#addSurveyModal").modal('hide');
                $.ajax({
                    url: "/src/administration/surveys/table.php",
                    cache: false,
                }).done(function (html) {
                    $(".inline-table-surveys").html(html);
                });
                $.ajax({
                    url: "/src/administration/surveys/drop.php",
                    cache: false,
                }).done(function (html) {
                    $(".surveysMenu").html(html);
                });
                $("#titleAdd").val('');
            }
        });
        e.preventDefault();
    });
    // изменение ответа
    $("body").on("submit", "#editAnswerForm", function (e) {
        $.ajax({
            url: "/src/administration/answer/edit.php",
            type: "POST",
            data: $('#editAnswerForm').serialize(),
            success: function (response) {
                let id=$('#questionIdA').val();
                $("#editAnswerModal").modal('hide');
                $.ajax({
                    url: "/src/administration/answer/table.php",
                    type: "POST",
                    data:{id: id}
                }).done(function (html) {
                    $(".inline-table-answers").html(html);
                });
            }
        });
        e.preventDefault();
    });
    // удаление опроса
    $("body").on("click", ".deleteSurveyBtn", function () {
        let tds = $(this).parent('td').siblings('td');
        let row = [];
        $.each(tds, function (i, c) {
            row.push($(c).text());
        });
        let id = row[2];
        $.ajax({
            url: "/src/administration/surveys/delete.php",
            type: "POST",
            data: { id: id },
            success: function (response) {
                document.location.reload();
            }
        });
    });
    // передать данные в форму изменения ответа
    $("body").on("click", ".editAnswerBtn", function (e) {
        let tds = $(this).parent('td').siblings('td');
        let row = [];
        $.each(tds, function (i, c) {
            row.push($(c).text());
        });
        $('#answerEdit').val(row[0]);
        if (row[1]=="check")
        $('#exampleCheck1').prop('checked', false);
        else
        $('#exampleCheck1').prop('checked', true);

        $('#idAnswerEdit').val(row[2]);
        $("#editAnswerModal").modal();
    });

    // передать данные в форму изменения опроса
    $("body").on("click", ".editSurveyBtn", function (e) {
        let tds = $(this).parent('td').siblings('td');
        let row = [];
        $.each(tds, function (i, c) {
            row.push($(c).text());
        });
        $('#titleEdit').val(row[0]);
        $('#idEdit').val(row[2]);
        $("#editSurveyModal").modal();
        e.preventDefault();
    });

    // изменение опроса
    $("body").on("submit", "#editSurveyForm", function (e) {
        $.ajax({
            url: "/src/administration/surveys/edit.php",
            type: "POST",
            data: $('#editSurveyForm').serialize(),
            success: function (response) {
                $("#editSurveyModal").modal('hide');
                $.ajax({
                    url: "/src/administration/surveys/table.php"
                }).done(function (html) {
                    $(".inline-table-surveys").html(html);
                });
            }
        });
        e.preventDefault();
    })
    //изменение отправляемого значения
    $('#text').on('input', function(){
    let t=$(this).val();
    $(this).parent().prev('input.form-check-input').val(t);
    });

    // добавление результата опроса
    $("body").on("submit", "#takeSurveyForm", function (e) {
        $.ajax({
            url: "/src/user/result/add.php",
            type: "POST",
            data: $('#takeSurveyForm').serialize(),
            success: function (response) {
                alert("Результат успешно отправлен");
                window.location.href = '/';
            }
        });
        e.preventDefault();
    });
    $("body").on("click", ".deleteUserResult", function (e) {
        let user = $(".userName").text();
        let searchParams = new URLSearchParams(window.location.search);
        let id = searchParams.get('id');
        $.ajax({
            url: "/src/administration/result/delete.php",
            type: "POST",
            data: { id: id, user:user },
            success: function (response) {
                document.location.reload();
            }
        });
        e.preventDefault();
    });
});

