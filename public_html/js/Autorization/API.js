/**
 * Created by Develop on 08.07.14.
 */
$(document).ready(function(){
   var message = new Message();


    var Tuser = function(){
        this.login;
        this.password;

    }
    var Anim = null;
//Anim.hidden(false);

    var autorizatin = function(user, type, url){
        if( !Anim.start() )

        if((user.login != '' && user.password != ''))
        {
            $.ajax({
                url:'Autorization/inputajax',
                type:'POST',
                data:{
                    type: type,
                    login: user.login,
                    password: user.password
                },
                success: function(html){
                    var obj = JSON.parse(html)
                    console.log(obj)

                    if(obj.code != false )
                    {
                        // document.cookie = "login="+user.login;
                        Anim.stop();
                       location = obj.url;
                    } else {
                        message.set_error("Введен недопустимый или неизвестный идентификатор пользователя и/или пароль. Повторите попытку.");

                        //vkAlert('system','Введен недопустимый или неизвестный идентификатор пользователя и/или пароль. Повторите попытку.','error');

                        Anim.stop();
                    }

                },
                error: function()
                {

                }

            });


        } else {
            //alert('Данные введены не корректно')
            message.set_error("Не все поля заполнены");
            //vkAlert('system','Не все поля заполнены','error');
            Anim.stop();
        }

    }
    var Loader = function(this_){
        $(this_).html($('<div />',{"id":"loaderImage"}))
      //  new imageLoader(cImageSrc, 'startAnimation()');
    }

    $("#btn-autorization").click(function(){
     //   Loader(this);
        Anim = new Animation( $('#text_btn_autoriz') );

        message.Create($("#sys_msg_user"));
        var user = new Tuser();
        user.login = $('#inputLogin').val();
        user.password = $('#inputPassword').val();
        autorizatin(user, 'users', 'user');

    });


    $('#btn-autorization-kafedra').click(function(){
      //  Loader(this);
        Anim = new Animation( $('#text_btn_autoriz_kaf') );
        message.Create($("#sys_msg_kaf"));
        var user = new Tuser();
        user.login = $('#login-kaf').val();
        user.password = $('#inputPassword-kaf').val();
        autorizatin(user, 'kafedra','kafedra');
    });



});


