/**
 * Created by Develop on 01.09.14.
 */

$(document).ready(function(){
    $.ajaxSetup({
        type: "POST",
        async: true,
        cache: false
    });







    $("button[action][value]").click(function(){
        // Начальные настройки анимации..

        var Anim = new Animation( $(this) );
        Anim.setText('Подождите идёт запрос файла...');
        Anim.setImage('482.GIF');
        Anim.setProperty(151, 151);


        var value = $(this).attr("value");
        if( !Anim.isStart() )
        {
            var request =  $.ajax({
                url:'/user/document/generate',
                type: 'POST',
                data:{
                    document: value
                },
                success: function(html){
                    location.href = '/user/document/download?q='+value;
                },
                beforeSend: function(){
                    Anim.start();
                    console.log('beforeSend ');
                },
                complete : function(){
                    Anim.stop();
                    console.log('completed')
                }
            })

        }

      //

    })



});