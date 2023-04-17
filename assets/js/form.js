$(function(){
‘use strict’;
    $(‘#form’).on(‘submit’, function(e){
        e.preventDefault();
        var fd = new FormData( this );
        $.ajax({
            url: ‘send.php’,
        type: ‘POST’,
        contentType: false,
            processData: false,
            data: fd,
            success: function(msg){
            if(msg == ‘ok’) {
                alert('Отправлено');
            } else {
                alert('Ошибка')
            }
        }
    });
    });
});
