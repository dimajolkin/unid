/**
 * Created by Ёлкин on 27.05.14.
 */
//Основной функциона работы сайта

$(document).ready(function(){
    var message = new Message();
    $.ajaxSetup({
        async:false,
        error: function(){
            message.set('Непредвиденная ошибка. повторите запрос')
        },
        beforeSend: function(){
            console.log('beforeSend ');
        },
        complete : function(){
            console.log('completed')
        }
    })


    console.log('load body')

    var tab_active = location.pathname.split('/')[1].toString();
    console.log(tab_active);
 if(tab_active == 'help'){
     var obj = $("a[href='#tab-user']");
     $(obj.attr('href')).addClass('active');
     obj.parent().addClass('active');
 }
    if(tab_active == 'user' || tab_active == 'kafedra')
    {

        $("li  a[href='"+location.pathname+"']").parent().each(function(){
            $(this).addClass("active");
        });


        var obj = $("a[href='#tab-"+tab_active+"']");
        $(obj.attr('href')).addClass('active');
        obj.parent().addClass('active');

    }



    $("a[ajax-href]").click(function(){
        var content =   $(this).attr('content');
        console.log('ajax-href')

        var url = $(this).attr('ajax-href');
        if(url != undefined)
        {
            var data_content = $(this).attr('data-content');
            if($(this).attr('modal') == 'true')
            {
                Windows(url, $(this).attr('cap'));

            } else
            {
                $.ajax({
                    url:url,
                    type:"GET",
                    async:false,
                    data: data_content,
                    success: function(html){
                        $(content).html(html);
                    },
                    error: function(){
                        alert('Erorr URl');
                    }
                })

            }

        } else {
            alert('Erorr Ajax-href (Not Url)');
        }

    })




});