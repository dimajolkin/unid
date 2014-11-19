/**
 * Created by Develop on 09.10.14.
 */
$(document).ready(function(){

    $(document).keydown(function(event){
        //Отправка данных формы через Сочетания клавишь Cntr + Enter
        if($('button[type="submit"]').length)
        {
            if (event.which == 13 && event.ctrlKey) {
                console.log('click')
                $('button[type="submit"]').click();

            }
        }

    });


    var table = new Table();

    $('button[type="submit"]').click(function(){
        var anim = new Animation($(this));
        anim.setText('Идёт сохранение данных.. подождите')


        var form  = $('#DataTable');
        var Msg = new Message();
        Msg.clear()
//
//        if(table.validate() )
//        {
//            if(!anim.start())
//            {
                form.submit();
                /**
                 $.ajax({
                    utl: location.pathname,
                    type:"POST",
                    async: true,
                    data: form.serializeArray(),
                    success: function(){

                        badges.inc();
                        Msg.set('Данные успешно внесены в систему')
                        if($(this).attr('clear')){
                            table.clear()
                        }

                        anim.stop()
                    },
                    error: function(){
                        Msg.set_warning('Произошла непредвиненная ошибка')

                    }
                })
                 */
//            } else {
//
//                anim.stop()
//
//            }

//        } else {
//            return false
//        }


    })

});