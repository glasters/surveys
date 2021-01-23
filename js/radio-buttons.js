// управления переключателями в окне авторизации
$(document).ready(function () {
$("#radioBtn a").on("click", function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    
    if (sel == "Enter") {
        $('.enter').css('display', 'block');
        $('.registration').css('display', 'none');
    } else {
        $('.registration').css('display', 'block');
        $('.enter').css('display', 'none');
    }

    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
})
});